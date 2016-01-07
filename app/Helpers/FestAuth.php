<?php
namespace App\CustomClasses;
use App\CustomClasses\IMAPAuth;
use App\User;

class FestAuth
{
	/**
	 * [auth description]
	 * @param  [type] $user_id   [user_id from pragyanV3_users table]
	 * @param  [type] $user_pass [user_password from pragyanV3_users table for db auth,webmail pass otherwise]
	 * @return [type] Boolean    [true if authenticated, false if not]
	 */
	public static function auth($user_id,$user_pass)
	{
		$existing_user = User::where('user_id',$user_id)->get();

        if(count($existing_user) == 0)
        {
            return false;
        }
        
        $loginmethod 	= $existing_user[0]->user_loginmethod;
        $activated   	= $existing_user[0]->user_activated;
        $db_user_pass 	= $existing_user[0]->user_password;
        // $user_roll   	= $existing_user[0]->user_name; // Is roll number for NITT students

        if($activated == 0)
        {	
            return false;
        }

        // IMAP login for NITT Students
        if($loginmethod === "imap")
        {
        	$user_roll = explode("@",$existing_user[0]->user_email)[0];
            if( !IMAPAuth::nittauth($user_roll,$user_pass) )
            {
                return false;
            }
            else
            {
                return true;
            }
        }
        // DB login for non-NITT
        if($loginmethod === "db")
        {
            // DB login
            if( $existing_user[0]->user_password === md5($user_pass) )
            {
                return true;
            }
            else
            {
                return false;
            }
        }
	}
}