<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UploadDatabaseController extends Controller
{
	public function upload()
	{
		$zips = glob(base_path('storage/dumps/') . 'cidade-saudavel*.7z', GLOB_BRACE);
		//$zips = explode('dumps/', end($zips))[1];
		//dd($zips);
		
		$cmd = "7z l " . end($zips) . " | grep D.... | grep dump/ | tr -s ' ' | cut -d\" \" -f 6";
		$results_command = shell_exec($cmd);
		$cities = explode('dump/', $results_command);
		unset($cities[0]);

		$cities = str_replace("\n", "", $cities);
		$dates = array();
		$bases = array();

		foreach ($zips as $key => $value) {
			array_push($dates, date("d/m/Y", filectime($value)));
			array_push($bases, $value);
		}

		return view('upload')->with('cities', $cities)
							->with('dates', $dates)
							->with('bases', $bases);
	}

	public function script(Request $request)
	{	
		// dd($request->toArray());
		$data = explode(':', $request->bases);
		// dd($data);
		$date_mongo = str_replace('/', '-', $data[1]);
		// dd($date_mongo);
		$dumps = implode(' dump/', $request->cities);
		$cmd_unzip = "7z x $data[0] dump/$dumps";
		$results_command_zip = shell_exec('cd ' . base_path('storage/dumps') . ";{$cmd_unzip}");
		// dump($results_command_zip);
		foreach ($request->cities as $value) {
			$cmd_mongo =  "mongorestore --host 10.0.0.12 --db $value-$date_mongo " . base_path("storage/dumps/dump/{$value}");
			$results_command_mongo = shell_exec('cd ' . base_path('storage/dumps') . ";{$cmd_mongo}");
			// dd($cmd_mongo);
		}
		return 'true';


	}
}
