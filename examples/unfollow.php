<?php
include('../src/musically.php');
$username = '';
$password = '';
$userId = '';

$i = new \MusicallyAPI\Musically();

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
