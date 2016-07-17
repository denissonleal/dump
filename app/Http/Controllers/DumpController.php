<?php namespace App\Http\Controllers;

use App\Hostname;
use Illuminate\Http\Request;
/**
 * https://github.com/dutchcoders/transfer.sh
 * https://transfer.sh/
 *
 * curl -F "file=@./saudavel-2016-05-12.sql.gz" http://localhost:8000/dump
 */
class DumpController extends Controller
{
  public function anyIndex(Request $in)
  {
    if ( $in->hasFile('file') && $in->file('file')->isValid() ) {
      $hostname = Hostname::firstOrCreate([ 'name' => $in->hostname ]);

      $dump = $hostname->dumps()->create([
        'name' => $in->file('file')->getClientOriginalName(),
        'size' => $in->file('file')->getClientSize()
      ]);

      // \Log::info('@@@', [
      $in->file('file')->move(storage_path('dumps'), "$dump->id $dump->name");
      // ]);
    }
    return '#';
  }
}
