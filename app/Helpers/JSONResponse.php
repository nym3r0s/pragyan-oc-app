<?php
namespace App\Helpers;
use Log;

/*
	Helper class that logs the responses and returns the response object
	Gokul Srinivas 05-Sep-2015
 */
class JSONResponse
{
	/**
	 * [$status_code Integer Representing the Status code to be returned ]
	 * [$data 		 Array 	 Nullable Array that is either a JSONArray or JSONObject ]
	 * @var [NULL]
	 */
	public static function response($status_code, $data=NULL)
	{
		// Initialize the result array
		$json_result = array("status_code" => 400,"message" => "Bad Request");
		
		// Invalid Authentication
		if( $status_code === 401 )
		{
			$json_result['status_code']	= $status_code;
			$json_result['message']		= "Username or Password Incorrect";
		}
		
		// Succesful Response
		else if( $status_code === 200 || $status_code === 201 || $status_code === 304 )
		{
			$json_result['status_code']	= $status_code;
			
			if($data == NULL)
				$json_result['message']	= "Successful Authentication";
			else
				$json_result['message']	= $data;
		}

		// Bad Request
		else if( $status_code === 400 )
		{
			$json_result['status_code']	= 400;

			if($data === NULL)
				$json_result['message']= "Bad Request";	
			else
				$json_result['message']= $data;	
		}

		// Failsafe for an invalid/bad request
		else
		{
			$json_result['status_code']	= 400;

			if($data === NULL)
				$json_result['message']= "Bad Request";	
			else
				$json_result['message']= $data;
		}
		
		// Log the result
		$encoded_json = json_encode($json_result);
		Log::info($encoded_json);

		//Return JSON response.
		return response()->json($json_result,$json_result['status_code']);
	}
}
?>