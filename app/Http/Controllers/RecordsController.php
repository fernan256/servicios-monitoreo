<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Models\Record;

class RecordsController extends Controller
{
	   public function __construct() {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the authenticate method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => ['authenticate']]);
   }
  public function index() {
    $records = Record::all();
    return $records;
  }
  public function show($id) {
    //$id = $request->input('id');
    $records = Record::where('id', '=', $id)->get();
    return $records;
  }

   public function store(Request $request) {
		$dominio = '.'.$request->input('data.domain');
		echo $dominio;
    $name = $request->input('data.name',null);
    if ($name != null) {
     	$record = Record::where('name', '=', $name)->first();
    if ($record != null) {
      //return Redirect::to('list_zones')->with('notice', 'El registro ya existe');
		}
 		$name = $request->input('data.name',null).$dominio;
		// tabla records
    $records= new Record();
    $records->domain_id = $request->input('data.domain_id');
    $records->name = $request->input('data.name').$dominio;
    $records->type = $request->input('data.type');
		if ($request->input('data.content') == '') {
	    $records->content ='ns1.'.$request->input('data.domain') .' hostmasters.'.$request->input('data.domain').' ' .date("Ymd") ."00 28800 7200 604800 86400";
		} else {
			$records->content = $request->input('data.content');
		}
    $records->ttl = $request->input('data.ttl');
    $records->prio = $request->input('data.priority');
    $records->change_date = time();
    $records->auth = '1';
    $records->save();
    //return Redirect::to('list_zones')->with('notice', 'El registro ha sido creada correctamente.');
		}
    else {
      //return Redirect::to('list_zones')->with('notice', 'El nombre de registro ya existe');
		}
   }

   	public function update(Request $request) {
     	echo $request->input('data.name');
     	$id = $request->input('data.id');
			$record = Record::find($id);
			$record->name = $request->input('data.name');
			$record->type = $request->input('data.type');
			$record->content = $request->input('data.content');
			$record->prio = $request->input('data.priority');
			$record->ttl = $request->input('data.ttl');
			$record->auth = "1";
			$record->save();
			$domain_id= $record->domain_id;
			$type = $record->type;

			if($type == 'SOA') {
				$zone = Domain::find($domain_id);
			 	$zone->name = $request->input('data.name');
			 	$zone->save();
				//return Redirect::to('list_zones')->with('notice', 'El registro ha sido modificado correctamente.');
			} else {
				echo ('error');
				//return Redirect::to('list_zones')->with('notice', 'oops!');
			}
		}

		public function destroy($id) {
	    $records = Record::where('id', '=', $id)-> delete();
	    return response()->json('ok');
	  }
}
