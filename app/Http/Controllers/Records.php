<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Record;

class Record extends Controller
{
  public function index() {
    $records = Record::all();
    return $records;
  }
}
