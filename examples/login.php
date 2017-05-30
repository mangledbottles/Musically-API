<?php

include('../src/musically.php');
$username = 'JessicaSmith6397';
$password = 'Password123';

$i = new \MusicallyAPI\Musically();

	try{
		$resp = $i->login($username, $password);
		// var_dump($resp);
		echo $resp;

	}catch(Exception $e){
		var_dump($e);
	}
// $give->username = $username;
// $give->password = $password."ASI";
// var_dump($i->store($give));