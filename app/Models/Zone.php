<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
  protected $connection ='dns';
  protected $table = 'zones';
  protected $fillable = [
      'id', 'domain_id', 'owner', 'comment', 'zone_templ_id'
  ];
  public $timestamps = false;
  public function domains()
  {
    return $this->belongsTo('App\Models\Domains');
  }
}
