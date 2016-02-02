<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Domain;
use App\Models\Record;

class DomainsController extends Controller
{
  public function index() {
    $domains = Domain::all();
    $domains = Domain::with('records')->get();
    return $domains;
  }
  public function show(Request $request) {
    $id = $request->input('id');
    $records = Record::where('domain_id', '=', $id)->get();
    return $records;
  }
  public function destroy(Request $request) {
	  $aux = $request->input('hidden');
  	if ($aux == 'record' ) {
  		$records = Record::where('id', '=', $id)-> delete();
  		return Redirect::to('list_zones')->with('notice', 'El registro ha sido eliminado correctamente.');
  	}
  	else {
  // es una zona, borro tooodo
  	$domain = Domain::find($id);
  	$domain_id = $id;
  	$zones = Zone::where('domain_id', '=', $domain_id)-> delete();
  	$records = Record::where('domain_id', '=', $domain_id)-> delete();
  	$domain->delete();
  	return Redirect::to('list_zones')->with('notice', 'El registro ha sido eliminado correctamente.');
  	}
   }
}
