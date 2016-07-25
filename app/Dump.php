<?php namespace App;

class Dump extends \Moloquent
{
  protected $fillable = ['name', 'size', 'hostname_id'];

  public function hostname()
  {
  	return $this->belongsTo('App\Hostname');
  }
}
