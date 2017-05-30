<?php
include('../src/musically.php');
$username = 'JessicaSmith6397';
$password = 'Password123';
$userId = '63220015033774080';

$i = new \MusicallyAPI\Musically();

	// var_dump($i->getUserData($username));
	try{
		$i->login($username, $password);	
	}catch (Exception $e){
		var_dump("An error occurred: " . $e);
	}

	try{
		$resp = $i->unfollow($userId);
		echo $resp;
	}catch (Exception $e){
		var_dump("An error occurred: " . $e);
	}
?>