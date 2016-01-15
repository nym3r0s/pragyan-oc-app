global 

user_roll
user_secret


user_type details

0 - God
1 - 4th year
2 - 3rd year
3 - 2nd year

Task_status details 

0 - not completed
1 - in progress
2 - completed

## Routes start here

/profile/getdetails

{
  "status_code": 200,
  "message": {
    "user_roll": "107113071",
    "user_name": "Test",
    "user_phone": "9123123123",
    "user_type": "3",
    "user_teams": [
      {
        "team_id": 1,
        "team_name": "dummy team 1"
      },
      {
        "team_id": 2,
        "team_name": "dummy team 2"
      }
    ]
  }
}

/profile/getalldetails

{
  "status_code": 200,
  "message": [
    {
      "user_roll": "106113097",
      "user_name": "Gokul",
      "user_phone": "9003037906",
      "user_type": "2"
    },
    {
      "user_roll": "123123123",
      "user_name": "asdf",
      "user_phone": "8123123123",
      "user_type": "1"
    },
    {
      "user_roll": "106114045",
      "user_name": "RBK",
      "user_phone": "9123464565",
      "user_type": "0"
    }
  ]
}

/task/create

task_name : the title
team_id : the team in which he is creating

{
  "status_code": 200,
  "message": {
    "task_name": "Get Tubelights from Thuvakudi",
    "task_completed": 0,
    "team_id": "1",
    "updated_at": "2016-01-12 19:52:32",
    "created_at": "2016-01-12 19:52:32",
    "task_id": 6
  }
}

/task/update

task_name : the title
task_id : the id of the task that is being updated
team_id : the team id of the guy

{
  "status_code": 200,
  "message": {
    "task_id": 6,
    "task_name": "Get bulbs from Thuvax",
    "task_completed": 0,
    "team_id": "1",
    "enabled": 1,
    "created_at": "2016-01-12 19:52:32",
    "updated_at": "2016-01-12 19:56:02"
  }
}

/task/status/update

task_id : the id of the task that is being updated
team_id : the team id of the guy
task_status: 0/1/2

Note: remember that task_status is task_completed

{
  "status_code": 200,
  "message": {
    "task_id": 3,
    "task_name": "Google oiuqwer",
    "task_completed": "0",
    "team_id": 1,
    "enabled": 1,
    "created_at": "2016-01-11 06:25:28",
    "updated_at": "2016-01-12 19:57:36"
  }
}

/task/all

{
  "status_code": 200,
  "message": [
    {
      "task_id": 1,
      "task_name": "Task 1",
      "task_completed": "0",
      "team_id": 1,
      "team_name": "dummy team 1"
    },
    {
      "task_id": 3,
      "task_name": "Google oiuqwer",
      "task_completed": "0",
      "team_id": 1,
      "team_name": "dummy team 1"
    },
    {
      "task_id": 6,
      "task_name": "Get bulbs from Thuva",
      "task_completed": "0",
      "team_id": 1,
      "team_name": "dummy team 1"
    }
  ]
}

/task/assign

task_id : the id of the task
assigned_list : the list of roll numbers assigned to this task (eg) "106114045,107113112"

NOTE: This method overwrites the previously assigned people to this task.
It is wise to call `/task/getassigned` before sending the request as you can then amend 
the list of roll numbers assigned to the task.

{
  "status_code": 200,
  "message": true
}

/task/delete

task_id : the id of the task to be deleted.

{
  "status_code": 200,
  "message": true
}

/task/chat/read

task_id
from_id : send -1 initially when there are no msgs. else send id of the last msg.

{
  "status_code": 200,
  "message": [
    {
      "msg_id": 2,
      "task_id": 1,
      "user_name": "Gokul",
      "created_at": "2016-01-11 06:02:17",
      "msg_data": "Hey da"
    },
    {
      "msg_id": 3,
      "task_id": 1,
      "user_name": "Gokul",
      "created_at": "2016-01-11 06:02:57",
      "msg_data": "Hey da"
    },
    {
      "msg_id": 4,
      "task_id": 1,
      "user_name": "Gokul",
      "created_at": "2016-01-11 06:02:57",
      "msg_data": "Hey da"
    },
    {
      "msg_id": 5,
      "task_id": 1,
      "user_name": "Test",
      "created_at": "2016-01-11 06:03:55",
      "msg_data": "Hello from the other side"
    }
  ]
}

/task/chat/create

user_msg: the message he types.
task_id : the task

{
  "status_code": 200,
  "message": [
    {
      "msg_id": 6,
      "task_id": 6,
      "user_name": "Gokul",
      "created_at": "2016-01-12 20:22:35",
      "msg_data": "Hi RB"
    }
  ]
}

/task/target/all

user_target_roll: roll no of the guy whose tasks you want

{
  "status_code": 200,
  "message": [
    {
      "task_id": 1,
      "task_name": "Task 1",
      "task_completed": "0",
      "team_id": 1,
      "team_name": "dummy team 1"
    },
    {
      "task_id": 3,
      "task_name": "Google oiuqwer",
      "task_completed": "0",
      "team_id": 1,
      "team_name": "dummy team 1"
    }
  ]
}

/task/getassigned

task_id

{
  "status_code": 200,
  "message": [
    {
      "user_roll": "107113071",
      "user_name": "Test"
    },
    {
      "user_roll": "106113097",
      "user_name": "Gokul"
    },
    {
      "user_roll": "123123123",
      "user_name": "asdf"
    }
  ]
}

## Format for the push notifications

{
  "type":"message",
  "message": { 
  }
}

`message` will be what you get as `message` in 
any other path.

Types (field `type`)


* `message`

When a new message in the chat for a task arrives, 
a push notification is sent to the mobile to all
the assigned members

{
  "type": "message",
  "message": {
    "msg_id": 24,
    "task_id": 1,
    "user_name": "Gokul",
    "created_at": "2016-01-15 19:44:22",
    "msg_data": "Hey New push 2"
  }
}

* `newtask`

When a task is assigned to the user,
a push notification is sent to the assigned users.

{
  "type": "message",
  "message": {
    "task_id": 6,
    "task_name": "Get bulbs from Thuva",
    "task_completed": "0",
    "team_id": 1,
    "enabled": 1,
    "created_at": "2016-01-12 19:52:32",
    "updated_at": "2016-01-12 20:06:01"
  }
}

* `taskstatusupdate`

When the status of the task is updated
a push notification is sent to assigned with this json

{
  "type": "taskstatusupdate",
  "message": {
    "task_id": 3,
    "task_name": "Google oiuqwer",
    "task_completed": "1",
    "team_id": 1,
    "enabled": 1,
    "created_at": "2016-01-11 06:25:28",
    "updated_at": "2016-01-15 20:13:36"
  }
}

* `taskupdate`

When the task in itself (task_name etc) is updated,
a push notification is sent to assigned with this json

{
  "type": "taskupdate",
  "message": {
    "task_id": 3,
    "task_name": "Google asljksf ad",
    "task_completed": 0,
    "team_id": "1",
    "enabled": 1,
    "created_at": "2016-01-11 06:25:28",
    "updated_at": "2016-01-15 20:16:30"
  }
}

* `taskdelete`

When the task is deleted,
a push notification is sent to assigned with this json

{
  "type": "taskdelete",
  "message": {
    "task_id": 3,
    "task_name": "Google asljksf ad",
    "task_completed": "0",
    "team_id": 1,
    "enabled": false,
    "created_at": "2016-01-11 06:25:28",
    "updated_at": "2016-01-15 20:21:51"
  }
}