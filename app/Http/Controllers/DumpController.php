<?php namespace App\Http\Controllers;

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
    $name = $in->file('file')->getClientOriginalName();
    // \Log::info('@@@', [
      $in->file('file')->move(storage_path(), $name);
    // ]);
    return '#';
  }
}
