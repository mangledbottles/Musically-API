<?php
include('../src/musically.php');
$username = '';
$password = '';
$searchTerm = '';
$pageNo = '';

$i = new \MusicallyAPI\Musically();

	try{
		$i->login($username, $password);
	}catch (Exception $e){
		var_dump("An error occurred: " . $e);
	}

	try{
		$resp = $i->searchUsers($searchTerm);
		$resp = json_decode($resp);
		$userId = $resp->full_response->result->list[0]->userId;
	}catch (Exception $e){
		var_dump("An error occurred: " . $e);
	}

	try{
		$resp = $i->getUsersDetails($userId);
		echo $resp;
	}catch (Exception $e){
		var_dump("An error occurred: " . $e);
	}
?>
