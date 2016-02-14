<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Models\Maildomain;

class MailDomainController extends Controller
{
  public function __construct() {
    $this->middleware('jwt.auth');
  }
  public function index() {
    $mailDomain = Maildomain::all();
    return $mailDomain;
  }

  public function show($id) {
    $mailDomain = Maildomain::where('pkid', $id)->get();
    return $mailDomain;
  }

  public function store(Request $request) {
    $domainName = $request->input('data.domain');
    if($domainName !== null) {
      $domain = Maildomain::where('domain', '=', $domainName)->first();
      if($domain !== null) {
        return response()->json(['error' => 'domain_does_existe'], 400);
      } else {
        $mailDomain = new Maildomain();
        $mailDomain->domain = $request->input('data.domain');
        $mailDomain->enabled = $request->input('data.enabled');
        $mailDomain->save();
      }
    }
  }

  public function destroy($id) {
    $maildomain = Maildomain::where('pkid', $id)-> delete();
    return response()->json('ok');
  }

  public function update(Request $request) {
    $pkid = $request->input('data.pkid');
    $mailDomain = new Maildomain();
    $mailDomain->domain = $request->input('data.domain');
    if($request->input('data.enabled') == ''){
      $mailDomain->enabled = '0';
    } else {
      $mailDomain->enabled ='1';
    }

    //Update query
    Maildomain::where('pkid', $pkid)
                ->update(['domain' => $mailDomain->domain, 'enabled' => $mailDomain->enabled]);

    return response()->json(['success' => 'updated'], 200);
  }
}
