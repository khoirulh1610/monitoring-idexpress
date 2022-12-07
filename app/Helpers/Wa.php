<?php

namespace App\Helpers;

use App\Models\Apiwa;

class Wa
{
	public static function send($api_id, $data)
	{
		$wa = Apiwa::find($api_id);
		if ($wa) {
			$engine = $wa['name'];
			return self::$engine($wa, $data);
		}
	}
	public static function Tokalink($wa,$data)
	{

		$payload = [
			"device_key" => $wa['apikey'],
			"cmd" => 'send',
			"phone" => $data['phone'],
			"message" => $data['message'],
			"file_url" => $data['file_url'] ?? null,
		];		
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => "https://tokalink.id/api/v1/whatsapp",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($payload),
			CURLOPT_HTTPHEADER => [
				"Accept: application/json",			
				"Content-Type: application/json"
			],
		]);
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			return json_encode(['status' => 'error', 'message' => $err]);
		} else {
			return $response;
		}
	}

	public static function WooWA($wa,$data)
	{	
		$url= $wa['host'];
		$data = array(
			"phone_no"=> $data['phone'],
			"key"     => $wa['apikey'],
			"message" => $data['message']
		);

		$data_string = json_encode($data,1);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 360);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string),
			'Authorization: Basic '.$wa['apikey']
		));
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;		
	}

	public static function TokalinkStatus($id)
	{
		$wa = Apiwa::find($id);
		$payload = [
			"device_key" => $wa['apikey'],
			"cmd" => 'status',			
		];				
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => "https://tokalink.id/api/v1/whatsapp",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => json_encode($payload),
			CURLOPT_HTTPHEADER => [
				"Accept: application/json",			
				"Content-Type: application/json"
			],
		]);
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			return json_encode(['status' => 'error', 'message' => $err]);
		} else {
			$res = json_decode($response,1);
			if($res['status'] == TRUE){
				$wa->wa_phone = $res['phone'];
				$wa->wa_name = $res['name'] ?? '-';
				$wa->wa_profile = $res['pic'];
				$wa->status = 1;
				$wa->save();
			}else{
				$wa->wa_phone = null;
				$wa->wa_name = null;
				$wa->wa_profile = null;
				$wa->status = 0;
				$wa->save();
			}
			return $response;
		}
	}	

	public static function SpinText($string)
	{
		$total = substr_count($string, "{");
		if ($total > 0) {
			for ($i = 0; $i < $total; $i++) {
				$awal = strpos($string, "{");
				$startCharCount = strpos($string, "{") + 1;
				$firstSubStr = substr($string, $startCharCount, strlen($string));
				$endCharCount = strpos($firstSubStr, "}");
				if ($endCharCount == 0) {
					$endCharCount = strlen($firstSubStr);
				}
				$hasil1 =  substr($firstSubStr, 0, $endCharCount);
				$rw = explode("|", $hasil1);
				$hasil2 = $hasil1;
				if (count($rw) > 0) {
					$n = rand(0, count($rw) - 1);
					$hasil2 = $rw[$n];
				}
				$string = str_replace("{" . $hasil1 . "}", $hasil2, $string);
			}
			return $string;
		} else {
			return $string;
		}
	}

	public static function salam($text)
	{
		$b = time();
		$hour = (int) date("G", $b);
		$hasil = "";
		if ($hour >= 0 && $hour < 10) {
			$hasil = "Pagi";
		} elseif ($hour >= 10 && $hour < 15) {
			$hasil = "Siang";
		} elseif ($hour >= 15 && $hour <= 17) {
			$hasil = "Sore";
		} else {
			$hasil = "Malam";
		}

		$text = str_replace('[waktu]', $hasil, $text);
		return $text;
	}

	public static function ReplaceArray($array , $string){
		try {
			$string = self::salam($string);
			$pjg = substr_count($string, "[");
			for ($i = 0; $i < $pjg; $i++) {
				$col1 = strpos($string, "[");
				$col2 = strpos($string, "]");
				$find = strtolower(substr($string, $col1 + 1, $col2 - $col1 - 1));
				$relp = substr($string, $col1, $col2 - $col1 + 1);
				if (isset($array[$find])) {
					$string = str_replace($relp, $array[$find], $string);     //asli       
				} else {
					$string = str_replace('[' . $find . ']', '', $string);
				}
			}
			return self::SpinText($string);
		} catch (\Throwable $th) {
			return $string;
		}
	}
}
