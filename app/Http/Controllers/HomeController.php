<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Hostname;

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
}
