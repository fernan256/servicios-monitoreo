<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Models\Domain;
use App\Models\Record;
use App\Models\Zone;

class DomainsController extends Controller
{
  public function __construct() {
   $this->middleware('jwt.auth');
  }
  public function index() {
    $domains = Domain::all();
    $domains = Domain::with('records')->get();
    return $domains;
  }
  public function showRecord($id) {
    $records = Record::where('domain_id', $id)->get();
    return $records;
  }
  public function show($id) {
    $domain = Domain::where('id', $id)->get();
    return $domain;
  }
  public function destroy($id) {
    $domain = Domain::find($id);
    if($domain = null) {
      return response()->json(['error' => 'domain_does_not_existe'], 400);
    }
    $domain_id = $id;
    $zones = Zone::where('domain_id', '=', $domain_id)-> delete();
    $records = Record::where('domain_id', '=', $domain_id)-> delete();
    $domain = Domain::where('id', '=', $id)-> delete();
    return response()->json(['success'], 200);
  }
}
