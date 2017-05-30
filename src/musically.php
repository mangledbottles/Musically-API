<?php
namespace MusicallyAPI;

	class Musically{
		const API_URL = 'https://api.musical.ly/rest/';

		public function __construct(){
			header('Content-Type: application/json');
		}

		/**
		* Login
		*
		* @param $username string login username
		* @param $password string login password
		**/

		public function login($username, $password){
			$this->username = $username;
			try{
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "https://api.musical.ly/rest/passport/v2/login?supportLoginVerify=true");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_NOBODY, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, "admin=0&bid&email=%40".$username."&fansNum&featuredScope=0&followNum&gender=n&googleAccount&handle&handleModified&icon&instagramID&likesNum&livelyHearts&nickName&password=".$password."&realName&registered=0&remember_me=on&reviewer=0&source&suspicious=0&userDesc&userId&userSettingDTO[birthDay]&userSettingDTO[birthYear]&userSettingDTO[countryCode]&userSettingDTO[duet]&userSettingDTO[hideLocation]&userSettingDTO[languageCode]&userSettingDTO[policyVersion]&userSettingDTO[privateChat]&userSettingDTO[secret]&userSettingDTO[timeZone]&username=%40".$username."&verified=0&verifiedPhone=0&youtubeChannelId&youtubeChannelTitle");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
				curl_setopt($ch, CURLOPT_HEADER, 1);
				$headers = array();
				$headers[] = "Host: api.musical.ly";
				$headers[] = "X-Requested-With: XMLHttpRequest";
				$headers[] = "User-Agent: Musical.ly/20170524004 (iPhone; iOS 9.0.1; Scale/2.00)";
				$headers[] = "Country: US";
				$headers[] = "Language: en-US";
				$headers[] = "X-Request-Info5: eyJtZXRob2QiOiJQT1NUIiwib3MiOiJpT1MgOS4wLjEiLCJYLVJlcXVlc3QtSUQiOiJENzY5OERGMS0zNjc2LTQ5OUYtQUVBQS05RUJFNjU2NEUzMkYiLCJvc3R5cGUiOiJpb3MiLCJkZXZpY2VpZCI6ImkwY2Q3NzBjNmFmNGQzNDY1OWJhNzIxMTA3OTA2NmRlOGJiMyIsInZlcnNpb24iOiI1LjcuMSIsInRpbWVzdGFtcCI6IjE0OTYwODY1NzYwMDAiLCItciI6IjUwNTQiLCJ1cmwiOiJodHRwczpcL1wvYXBpLm11c2ljYWwubHlcL3Jlc3RcL3Bhc3Nwb3J0XC92MlwvbG9naW4/c3VwcG9ydExvZ2luVmVyaWZ5PXRydWUifQ==";
				$headers[] = "Version: 5.7.1";
				$headers[] = "Os: iOS 9.0.1";
				$headers[] = "Build: 20170524004";
				$headers[] = "Slider-Show-Cookie: ";
				$headers[] = "X-Request-Sign5: 01i65393211a23cded01ae6736be3aab1bec21f7dcbd";
				$headers[] = "Authorization: M-TOKEN \"hash\"=";
				$headers[] = "Mobile: iPhone8,1";
				$headers[] = "Slider-Show-Session: i0cd770c6af4d34659ba7211079066de8bb3";
				$headers[] = "Accept-Language: en-US;q=1";
				$headers[] = "X-Request-Id: D7698DF1-3676-499F-AEAA-9EBE6564E32F";
				$headers[] = "Timezone: IST";
				$headers[] = "Network: WiFi";
				$headers[] = "Accept: application/json";
				$headers[] = "Content-Type: application/x-www-form-urlencoded; charset=utf-8";
				$headers[] = "-R: 5054";
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				$result = curl_exec($ch);
				curl_close ($ch);


				$headers=array();
				$data=explode("\n", $result);

				$this->store = new \Stdclass();
				$this->store->username = $username;
				$this->store->password = $password;

				$dexplore = explode('=', $data[7]);
				$this->store->slider_cookie = explode(';', $dexplore[1])[0];
				$this->store->token_expiration = substr($dexplore[3], 0 , -1);

				$dexplore1 = explode('"', $data[8]);
				$this->store->authentication_hash = $dexplore1[3];

				if($this->store($this->store)){
					return $this->Response($data[12]);
				}else{
					throw new \Exception($e . $this->Response($data));
				}
			}catch(Exception $e){
				return 'ERROR: '.$e;
			}


		}

		/**
		* Follow user
		*
		* @param $userId int|string user to follow
		**/

		public function follow($userId = NULL){

			$requestData = $this->request(
				"graph/operations/friendship/{$userId}/"
				);
        	return $this->Response($requestData);
		}

		/**
		* Unfollow user
		*
		* @param $userId int|string user to unfollow
		**/

		public function unfollow($userId = NULL){
			$requestData = $this->request(
				"graph/operations/friendship/{$userId}/", 
				["headers" => [CURLOPT_CUSTOMREQUEST => 'DELETE'] ],
				NULL
				);
			// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        	return $this->Response($requestData);
			
		}

		/**
		* Search for user by search term
		*
		* @param $searchTerm string The search term
		* @param $pageNo int Pagination
		**/

		public function searchUsers($searchTerm = NULL, $pageNo = 1){
			$requestData = $this->request(
				"discover/user/find_user_v1?pageNo={$pageNo}&___d=eyJhYyI6IkxJU1QiLCJieiI6ImZpbmRfdXNlciIsImRtIjoiVVNFUiIsInZlciI6InYxIn0%3D&keyword={$searchTerm}",
				["headers" => [CURLOPT_CUSTOMREQUEST => 'GET'] ],
				NULL
				);

			return $this->Response($requestData);
		}

		/**
		* Get details of users account from their userId
		*
		* @param $userId int|string Users ID to get
		**/

		public function getUsersDetails($userId = NULL){
			$requestData = $this->request(
				"user/{$userId}?user_vo_relations=all",
				["headers" => [CURLOPT_CUSTOMREQUEST => 'GET'] ],
				NULL
				);
			// get users posts
			// $requestData2 = $this->request(
			// 	"discover/musical/owned/list/Yrs2DW4X8sbayZJNFXf8lV8BGYJs6vd69fGQ8eA9?limit=20&anchor=0&target_user_id={$userId}"
			// 	);

			return $this->Response($requestData);
		}

		// PRIVATE FUNCTIONS 

		private function store($store = array()){
			$json = file_get_contents(__DIR__.'/stored_data/stored.json');
			$data = json_decode($json, true);

				$username = $store->username;
				$data['usernames'][$username]['username'] = $store->username;
				$data['usernames'][$username]['password'] = $store->password;
				$data['usernames'][$username]['timestamp'] = date("D, d M Y G:i:s e");
				$data['usernames'][$username]['slider_cookie'] = $store->slider_cookie;
				$data['usernames'][$username]['token_expiration'] = $store->token_expiration;
				$data['usernames'][$username]['authentication_hash'] = $store->authentication_hash;

			$updatedJson = json_encode($data);
			if(file_put_contents(__DIR__.'/stored_data/stored.json', $updatedJson)){
				return true;
			}else{
				return false;
			}
		}

		private function getUserData($username = NULL){
			$json = file_get_contents(__DIR__.'/stored_data/stored.json');
			$data = json_decode($json, true);

			return $data['usernames'][$username];
		}

		/**
		* Carry out the API requests.
		*
		* @param string $url Request URL
		* @param array $additionalcUrlHeaders eg ["headers" => ['header1'=>'value1'], ['header2' => 'value2'] ]
		* @param array $additionalHeaders eg ['value1', 'value2', 'value3']
		**/

		private function request($url, $additionalcUrlHeaders = NULL, $additionalHeaders = NULL){
			$accountData = $this->getUserData($this->username);

			$ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, self::API_URL.$url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	        if(isset($additionalcUrlHeaders)){
	        	foreach($additionalcUrlHeaders as $addcUrlHeaders){
	        		$key = key($addcUrlHeaders);
	        		curl_setopt($ch, $key, $addcUrlHeaders[$key]);
	        	}
	        }
	        $headers = array();
	        if(isset($additionalHeaders)){
	        	foreach($additionalHeaders as $addHeaders){
	        		$headers[] = $addHeaders;
	        	}
	        }
	        $headers[] = "Host: api.musical.ly";
	        $headers[] = "X-Requested-With: XMLHttpRequest";
	        $headers[] = "User-Agent: Musical.ly/20170420008 (iPhone; iOS 9.0.1; Scale/2.00)";
	        $headers[] = "X-Request-Sign3: I6dbcd2882dacaeec7583547249f15ead22328d3f7";
	        $headers[] = "Country: US";
	        $headers[] = "Language: en-US";
	        $headers[] = "Version: 5.5.3";
	        $headers[] = "Os: iOS 9.0.1";
	        $headers[] = "Build: 20170420008";
	        $headers[] = "Slider-Show-Cookie: ".$accountData['slider_cookie'];
	        $headers[] = "Authorization: M-TOKEN \"hash\"=\"".$accountData['authentication_hash']."\" \"status\"=\"000\"";
	        $headers[] = "Mobile: iPhone8,1";
	        $headers[] = "Slider-Show-Session: 2fd93ff1bd1647a093c897c3aee912b5";
	        $headers[] = "Accept-Language: en-US;q=1";
	        $headers[] = "X-Request-Id: 3E488C11-A010-4B8E-99A0-F5799365609C";
	        $headers[] = "Timezone: IST";
	        $headers[] = "Network: WiFi";
	        $headers[] = "Accept: application/json";
	        $headers[] = "X-Request-Info3: eyJvc3R5cGUiOiJpb3MiLCJvcyI6ImlPUyA5LjAuMSIsIlgtUmVxdWVzdC1JRCI6IjNFNDg4QzExLUEwMTAtNEI4RS05OUEwLUY1Nzk5MzY1NjA5QyIsInNsaWRlci1zaG93LWNvb2tpZSI6ImJsODJNekl5TURBeE5UQXpNemMzTkRBNE1EcDFhakZvYVUweFJqRTJMMXAwWlZCdlRsVlRaVEpSUFQwNlpUazNPRE5sTXpjMVpUZzROV0ZsTURBd05tWXdZMk16T0RobVpUSmhNamM2TmpNeU1qQXdNVFV3TXpNM056UXdPREEiLCJtZXRob2QiOiJQT1NUIiwiZGV2aWNlaWQiOiIyZmQ5M2ZmMWJkMTY0N2EwOTNjODk3YzNhZWU5MTJiNSIsInZlcnNpb24iOiI1LjUuMyIsInRpbWVzdGFtcCI6IjE0OTQxMDc1MzAwMDAiLCJ1cmwiOiJodHRwczpcL1wvYXBpLm11c2ljYWwubHlcL3Jlc3RcL2dyYXBoXC9vcGVyYXRpb25zXC9mcmllbmRzaGlwXC82Njg0ODI3NDU3NzQxNjE5MiJ9";
	        $headers[] = "Content-Type: application/x-www-form-urlencoded";
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	        $result = curl_exec($ch);
	        curl_close ($ch);
	        return $result;
		}

		private function Response($requestData){
			$requestData = json_decode($requestData);

			$resp = new \Stdclass();
			$resp->success = $requestData->success;
			if(isset($requestData->result->hasNext)){
				$resp->hasNext = $requestData->result->hasNext;
			}
			$resp->full_response = $requestData;

			$resp = json_encode($resp);
			return $resp;
		}
	}

?>