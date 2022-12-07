<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Http;

class Tracking{
	public static function idexpress($awb){
		$url = "https://rest.idexpress.com/retail/waybill-scan-lines/search-track-batch?waybillNo=".$awb;				
		try {			
			$response = Http::get($url);
			return json_decode($response, true);
		} catch (\Throwable $th) {
			return ["status"=>false,"error"=>$th->getMessage()];
		}
		
		// $curl = curl_init();
		// curl_setopt_array($curl, array(
		// 	CURLOPT_URL => "https://rest.idexpress.com/retail/waybill-scan-lines/search-track-batch?waybillNo=".$awb,
		// 	CURLOPT_RETURNTRANSFER => true,
		// 	CURLOPT_ENCODING => "",
		// 	CURLOPT_MAXREDIRS => 10,
		// 	CURLOPT_TIMEOUT => 30,
		// 	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,			
		// 	CURLOPT_HTTPHEADER => array(
		// 		"content-type: application/json",
		// 	),
		// ));
		// $response = curl_exec($curl);
		// $err = curl_error($curl);
		// curl_close($curl);
		// if ($err) {
		// 	return "cURL Error #:" . $err;
		// } else {
		// 	return json_decode($response, true);
		// }
	}
}