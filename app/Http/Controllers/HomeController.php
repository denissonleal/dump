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
    // dd($hostnames->toArray());
    return view('list', ['hostnames' => $hostnames]);
  }
}
