<?php
namespace App\Helpers;
use Log;

use App\User;
/*
	Helper class that checks the status of the user
	Gokul Srinivas 11-Jan-2016
 */
class CheckLevel
{
	/**
	 * @param  integer threshold of level for access
	 * @param  [user_id] The user_id of the user in question
 	 * @param  [user_roll] The user_roll of the user in question
	 * @return [bool] true indicates that user is allowed.
	 */
	public static function check($threshold=3, $user_id=NULL,$user_roll=NULL)
	{
		if($user_id == NULL && $user_roll == NULL)
		{
			return false;
		}

		if($user_id != NULL)
		{
			$user = User::where('user_id','=',$user_id)
						->first();
		}
		else if($user_roll != NULL)
		{
			$user = User::where('user_roll','=',$user_roll)
						->first();
		}

		if($user->user_type <= $threshold)
		{
			return true;
		}
		
		return false;
	}
}
?>