<?php namespace App;

use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Hostname extends \Moloquent
{
  use SoftDeletes;
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
