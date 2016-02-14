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
    $this->middleware('jwt.auth');
  }
  public function index() {
    $records = Record::all();
    return $records;
  }
  public function show($id) {
    $records = Record::where('id', '=', $id)->get();
    return $records;
  }

  public function store(Request $request) {
		$dominio = '.'.$request->input('data.domain');
    $name = $request->input('data.name',null);
    if ($name != null) {
     	$record = Record::where('name', '=', $name)->first();
    	if ($record != null) {
      	return response()->json(['error' => 'record_exist'], 409);
			}
 			$name = $request->input('data.name',null).$dominio;
			//Record table
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
    	return response()->json(['success' => 'record_created']. 200);
		}
    else {
      return response()->json(['error' => 'record_exist'], 409);
		}
  }

 	public function update(Request $request) {
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
		}
		return response()->json(['success' => 'record_updated'], 200);
	}

	public function destroy($id) {
    $records = Record::where('id', '=', $id)-> delete();
    return response()->json(['success' => 'record_deleted'], 200);
  }
}
