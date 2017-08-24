<?php namespace App\Console\Commands;

use DB;
use Storage;
use App\Increment;
use Ixudra\Curl\Facades\Curl;

class BackupIncrementCommand extends \Illuminate\Console\Command
{
	protected $signature = 'backup:increment {database?}';

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
			$photo = DB::connection("conn-$name")->collection('photos')->where('_id', '>', $increment->last_id)->orderBy('_id', 'asc')->first();
		}
		else {
			$photo = DB::connection("conn-$name")->collection('photos')->orderBy('_id', 'asc')->first();
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
				return $increment->last_id;
			}
		}
		return false;
		// dump(DB::connection("conn-$name")->collection('photos')->raw()->count());
	}

	public function handle()
	{
		$t0 = microtime(true);
		echo date('Y-m-d H:i:s') . "\n";
		if ( !Storage::has('using') ) {
			Storage::put('using', 1);
			$count = 0;
			if ( !$this->argument('database') ) {
				$dbdefault = config('database.connections.'.config('database.default').'.database');
				$list_dbs = DB::getMongoClient()->listDBs();
				$list_dbs = isset($list_dbs['databases']) ? $list_dbs['databases'] : [];
				// dump($list_dbs);
				$leftover_id = false;
				foreach ($list_dbs as $db) {
					$name = $db['name'];
					if ( !in_array($name, ['admin', 'local', $dbdefault]) ) {
						$id = $this->send($name);
						if ( $id ) $count++;
						if ( !$leftover_id || ($id && $id < $leftover_id) ) {
							$leftover_id = $id;
							$leftover_name = $name;
						}
					}
				}

				while ( ( 60*$count > ceil(microtime(true)-$t0)*($count+2) ) && $count++ && $this->send($leftover_name) ) {
					echo "$count leftover :)\n";
					// dump([microtime(true)-$t0, $count]);
				}
			}
			else {
				$name = $this->argument('database');
				while ( $this->send($name) ) echo ++$count ." \n";
			}
			Storage::delete('using');
		}
		echo date('Y-m-d H:i:s') . "\n";
	}
}
