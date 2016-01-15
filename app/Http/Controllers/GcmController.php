<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\JSONResponse;
use App\Helpers\Push;

use App\User;

class GcmController extends Controller
{
	public function register(Request $request)
	{
		$user_gcmid = $request->input("user_gcmid");
		$user_roll = $request->input("user_roll");

		$user = User::where('user_roll','=',$user_roll)
					->first();

		if($user == NULL)
		{
			return JSONResponse::response(400);
		}

		$user->user_gcmid = $user_gcmid;
		$user->save();

		return JSONResponse::response(200,true);

	}
}
