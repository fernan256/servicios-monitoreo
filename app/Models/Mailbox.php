<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mailbox extends Model
{
  protected $connection ='mail';
  protected $table = 'users';

  public $timestamps = false;
}
