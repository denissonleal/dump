<?php namespace App;

class Dump extends \Moloquent
{
  protected $fillable = ['name', 'size'];

  public function hostname()
  {
  	return $this->belongsTo('App\Hostname');
  }
}
