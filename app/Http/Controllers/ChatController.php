<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\JSONResponse;
use App\Helpers\Push;
use App\Msg;
use App\User;
use App\Assigned;


class ChatController extends Controller
{
    public function getTaskMessages(Request $request)
    {
        $user_roll	= $request->input('user_roll');
        $task_id 	= $request->input('task_id');
        $from_id 	= $request->input('from_id');


        $exported_fields = [
        	"msg.msg_id",
        	"msg.task_id",
        	"users.user_name",
        	"msg.created_at",
        	"msg.msg_data",
        ];

        $msgs = Msg::join('users','users.user_id','=','msg.user_id')
        		   ->where('task_id','=',$task_id)
        		   ->where('msg_id','>',$from_id)
        		   ->select($exported_fields)
        		   ->get();
       	
       	//return Array even if it is empty
   		return JSONResponse::response(200,$msgs);
    }
    public function createTaskMessages(Request $request)
    {
        $user_roll = $request->input('user_roll');
        $user_msg = $request->input('user_msg');
        $task_id = $request->input('task_id');

        $user_id = User::where('user_roll','=',$user_roll)
        			   ->pluck('user_id');
        
        $msg = new Msg;
        $msg->user_id = $user_id;
        $msg->task_id = $task_id;
        $msg->msg_data = $user_msg;
    	
    	$success = $msg->save();

    	if(!$success)
    	{
	        return JSONResponse::response(200,false);
    	}
    
    	// if success return the msg
        $exported_fields = [
        	"msg.msg_id",
        	"msg.task_id",
        	"users.user_name",
        	"msg.created_at",
        	"msg.msg_data",
        ];

    	$saved_msg = Msg::join('users','users.user_id','=','msg.user_id')
				    	->where('msg_id','=',$msg->msg_id)
				    	->select($exported_fields)
				    	->first();

        // Push Notification Code starts here
        $task_user_rolls = Assigned::where('task_id','=',$task_id)
                                   ->leftJoin('users','assigned.user_id','=','users.user_id')
                                   ->lists('user_roll');

        $push_message = Push::jsonEncode('message',$saved_msg);
        Push::sendMany($task_user_rolls,$push_message);
        // Push Notification Code ends here

        return JSONResponse::response(200,$saved_msg);
    	
    }
}
