<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Models\Mailbox;
use App\Models\Aliases;

class MailboxController extends Controller
{
     public function __construct() {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the authenticate method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => ['authenticate']]);
   }
  public function index() {
    $mailboxes = Mailbox::all();
    return $mailboxes;
  }
  public function show($id) {
    $mailbox = Mailbox::where('id', '=', $id)->first();
    return $mailbox;
  }
  public function store(Request $request) {
  	$length = strlen($request->input('data.password'));
   	$name = $request->input('data.username');
  	// if ($length < 6) {
  	// 	return Redirect::to('list_mailbox/create')->with('notice', 'oops!');
  	// }
  	// if ($name != null) {
  	// 	$address = $name.'@'.$request->input('domain');  //usuario@dominio
  	// 	$usuario = Mailbox::where('username', '=', $address)->first();
  	// if ($usuario != null){
    //   echo ('null');
  	// 	//return Redirect::to('list_mailbox/create')->with('notice', 'La direccion solicitada esta en uso');
  	// }
   	$current_timestamp = date("Y-m-d H:i:s");
  	$mailbox = new Mailbox();
  	$mailbox->id = $request->input('data.username').'@'.$request->input('data.domain');
  	$pass = $request->input('data.password');
  //	$hash = Crypt::encrypt($pass);
  	$hash = crypt($pass);
  	$mailbox->crypt = $hash;
    $mailbox->address = $request->input('data.username').'@'.$request->input('data.domain');
  	$mailbox->name = $request->input('data.name');
  	$mailbox->maildir = $request->input('data.username').'/';
  	$mailbox->quota = $request->input('data.quota', '0');
  	//$mailbox->local_part = $request->input('username');
  	//$mailbox->domain = $request->input('domain');
  	$mailbox->created = $current_timestamp;
  	$mailbox->modified = $current_timestamp;
  	if($request->input('data.enabled') == ''){
      $mailbox->enabled = '0';
  	}	else {
  	 	$mailbox->enabled ='1';
  	}
  	$mailbox->save();
  	$alias = new Aliases();
  	$alias->mail = $mailbox->address;
  	$alias->destination = $mailbox->address;
  	//$alias->domain = $mailbox->domain;
  	$alias->created = $mailbox->created;
  	$alias->modified = $mailbox->modified;
  	$alias->enabled = $mailbox->enabled;
  	$alias->save();

  	//return Redirect::to('/')->with('notice', 'El mailbox ha sido creado correctamente.');
  //    }
  // else {
  // 	//return Redirect::to('list_mailbox/create')->with('notice', 'oops!');
  // 	}
    return response()->json('Creado');
  }

  public function destroy(Request $request) {
    $address = $request->input('id');
    $mailbox = Mailbox::where('address', '=', $address)-> delete();
    $alias = Aliases::where('mail', '=', $address)-> delete();
    return response()->json('ok');
  }

  public function edit(Request $request) {
    $id = $request->input('data.address');
    $length = strlen($request->input('data.password'));
    if($length >= 6) {
      $current_timestamp = date("Y-m-d H:i:s");
      $mailbox = new Mailbox();
      $mailbox->password = crypt($request->input('data.password'));
      $mailbox->name = $request->input('data.name');
      $mailbox->modified = $current_timestamp;
      if($request->input('data.enabled') == ''){
        $mailbox->enabled = '0';
      } else {
        $mailbox->enabled ='1';
      }
      //super query
      Mailbox::where('address', $id)
                ->update(['name' => $mailbox->name, 'enabled' => $mailbox->enabled, 'crypt' => $mailbox->password, 'modified' => $mailbox->modified]);
      Aliases::where('mail', $id)
                ->update(['modified' => $mailbox->modified, 'enabled' => $mailbox->enabled]);

      //return response()->json('Actualizado');
    }
    else {
      return response()->json('Error');
    }
  }
}
