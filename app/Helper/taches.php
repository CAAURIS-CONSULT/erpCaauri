<?php

use App\Models\role;
use App\Models\user_has_role;
use App\Models\User;
use App\Models\entreprise;
use App\Models\niveauEvolution;
use App\Models\projet;
use App\Models\taches;




//Get all the task of a user

if(!function_exists('getUserTask'))
{
	function getUserTask($idUser)
	{


         $task = DB::table('user_has_taches')
            ->join('users','users.id','=','user_has_taches.user_id')
            ->join('taches','taches.id','=','user_has_taches.taches_id')
            ->where('user_has_taches.user_id','=',$idUser)
            ->select('taches.*', 'users.*','user_has_taches.attributed_at','taches.id as idTask')
            ->get();	
 
			return $task;	
	}
}


if(!function_exists('getAllTask'))
{
	function getAllTask()
	{


        $taches=  taches::orderBy('id', 'desc')->paginate(20);
			return $taches;	
	}
}


//Get a info of single task of an user
if(!function_exists('getUserTaskInfo'))
{
	function getUserTaskInfo($idUser,$idTask)
	{
         $task = DB::table('user_has_taches')
            ->join('users','users.id','=','user_has_taches.user_id')
            ->join('taches','taches.id','=','user_has_taches.taches_id')
            ->where('user_has_taches.user_id','=',$idUser)
            ->where('taches.id','=',$idTask)
            ->select('taches.*', 'users.*','user_has_taches.*')
            ->first();	

			return $task;	
	}
}


//Format task for calendar 
if(!function_exists('formatTask'))
{
	function formatTask($taskCollection)
	{

	
 
			return $formatedTask;	
	}
}


//Get a user Notif
if(!function_exists('getUserNotif'))
{
	function getUserNotif($idUser)
	{
         $notifs = DB::table('notifications')
            ->join('user_has_notifications','user_has_notifications.notif_id','=','notifications.id')
            ->where('user_has_notifications.user_id','=',Auth::id())
            ->where('user_has_notifications.read_at','=','')
            ->select('notifications.*', 'user_has_notifications.*',
               'notifications.id as notifId','user_has_notifications.id as userHasId')
            ->orderBy('notifications.id', 'desc')->paginate(10);
		return $notifs;
	}
}





?>