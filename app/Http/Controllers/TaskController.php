<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\JSONResponse;
use App\Helpers\CheckLevel;
use App\User;
use App\Task;
use App\TeamMember;

class TaskController extends Controller
{
    public function createTask(Request $request)
    {
        $user_roll	= $request->input('user_roll');

        $task_name = $request->input('task_name'); 
    	$team_id   = $request->input('team_id'); 

    	if(!CheckLevel::check(2,NULL,$user_roll))
    	{
    		return JSONResponse::response(401);
    	}

    	//get user id
    	$user_id = User::where('user_roll','=',$user_roll)
        			   ->pluck('user_id');

        $user = User::where('user_roll','=',$user_roll)
        			->first();

        if( $user->user_type != 1 && $user->user_type !=0)
        {
	    	$team_member = TeamMember::where('user_id','=',$user_id)
	    							 ->where('team_id','=',$team_id)
	    							 ->first();
	    	if($team_member == NULL)
	    	{
	    		return JSONResponse::response(401);
	    	}
        }			

    	
    	$task = new Task;

    	$task->task_name = $task_name;
    	$task->task_completed = 0;
    	$task->team_id = $team_id;

    	$success = $task->save();

    	if(!$success)
    	{
    		return JSONResponse::response(200,false);
    	}
    	
    	return JSONResponse::response(200,$task);
    }
}
