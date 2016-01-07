<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\JSONResponse;

use App\User;

class GcmController extends Controller
{
    public function register(Request $request)
    {
    	$gcmId = $request->input("gcmId");
    	$roll = $request->input("roll");
    }
}
