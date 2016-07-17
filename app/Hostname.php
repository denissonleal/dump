<?php namespace App;

class Hostname extends \Moloquent
{
  protected $fillable = ['name'];

  public function dumps()
  {
    return $this->hasMany('App\Dump');
  }

  public function setNameAttribute($value)
  {
    $this->attributes['name'] = strtolower($value);
  }
}
