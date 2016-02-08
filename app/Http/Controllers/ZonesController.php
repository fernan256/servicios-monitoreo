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
  public function create() {
    $master = new Domain();
    return View::make('add_master.save')->with('master', $master);
  }
  //guardo en db
  public function store(Request $request) {
    //var_dump($request);
    $name = $request->input('data.name');
    if ($name != null) {

      $dominio = Domain::where('name', '=', $name)->first();

      if ($dominio != null) {
        return 'dominio existente';
        //return Redirect::to('add_master/create')->with('notice', 'La zona ya existe');
      }
      $master = new Domain();
      $master->name = $request->input('data.name');
      $master->type = $request->input('data.type');
      $master->save();
      $id = $master->id; //obtengo id del ultimo registro que inserto

      // tabla records

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
      // tabla zones

      $zones = new Zone();
      $zones->domain_id = $id;
      $zones->owner = '1';
      $zones->comment = '';
      $zones->zone_templ_id= '0';
      $zones->save();

      return $master;
      //return Redirect::to('/')->with('notice', 'La zona ha sido creada correctamente.');
      }
      else {
        return 'error';
        //return Redirect::to('add_master/create')->with('notice', 'oops!');
      }
  }

  // public function store()
  //   {
  //       Domain::create(array(
  //           'name' => Input::get('name'),
  //           'master' => Input::get('master'),
  //           'last_check' => Input::get('last_check'),
  //           'type' => Input::get('type'),
  //           'notified_serial' => Input::get('notified_serial'),
  //           'account' => Input::get('account'),
  //
  //       ));
  //
  //       return Response::json(array('success' => true));
  //   }
}
