<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notifications;
use App\Models\userHasNotification;
use DB;
use Auth;

class NotificationController extends Controller
{
    
    public function __construct()
    {
         $this->middleware('auth');
    }

    //Rertour la vue de notification
    public function notifView(Request $request)
    {

          $title = "Toutes mes notifications"; 
          $actif = 2; 
          $nbr = (empty($request->all)) ? 30 : 100; 
         $notifs = DB::table('notifications')
            ->join('user_has_notifications','user_has_notifications.notif_id','=','notifications.id')
            ->where('user_has_notifications.user_id','=',Auth::id())
            ->select('notifications.*', 'user_has_notifications.*',
               'notifications.id as notifId','user_has_notifications.id as userHasId')
            ->orderBy('notifications.id', 'desc')->paginate($nbr);


        return view('pages.notif.notifView')->with('notifs',$notifs)
                                        ->with('actif',$actif)
                                        ->with('title',$title);
    }


    //Notifiaction non lu
    public function notReadedNotif()
    {
          $title = "Notifications Non consultées"; 
          $actif = 0; 
          $nbr = (empty($request->all)) ? 30 : 100; 
         $notifs = DB::table('notifications')
            ->join('user_has_notifications','user_has_notifications.notif_id','=','notifications.id')
            ->where('user_has_notifications.user_id','=',Auth::id())
            ->where('user_has_notifications.read_at','=','')
            ->select('notifications.*', 'user_has_notifications.*',
               'notifications.id as notifId','user_has_notifications.id as userHasId')
            ->orderBy('notifications.id', 'desc')->paginate($nbr);

     return view('pages.notif.notifView')->with('notifs',$notifs)
                                        ->with('actif',$actif)
                                        ->with('title',$title);
    }

    //Suprimer des notifications de la bd
    public function delNotif(Request $request)
    {
          $data = json_decode(stripslashes($request->data));
          foreach ($data as $key => $value) 
           {
             userHasNotification::find($value)->delete();

           }
           return response()->json();
    }


    //Notification deja consulte
    public function readedNotif()
    {
          $title = "Notifications  lues"; 
          $actif = 1; 
          $nbr = (empty($request->all)) ? 30 : 100; 
         $notifs = DB::table('notifications')
            ->join('user_has_notifications','user_has_notifications.notif_id','=','notifications.id')
            ->where('user_has_notifications.user_id','=',Auth::id())
            ->where('user_has_notifications.read_at','!=','')
            ->select('notifications.*', 'user_has_notifications.*',
               'notifications.id as notifId','user_has_notifications.id as userHasId')
            ->orderBy('notifications.id', 'desc')->paginate($nbr);

     return view('pages.notif.notifView')->with('notifs',$notifs)
                                        ->with('actif',$actif)
                                        ->with('title',$title);
    }


    //Recuperation des notification d'un utilisateur
    public function recupNotif(Request $request)
    {
          $notif = notifications::find($request->idNotif);
          $notUser = userHasNotification::find($request->userHasNotifId);

          $notUser->read_at = ($notUser->read_at != "") ? $notUser->read_at : date('Y-m-d H:i');

          $notUser->save();

     return $notif->message;
    }
}
