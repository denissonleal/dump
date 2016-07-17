<?php namespace App\Http\Middleware;

use Closure;
use Log;
use Illuminate\Contracts\Auth\Guard;

class ApplicationStart
{
  public function handle($request, Closure $next)
  {
    $GLOBALS['time_start_application'] = microtime(true);

    if(config('app.debug')) {
      header('Access-Control-Allow-Origin: *');
    }
    $all = $request->all();
    if(isset($all['photo']))  $all['photo'] = str_limit($all['photo']);
    $q = '/' . (isset($all['q']) ? $all['q'] : '');
    unset($all['q']);
    unset($all['password']);

    Log::info("ACCESS $q", $all);

    return $next($request);
  }

  public function terminate($request, $response)
  {
    if ( $response->status() == 200 ) {
      $q = $request->get('q');
      $q = '/' . (isset($q) ? $q : '');

      Log::info("FINISH $q", [
        'time' => number_format(microtime(true)-$GLOBALS['time_start_application'], 3, '.', ' '),
        'size' => number_format(strlen($response->content()), 1, '.', ' ')
      ]);
    }
  }
}
