<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model
{
  protected $connection ='mail';
  protected $table = 'aliases';

  public $timestamps = false;
}