<?php namespace App\Console\Commands;

use DB;
use Storage;
use App\Increment;
use Ixudra\Curl\Facades\Curl;

class BackupIncrementCommand extends \Illuminate\Console\Command
{
	protected $signature = 'backup:increment';

	protected $description = 'backup incremental';

	private function send($name)
	{
		dump("$name.photos");
		config([
			"database.connections.conn-$name" => [
				'driver'   => 'mongodb',
				'host'     => env('DB_HOST', 'localhost'),
				'port'     => env('DB_PORT', 27017),
				'database' => $name,
				'username' => env('DB_USERNAME', ''),
				'password' => env('DB_PASSWORD', ''),
				'options' => [
					'db' => $name,
				],
			]
		]);
		$increment = Increment::whereDatabase($name)->first();
		if ( $increment ) {
			$photo = DB::connection("conn-$name")->collection('photos')->where('_id', '>', $increment->last_id)->first();
		}
		else {
			$photo = DB::connection("conn-$name")->collection('photos')->first();
			$increment = new Increment;
			$increment->database = $name;
		}
		if ( $photo && isset($photo['picture']) && isset($photo['picture']->bin) ) {
			// dd($photo['_id']->{'$id'});
			// dump($photo['picture']);
			// dump(base64_encode($photo['picture']->bin));
			$response = Curl::to(str_finish(env('URLINCREMENT'), '/') . '/increment')->withData([
				'key' => env('KEYINCREMENT'),
				'database' => $name,
				'id' => $photo['_id']->{'$id'},
				'picture' => base64_encode($photo['picture']->bin),
			])->asJson()->post();
			dump($response);
			if ( $response == 1 ) {
				$increment->last_id = $photo['_id']->{'$id'};
				$increment->save();
			}
		}
		// dump(DB::connection("conn-$name")->collection('photos')->raw()->count());
	}

	public function handle()
	{
		echo date('Y-m-d H:i:s') . "\n";
		if ( !Storage::has('using') ) {
			Storage::put('using', 1);
			$dbdefault = config('database.connections.'.config('database.default').'.database');
			$list_dbs = DB::getMongoClient()->listDBs();
			$list_dbs = isset($list_dbs['databases']) ? $list_dbs['databases'] : [];
			// dump($list_dbs);
			foreach ($list_dbs as $db) {
				$name = $db['name'];
				if ( !in_array($name, ['admin', 'local', $dbdefault]) ) {
					$i = 150;
					do {
						$this->send($name);
					} while (str_contains($name, 'petrolina') && $i-- > 0);
				}
			}
			Storage::delete('using');
		}
		echo date('Y-m-d H:i:s') . "\n";
	}
}
