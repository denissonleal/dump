<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UploadDatabaseController extends Controller
{
	public function upload()
	{
		$zips = glob(base_path('storage/dumps/') . 'cidade-saudavel*.7z', GLOB_BRACE);
		$dates_zips = array();
		foreach ($zips as $key => $value) {
			preg_match('/cidade-saudavel-file-(\d{4}-\d{2}-\d{2})-\d{2}-\d{2}-\d{2}\.7z/', $value, $matches);
			array_push($dates_zips, $matches[1]);
		}

		return view('upload')->with('dates', $dates_zips)
							->with('bases', $zips);
	}

	public function copier(Request $request)
	{	
		$file_path = explode(':', $request->bases);
		$dumps = implode(' dump/', $request->cities);
		$cmd_unzip = "7z x $file_path[0] dump/$dumps";
		$results_command_zip = shell_exec('cd ' . base_path('storage/dumps') . ";{$cmd_unzip}");
		foreach ($request->cities as $value) {
			$cmd_mongo = "mongorestore --host 10.0.0.12 --db $value-$file_path[1] " . base_path("storage/dumps/dump/{$value}");
			$results_command_mongo = shell_exec('cd ' . base_path('storage/dumps') . ";{$cmd_mongo}");
		}

		echo 'true';
		$results_command_rm = shell_exec('cd ' . base_path('storage/dumps') . ";rm dump/ -R");


	}

	public function base(Request $request)
	{
		$file_path = explode(':', $request->date);
		$zips = glob(base_path('storage/dumps/') . 'cidade-saudavel*.7z', GLOB_BRACE);
		$zip = null;
		foreach ($zips as $key => $value) {
			if (strpos($value, $file_path[1])) {
				$zip = $value;
				break;
			}
		}

		$cmd = "7z l " . $zip . " | grep D.... | grep dump/ | tr -s ' ' | cut -d\" \" -f 6";
		$results_command = shell_exec($cmd);
		$cities = explode('dump/', $results_command);
		unset($cities[0]);

		$cities = str_replace("\n", "", $cities);
		$bases = array();

		return [
			'status' => 1,
			'cities' => $cities,
			'bases' => $zip,
		];

	}
}
