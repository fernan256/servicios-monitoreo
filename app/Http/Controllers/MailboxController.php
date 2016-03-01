<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Mail;
use File;

use App\Models\Mailbox;
use App\Models\Aliases;

class MailboxController extends Controller
{
  public function __construct() {
    $this->middleware('jwt.auth');
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
    $name = $request->input('data.username');
    if ($name != null) {
      $address = $name.'@'.$request->input('data.domain');  //usuario@dominio
      $usuario = Mailbox::where('address', '=', $address)->first();
      if ($usuario != null){
        return response()->json(['error' => 'mailbox_exists'], 409);
      }
      $current_timestamp = date("Y-m-d H:i:s");
      $mailbox = new Mailbox();
      $mailbox->id = $request->input('data.username').'@'.$request->input('data.domain');
      $pass = $request->input('data.password');
      $hash = crypt($pass);
      $mailbox->crypt = $hash;
      $mailbox->address = $request->input('data.username').'@'.$request->input('data.domain');
      $mailbox->name = $request->input('data.name');
      $mailbox->maildir = $request->input('data.username').'/';
      $mailbox->quota = $request->input('data.quota', '0');
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
      $alias->created = $mailbox->created;
      $alias->modified = $mailbox->modified;
      $alias->enabled = $mailbox->enabled;
      $alias->save();
      Mail::send('email.welcome', ['mailbox' => $mailbox], function($m) use ($mailbox) {
	$m->from('admin@htagro.info', 'Administrador');
	$m->to($mailbox->address, $mailbox->name)->subject('Bienvenido');
      });
      return response()->json(['success' => 'mailbox_created'], 200);
    } else {
      return response()->json(['error' => 'username_not_provided'], 200);
    }
  }

  public function destroy(Request $request) {
    $address = $request->input('id');
    $mailbox = Mailbox::where('address', '=', $address)->first();
    if($mailbox != null) {
      $mailbox = Mailbox::where('address', '=', $address)-> delete();
      $alias = Aliases::where('mail', '=', $address)-> delete();
      return response()->json(['success' => 'mailbox_deleted'], 200);
    } else {
      return response()->json(['error' => 'mailbox_not_exists'], 400);
    }
  }

  public function edit(Request $request) {
    $id = $request->input('data.address');
    $length = strlen($request->input('data.password'));
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
    //Update query
    Mailbox::where('address', $id)
              ->update(['name' => $mailbox->name, 'enabled' => $mailbox->enabled, 'crypt' => $mailbox->password, 'modified' => $mailbox->modified]);
    Aliases::where('mail', $id)
              ->update(['modified' => $mailbox->modified, 'enabled' => $mailbox->enabled]);
    return response()->json(['success' => 'mailbox_updated'], 200);
  }
}
