<?php

include('../src/musically.php');
$username = '';
$password = '';

$i = new \MusicallyAPI\Musically();

	try{
		$resp = $i->login($username, $password);
		// var_dump($resp);
		echo $resp;

	}catch(Exception $e){
		var_dump($e);
	}
