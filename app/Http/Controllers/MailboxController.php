<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Mailbox;
use App\Models\Alias;

class MailboxController extends Controller
{
  public function index() {
    $mailboxes = Mailbox::all();
    return $mailboxes;
  }
  public function show(Request $request) {
    $address = $request->input('id');
    $mailbox = Mailbox::where('address', '=', $address)->first();
    return response()->json($mailbox);
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
    $mailbox->enabled = $request->input('data.enabled');
  	// if($request->input('enabled') == ''){
  	// 	$mailbox->enabled = '0';
  	// }
  	// else {
  	// 	$mailbox->enabled ='1';
  	// }
  	$mailbox->save();
  	$alias = new Alias();
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
  }

  public function destroy(Request $request) {
    $address = $request->input('id');
    $mailbox = Mailbox::where('address', '=', $address)-> delete();
    $alias = Alias::where('mail', '=', $address)-> delete();
    //return Redirect::to('list_mailbox')->with('notice', 'El mailbox ha sido eliminado correctamente.');
  }

  public function update($address) {
    echo $address;

  }
}
