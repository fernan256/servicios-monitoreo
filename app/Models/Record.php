<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
  protected $connection ='dns';
  protected $table = 'records';
  protected $fillable = [
      'id', 'domain_id', 'name', 'type', 'content', 'ttl', 'prio', 'change_date', 'auth'
  ];
  public $timestamps = false;
  public function domains()
  {
    return $this->belongsTo('App\Models\Domains');
  }
}
