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

class ZonesController extends Controller
{
  public function __construct() {
    $this->middleware('jwt.auth');
  }
  public function store(Request $request) {
    $name = $request->input('data.name');
    if ($name != null) {
      $dominio = Domain::where('name', '=', $name)->first();

      if ($dominio != null) {
        return response()->json(['error' => 'zone_exists'], 409);
      }

      $master = new Domain();
      $master->name = $request->input('data.name');
      $master->type = $request->input('data.type');
      $master->save();
      $id = $master->id; //Get the las insert

      //Insert into Records
      $records= new Record();
      $records->domain_id = $id;
      $records->name = $request->input('data.name');
      $records->type = 'SOA';
      $records->content ='ns1.'.$request->input('data.name') .' hostmasters.'.$request->input('data.name').' ' .date("Ymd") ."00 28800 7200 604800 86400";
      $records->ttl = '86400';
      $records->prio = '0';
      $records->change_date = time();
      $records->auth = '1';
      $records->save();

      //Insert into Zones
      $zones = new Zone();
      $zones->domain_id = $id;
      $zones->owner = '1';
      $zones->comment = '';
      $zones->zone_templ_id= '0';
      $zones->save();

      return response()->json(['success' => 'zone_created'], 200);
    } else {
      return response()->json(['error' => 'zone_error'], 400);
    }
  }
  public function storeSlave(Request $request) {
    $name = $request->input('data.name',null);
    if ($name != null) {
      $dominio = Domain::where('name', '=', $name)->first();

      if ($dominio != null) {
        return response()->json(['error' => 'zoneSlave_exists'], 409);
      }
      $slave = new Domain();
      $slave->name = $request->input('data.name');
      $slave->master = $request->input('data.nameserver');
      $slave->type = 'SLAVE';
      $slave->save();
      $id = $slave->id;

      $zones = new Zone();
      $zones->domain_id = $id;
      $zones->owner = '1';
      $zones->comment = '';
      $zones->zone_templ_id= '0';
      $zones->save();

      return response()->json(['success' => 'zoneSlave_created'], 200);
    }
    else {
      return response()->json(['error' => 'zoneSlave_error'], 400);
    }
  }
}