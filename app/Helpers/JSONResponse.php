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
		$json_result = array("status_code" => 0,"message" => NULL);
		// Invalid Authentication
		if( $status_code === 0 )
		{
			$json_result['status_code']	= 0;
			$json_result['message']		= "Username or Password Incorrect";
		}
		// Succesful Authentication for use in login
		else if( $status_code === 1 )
		{
			$json_result['status_code']	= 1;
			$json_result['message']		= "Successful Authentication";
		}
		// Successful Authentication + data response
		else if( $status_code === 2 )
		{
			$json_result['status_code']	= 2;
			
			// FailSafe
			$json_result['message'] = NULL;
			
			// If data is not null
			if($data !== NULL)
			{
				// Takes care of both JSONObject and JSONArray
				$json_result['message'] = $data;
			}
			// NULL Data
			else
			{
				$json_result['message'] = $data;
			}
		}
		// Failsafe for an invalid request
		else
		{
			$json_result['status_code']	= 3;
			if($data === NULL)
				$json_result['message']= "Invalid Request";	
			else
			{
				if(is_array($data))
					$json_result['message']= json_encode($data);	
				else
					$json_result['message']= $data;
			}
		}
		
		// Log the result
		$encoded_json = json_encode($json_result);
		Log::info($encoded_json);

		//Return JSON response.
		return response()->json($json_result);
	}
}
?>