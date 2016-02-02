<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
  protected $connection ='dns';
  protected $table = 'domains';
  protected $fillable = [
      'id', 'name', 'master', 'last_check', 'type'
  ];
  public $timestamps = false;

  public function records(){
    return $this->hasMany('App\Models\Record');
  }
  public function zones(){
    return $this->hasMany('App\Models\Zones');
  }
}
