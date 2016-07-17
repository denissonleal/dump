<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Hostname;

class HomeController extends Controller
{
  public function anyIndex()
  {
    $hostnames = Hostname::all();
    foreach ($hostnames as $hostname) {
      $hostname->dumps;
    }
		dump($hostnames->toArray());
  }
}
