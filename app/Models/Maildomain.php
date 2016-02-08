<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maildomain extends Model
{
  protected $connection ='mail';
  protected $table = 'domains';

  public $timestamps = false;
}
