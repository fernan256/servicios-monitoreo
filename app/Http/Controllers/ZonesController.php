<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Domain;
use App\Models\Record;
use App\Models\Zone;

class ZonesController extends Controller
{
  public function store(Request $request) {
    $name = $request->input('data.name');
    if ($name != null) {
      $dominio = Domain::where('name', '=', $name)->first();

      if ($dominio != null) {
        return response()->json('notice', 'La zona ya existe');
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

      return response()->json('notice', 'La zona ha sido creada correctamente.');
    } else {
      return response()->json('notice', 'oops!');
    }
  }
  public function storeSlave(Request $request) {
    $name = $request->input('data.name',null);
    if ($name != null) {
      $dominio = Domain::where('name', '=', $name)->first();

      if ($dominio != null) {
        return response()->json('notice', 'La zona ya existe');
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

      return response()->json('notice', 'La zona ha sido creada correctamente.');
    }
    else {
      return response()->json('notice', 'oops!');
    }
  }
}