<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\JSONResponse;
use App\Helpers\CheckLevel;
use App\User;
use App\Task;
use App\Assigned;
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

    public function updateTask(Request $request)
    {
        $user_roll	= $request->input('user_roll');

        $task_name = $request->input('task_name'); 
        $task_id = $request->input('task_id'); 
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

    	
    	$task = Task::where('task_id','=',$task_id)
    				->first();
    	if($task == NULL)
    	{
    		return JSONResponse::response(400);
    	}

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

    public function updateTaskStatus(Request $request)
    {
    	$user_roll	= $request->input('user_roll');

        $task_id = $request->input('task_id'); 
    	$team_id   = $request->input('team_id');
    	$task_status = $request->input('task_status');
    	$valid_task_status = array(0,1,2);

    	if(!in_array($task_status,$valid_task_status))
    	{
    		return JSONResponse::response(400);
    	}

    	//get user id
    	$user_id = User::where('user_roll','=',$user_roll)
        			   ->pluck('user_id');

        $user = User::where('user_roll','=',$user_roll)
        			->first();

        // Make sure that the guy is part of the team
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


    	$task = Task::where('task_id','=',$task_id)
    				->first();
    	if($task == NULL)
    	{
    		return JSONResponse::response(400);
    	}

    	$task->task_completed = $task_status;

    	$success = $task->save();

    	if(!$success)
    	{
    		return JSONResponse::response(200,false);
    	}
    	
    	return JSONResponse::response(200,$task);

    }


    public function getAllTasks(Request $request)
    {
    	$user_roll	= $request->input('user_roll');


    	$user_id = User::where('user_roll','=',$user_roll)
        			   ->pluck('user_id');

        $exported_fields = [
        	'tasks.task_id',
        	'task_name',
        	'task_name',
        	'task_completed',
        	'teams.team_id',
        	'team_name',
        ];

    	$task_list = Assigned::where('user_id','=',$user_id)
    						->leftJoin('tasks','assigned.task_id','=','tasks.task_id')
    						->leftJoin('teams','tasks.team_id','=','teams.team_id')
    						->select($exported_fields)
    						->get();



    	return JSONResponse::response(200,$task_list);
    }

    public function assignPeople(Request $request)
    {
    	$user_roll	= $request->input('user_roll');
        $task_id = $request->input('task_id');

        $assigned_list = $request->input('assigned_list');
        $assigned_ids = explode(',', $assigned_list);

    	if(!CheckLevel::check(2,NULL,$user_roll))
    	{
    		return JSONResponse::response(401);
    	}


        $task = Task::where('task_id','=',$task_id)
        		    ->first();

    	if($task == NULL)
    	{
    		return JSONResponse::response(400);
    	}

        $user_list = User::leftJoin('team_members','team_members.user_id','=','users.user_id')
        				 ->whereIn('users.user_id',$assigned_ids)
        				 ->where('team_members.team_id','=',$task->team_id)
        				 ->get();

    	if(count($user_list) != count($assigned_ids))
    	{
    		return JSONResponse::response(400);
    	}

    	foreach ($user_list as $key => $user)
    	{
    		// echo "\ninserting".$task_id." ".$user->user_id;
    		$a = new Assigned;
    		$a->task_id = $task_id;
    		$a->user_id = $user->user_id;
    		$success = $a->save();
    		// echo "\n".$success;
		}	

		return JSONResponse::response(200,true);
    }
}
