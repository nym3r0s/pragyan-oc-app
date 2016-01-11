<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\JSONResponse;
use App\Msg;
use App\User;

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
       	
       	if(count($msgs) > 0)
       	{
	        return JSONResponse::response(200,$msgs);
       	}
       	else
       	{
       		return JSONResponse::response(200,$msgs);
       	}
    }
    public function createTaskMessages(Request $request)
    {
        $user_roll = $request->input('user_roll');
        $user_msg = $request->input('user_msg');
        $task_id = $request->input('task_id');

    }
}
