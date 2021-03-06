<?php

namespace App\Models;

class Process {

 	/*Inicializo variables para ser usadas en las funciones de mostrar procesos, eliminar, repriorizar y lanzar*/
 	/*Hago esto para poder obtener todos los datos de los procesos, sobre todo la prioridad*/
 	public function __construct( $user=0, $pid=0, $ppid=0,	$tid=0,	$cpu=0,	$pmem=0, $size=0,	$rss=0,	$vsize=0,	$prio=0, $tty=0, $status=0,	$stime=0,	$time=0, $cmd=0, $ni=0) {

		$this->user = $user;
		$this->pid = $pid;
		$this->ppid = $ppid;
		$this->tid = $tid;
		$this->pcpu = $cpu;
		$this->pmem = $pmem;
		$this->mem = $size;
		$this->rss = $rss;
		$this->vsize = $vsize;
		$this->prio = $prio;
		$this->tty = $tty;
		$this->status = $status;
		$this->stime= $stime;
		$this->time = $time;
		$this->cmd = $cmd;
		$this->nice = $ni;
	}

	/*Buscar proceso por PID*/
	public static function find($pid) {
		$process = new Process();
		$process->pid = $pid;
		$process->cmd = 'ps -p ' . $process->pid;
		$command = sprintf($process->cmd,$process->pid);
		exec($command, $output, $result);
		if ($result == 1) {
			return $status = 404;
		} else {
			return $status = 200;
		}
	}

	public static function findOne($pid) {
		$process = new Process();
		$process->pid = $pid;
		$process->cmd = 'ps -faxu | grep ' . $process->pid;
		$command = sprintf($process->cmd,$process->pid);
		exec($command, $output, $result);
		if ($result == 1) {
			return $output;
		} else {
			return $output;
		}
	}

	/*Función que devuelve todos los procesos*/
	public static function allProcess() {

		$cmd = shell_exec("ps -eo user,pid,ppid,tid,pcpu,pmem,size,rss,vsize,priority,tty,stat,start_time,time,comm,ni");
		$key = preg_split("/[\n,]+/", $cmd);  /*Parseo y divido para tener un proceso por linea*/
		$listedProcess = array();

		for ($i=1; $i<(count($key) -1); $i++) {

			$result["parameters"] = $key[$i];
			$aux = preg_split("/[\s,]+/", $result["parameters"]);

			$process = new Process();
			$process->user = $aux[0];
			$process->pid = $aux[1];
			$process->ppid = $aux[2];
			$process->tid = $aux[3];
			$process->pcpu = $aux[4];
			$process->pmem = $aux[5];
			$process->mem = $aux[6];
			$process->rss = $aux[7];
			$process->vsize = $aux[8];
			$process->prio = $aux[9];
			$process->tty = $aux[10];
			$process->status = $aux[11];
			$process->stime = $aux[12];
			$process->time = $aux[13];
			$process->cmd = $aux[14];
			$process->nice = $aux[15];

			$listedProcess[] = $process;
		}

		return $listedProcess;

	}

	/*Eliminar un proceso*/
	public static function killProcess($pid) {
		$process = new Process();
		$process->cmd = 'kill -9 %d';
		$process->pid = $pid;
		$command = sprintf($process->cmd, $process->pid);
		exec($command, $output, $result);

		return $result;
	}

	/*Repriorizar un proceso*/
	public static function repriorizeProcess($pid, $prio) {
		$process = new Process();
		$process->pid = $pid;
		$process->prio = $prio;
		$process->cmd = 'renice %d -p %d';
		$command = sprintf($process->cmd,$process->prio,$process->pid);
		exec($command, $output, $result);

		return $output;
	}

	/*Lanzar un proceso*/
	public static function launchProcess($cmd) {
		$command =  $cmd . '& echo $!;';
		exec($command, $output, $code);
		return $output;
	}
}

?>