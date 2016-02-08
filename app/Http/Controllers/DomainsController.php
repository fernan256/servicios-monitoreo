<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Domain;
use App\Models\Record;
use App\Models\Zone;

class DomainsController extends Controller
{
  public function index() {
    $domains = Domain::all();
    $domains = Domain::with('records')->get();
    return $domains;
  }
  public function showRecord(Request $request) {
    $id = $request->input('id');
    $records = Record::where('domain_id', '=', $id)->get();
    return $records;
  }
  public function showDomain(Request $request) {
    $id = $request->input('id');
    $records = Domain::where('id', '=', $id)->get();
    return $records;
  }
  public function destroy(Request $request) {
    $id = $request->input('id');
    $aux = $request->input('hidden');
    if ($aux == 'record' ) {
      $records = Record::where('id', '=', $id)-> delete();
      //return Redirect::to('list_zones')->with('notice', 'El registro ha sido eliminado correctamente.');
    } else {
      $domain = Domain::find($id);
      $domain_id = $id;
      $zones = Zone::where('domain_id', '=', $domain_id)-> delete();
      $records = Record::where('domain_id', '=', $domain_id)-> delete();
      $domain->delete();
      return response()->json('ok');
    }
  }
}
