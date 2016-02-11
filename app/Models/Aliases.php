<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aliases extends Model
{
  protected $connection ='mail';
  protected $table = 'aliases';

  public $timestamps = false;
}
