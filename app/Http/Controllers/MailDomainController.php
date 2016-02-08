<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Maildomain;

class MailDomainController extends Controller
{
    public function index()
    {
      $maildomain = Maildomain::all();
      return $maildomain;
    }
}
