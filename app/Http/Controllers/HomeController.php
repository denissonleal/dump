<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Hostname;
use DB;

class HomeController extends Controller
{
	public function anyIndex()
	{
		$hostnames = Hostname::orderBy('name')->get();
		foreach ($hostnames as $hostname) {
			$hostname->dump = $hostname->dumps()->orderBy('created_at', 'desc')->first();
		}
		$bytes = disk_free_space(storage_path('dumps'));
		$si_prefix = ['B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB'];
		$base = 1024;
		$class = min((int)log($bytes , $base) , count($si_prefix) - 1);
		// echo $bytes . '<br />';
		// echo sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] . '<br />';
		// dd($hostnames->toArray());
		return view('list', [
			'hostnames' => $hostnames,
			'free' => sprintf('%1.2f %s' , $bytes / pow($base,$class), $si_prefix[$class]),
		]);
	}

	public function anyIncrement(Request $in)
	{
		if ( $in->key == env('KEYINCREMENT') ) {
			$db = "photos_$in->database";
			$photo = DB::collection($db)->find($in->id);
			if ( $photo ) {
				return -1;
			}
			DB::collection($db)->insert([
				'_id' => new \MongoId($in->id),
				'picture' => new \MongoBinData(base64_decode($in->picture)),
			]);

			return 1;
		}
		return response('Unauthorized.', 401);
	}

	public function anyPhoto(Request $in, $database, $id)
	{
		$photo = DB::collection("photos_$database")->find($id);
		if ( $photo ) {
			return response($photo['picture']->bin)
				->header('Content-Type', 'image/jpeg');
		}
		else {
			return 'image not found';
		}
	}

}
