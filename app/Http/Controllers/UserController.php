<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\JSONResponse;
use App\Helpers\LDAPAuth;
use App\Helpers\IMAPAuth;
use App\User;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $user_roll = $request->input('user_roll');
    	$user_pass = $request->input('user_pass');

    	$ldap_auth = LDAPAuth::auth($user_roll,$user_pass);
    	$imap_auth = IMAPAuth::auth($user_roll,$user_pass);

    	if($ldap_auth || $imap_auth)
    	{
    		$user = User::where('user_roll','=',$user_roll)
						->first();

            if($user == NULL)
            {
                return JSONResponse::response(400);
            }
			$generated_secret = sha1($user->user_roll."Pragyan16Rocks");

			$user->user_secret = $generated_secret;
			$user->save();

			return JSONResponse::response(200,$generated_secret);
    	}
    	else
    	{
    		return JSONResponse::response(401);
    	}
    }

    public function profileGetDetails(Request $request)
    {
        $user_roll = $request->input('user_roll');

        $user = User::where('user_roll','=',$user_roll)
                    ->select('user_roll','user_name','user_phone','user_type')
                    ->first();

        if($user == NULL)
        {
            return JSONResponse::response(400);
        }                
        
        return JSONResponse::response(200,$user);

    }
    public function profileGetAllDetails(Request $request)
    {
        $user_roll = $request->input('user_roll');
        
        $users = User::where('user_roll','!=',$user_roll)
                     ->select('user_roll','user_name','user_phone','user_type')
                     ->get();
        return JSONResponse::response(200,$users);
    }
}
