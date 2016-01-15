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
		try 
		{

			$user = User::where('user_roll','=',$user_roll)
						->first();

			$user_gcmid = $user->user_gcmid;

			if(strlen($user_gcmid) != 0)
			{
				PushNotification::app('appNameAndroid')
				                ->to($user_gcmid)
				                ->send($message);
			}
		}
		catch(Exception $e)
		{
			Log::info("Push failed for ".json_encode($user)." with Message\n".json_encode($message));
		}

	}

	public static function jsonEncode($type="default",$data=NULL)
	{
		$jsonObject = new stdClass();
		$jsonObject->type = $type;
		$jsonObject->message = $data;

		return json_encode($jsonObject); 
	}

	/**
	 * [sendMany description]
	 * @param  [type] $rollnums [Make sure it is iterable. Else use notify]
	 * @param  [type] $message  [json encoded message. use Push::jsonEncode]
	 * @return [type]           [description]
	 */
	public static function sendMany($rollnums = NULL,$message = NULL)
	{
		// If rollnum is not specified, return
		if($rollnums == NULL)
		{
			return;
		}

		foreach ($rollnums as $rollnum)
		{
			Push::notify($rollnum, $message);
		}
	}
}
?>