<?php
namespace App\Helpers;
use Log;

/*
	Helper class that sends a push notification
	Gokul Srinivas 05-Sep-2015
 */

use PushNotification;
use App\User;
use Exception;
use stdClass;

class Push
{
	/**
	 * [$user_roll roll number of the user ]
	 * [$message 		string message ]
	 * @var [NULL]
	 */
	public static function notify($user_roll, $message=NULL)
	{
		$user = User::where('user_roll','=',$user_roll)
					->first();

		$user_gcmid = $user->user_gcmid;

		try 
		{
			PushNotification::app('appNameAndroid')
			                ->to($user_gcmid)
			                ->send($message);
		}
		catch(Exception $e)
		{
			Log::info("Push failed for ".$user_roll." with Message\n".json_encode($message));
		}

	}

	public static function jsonEncode($type="default",$data=NULL)
	{
		$jsonObject = new stdClass();
		$jsonObject->type = $type;
		$jsonObject->message = $data;

		return json_encode($jsonObject); 
	}

	public static function sendMany($rollnums = NULL,$message = NULL)
	{
		// If rollnum is not specified, return
		if($rollnums == NULL)
		{
			return;
		}

		// Check if only one roll number is sent.
		if(!is_array($rollnums))
		{
			Push::notify($rollnums, $message);
		}
		// Loop through the roll numbers and send the message to each and every one of them
		else 
		{
			foreach ($rollnums as $rollnum)
			{
				Push::notify($rollnum, $message);
			}
		}
	}
}
?>