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
    // sleep(5);
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

  public function anySplit(Request $in)
  {
    if ( $in->hasFile('file') && $in->file('file')->isValid() ) {
      $hostname = Hostname::firstOrCreate([ 'name' => $in->hostname ]);

      $dump = $hostname->dumps()->whereName($in->name)->first();
      if ( !$dump ) {
        $dump = $hostname->dumps()->create([
          'name' => $in->name,
          'hostname_id' => $hostname->id
        ]);

        mkdir(storage_path("dumps/$hostname->name-$dump->name"));
      }

      $in->file('file')->move(storage_path("dumps/$hostname->name-$dump->name"),
                              $in->file('file')->getClientOriginalName());

      return '#';
    }
    return 'error';
  }

  public function anyJoin(Request $in)
  {
    $hostname = Hostname::firstOrCreate([ 'name' => $in->hostname ]);
    $dump = $hostname->dumps()->whereName($in->name)->first();
    $file = storage_path("dumps/$hostname->name-$dump->name");

    exec("cat $file/* > $file.7z");
    $dump->size = filesize("$file.7z");
    $dump->save();
    exec("rm -r $file");
  }
}
