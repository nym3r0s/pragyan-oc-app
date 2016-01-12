<?php
namespace App\Helpers;
use Log;

/*
	Helper class that sends a push notification
	Gokul Srinivas 05-Sep-2015
 */

use PushNotification;
use App\User;

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



		PushNotification::app('appNameAndroid')
		                ->to($user_gcmid)
		                ->send('Hello RB. Life la Eppdi pogudhu');
	}
}
?>