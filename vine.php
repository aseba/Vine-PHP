<?php

require 'curl/curl.php';

class Vine {

	private static $base_url = "https://api.vineapp.com";
	private static $referer = "api.vineapp.com";
	private static $vine_session = null;
	private static $vine_id = null;

	public static function login($username, $password) {
		$success = false;
		$url = self::$base_url . "/users/authenticate";
		$curl = new Curl;
		$response = json_decode($curl->post($url, array('username'=>$username, 'password'=>$password)));
		if(isset($response->success) and $response->success) {
			self::$vine_session = $response->data->key;
			self::$vine_id = $response->data->key;
			$success = true;
		}
		return $success;	
	}

	public static function get_tag($tag) {
		$encoded_tag = urlencode($tag);
		$url = self::$base_url . "/timelines/tags/$encoded_tag";
		$payload = null;
		$curl = new Curl;
		if(self::$vine_session) {
			$curl->headers['vine-session-id'] = self::$vine_session;
		}
		$response = json_decode($curl->get($url));
		if(isset($response->success) and $response->success) {
			$payload = $response->data->records;
		}
		return $payload;
	}

}

?>
