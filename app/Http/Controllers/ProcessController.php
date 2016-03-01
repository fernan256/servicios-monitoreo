<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Models\Process;

class ProcessController extends Controller
{
  public function __construct() {
   $this->middleware('jwt.auth');
  }
  public function index() {
    $processes = Process::allProcess();
    return $processes;
  }

  /*Eliminar proceso*/

  public function destroy(Request $request) {

    $status = Process::find($request->input('pid'));
    if ($status == '404'){
      return response()->json(array('status' => '404', 'message' => 'Not Found'));
    } else {
      $process = Process::killProcess($request->input('pid'));
      return response()->json(array('status' => '200', 'message' => 'Founded','result' => $process));
    }
  }

  /*Repriorize a process*/

  public function update(Request $request) {
    $process = new Process;
    $process->pid = $request->input('data.pid');
    $process->prio = $request->input('data.prio');
    $status = Process::find($process->pid);

    if ($status == '404'){
      return response()->json(array('status' => '404', 'message' => 'Not Found'));
    } else {
      $process = Process::repriorizeProcess($process->pid, $process->prio);
      return response()->json(array('status' => '200', 'message' => 'Founded', 'result' => $process));
    }
  }

  /*Execute a process*/

  public function store(Request $request) {
    $process = new Process;
    $process->cmd = $request->input('cmd');
    $process = Process::launchProcess($process->cmd);
    //print_r($process);
    return response()->json(array('status' => '200', 'message' => 'Founded', 'result' => $process));
  }
}
