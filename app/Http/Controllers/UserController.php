<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\user_has_role;
use App\Models\projet;
use App\Models\respoProjet;
use App\Models\role;
use App\Models\notifications;
use App\Models\userHasNotification;
use DB;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

  // Propriee (attribu de la classe)
    //  !!!!!!!!!!!!!!!!  Lien des image  !!!!!!!!!!!!!!!! 
      public $folderLink;
    //  !!!!!!!!!!!!!!!!  Lien des image  !!!!!!!!!!!!!!!! 
    public function __construct()
    {
        $this->folderLink = env('LIEN_FILE');
        $this->middleware('auth');
        $this->middleware('isSuperAdmin');
    }



    //Add a Role 
    public function listeRole()
    {

        $roles = role::all();
        return view('pages.user.listeRole')->with('roles',$roles);

    }
    //Add a user 
    public function addUser()
    {
        $roles = role::all();
        return view('pages.user.addUser')->with('roles',$roles);

    }



    //Insertion d'un user
    public function insertUser(Request $request)
        {

      
                if (!empty($request->file('photo'))) 
                {
                    //recpetion du fichier
                    $myFile = $request->file('photo');
                    $lien = $this->folderLink;
                    // dossier de stockage
                    $path = $myFile->store('ressourceTache','public');
                    // Chemin d'accès de l'image 
                     $src = $lien.$path;
                }
                else
                {
                    $src = 'assets/img/users/user-5.png';
                }
                
            $info = [
                'name' => $request->name,
                'email' => $request->email,
                'matricule' => $request->matricule,
                'prenoms' => $request->prenoms,
                'fonction' => $request->fonction,
                'biographie' => $request->biographie.getSignatureNotif()->valeur,
                'photo' => $src,
                'password' => Hash::make($request->password),

                    ];

            $user = User::create($info);

            $roleUser = ['user_id' =>$user->id,'roles_id'=>$request->role];
            user_has_role::create($roleUser);

            return redirect('/listUser');
        }
    //List of user 
    public function listUser()
        {
            $users=  User::orderBy('id', 'desc')->paginate(20);

            return view('pages.user.listUser')->with('users',$users);
            
        }

    //Show a user 
    public function showUser(Request $request)
        {
            $user = User::find($request->idUser);
            $output = '<div class="profile-widget">
                  <div class="profile-widget-header">
                    <img alt="image" src="'.asset($user->photo).'" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                                <h5 class="modal-title" id="exampleModalLabel">Informations de l\'utilisateur</h5>
                      </div>

                    </div>
                  </div>
                  <div class="profile-widget-description pb-0">
                    <div class="profile-widget-name">'.$user->name.' '.$user->prenoms.' <div class="text-muted d-inline font-weight-normal">
                        <div class="slash"></div>'.$user->fonction.'
                      </div>
                    </div>
                    <p>
                     <ul>

                         <li>Matricule : '.$user->matricule.'</li>
                         <li>Mail : '.$user->email.'</li>
                         <li>Role : '.getRole($user->id)->libelle.' </li>
                         <li>Enregistrer le :'.formatDate($user->created_at).' </li>
                     </ul>   
                    </p>
                  </div>
                </div>';
            return $output;
        }



    //Show a user 
    public function modifUser(Request $request)
    {
        $user = User::find($request->idUser);
        $roles = role::all();
        $roleUser = getRole($user->id)->id;
      
        $output = '<input type="hidden" value="'.$user->id.'"  name="idUser" >';
        $output .= '<div class="row">
            <div class="form-group col-5">
              <label for="nom" class="col-form-label">Nom:</label>
              <input type="text" class="form-control"  id="detailNOM" value="'.$user->name.'"  name="name">
            </div>
            <div class="form-group col-7">
              <label for="prenom" class="col-form-label">Prénom:</label>
              <input type="text" class="form-control" id="detailPRENOM " value="'.$user->prenoms.'" name="prenoms">
            </div>
          </div>
          <div class="form-group">
            <label for="fonction" class="col-form-label">Fonction:</label>
            <input type="text" class="form-control" id="detailFONCTION" value="'.$user->fonction.'" name="fonction">
          </div>
          <div class="form-group">
            <label for="role" class="col-form-label">Role:</label>
            <select class="form-control" name="role" id="detailROLE">';
                foreach($roles as $role)
                {
                    $output.='<option ';
                     if ( $role->id == $roleUser )
                        { $output.='selected '; }
                    $output.='value="'.$role->id.'">'.$role->libelle.'</option>';
                }
        $output.='</select></div>
          <div class="form-group">
            <label for="email" class="col-form-label">Email ou Username:</label>
            <input type="text" placeholder="Adresse mail ou username" class="form-control" id="detailEMAIL" value="'.$user->email.'" name="email">
          </div>
                <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-success" id="saveModif">Enregistrer modifications</button>
      </div>';

        return $output;
    }


    //Supression d'un user
    public function delUser(Request $request)
    {
        // dd($request);
        User::where('id','=',$request->idUser)->delete();
        return response()->json();

    }

    //Update a user 
    public function updtUser(Request $request)
    {
        $info = [
            'name' => $request->name,
            'email' => $request->email,
            'prenoms' => $request->prenoms,
            'fonction' => $request->fonction];

        $user = User::where('id','=',$request->idUser)->update($info);
        $sms = "<center><strong style='color:red; text-align:center'>MODIFICATION DE VOTRE INSTANCE D'UTILISATEUR</strong></center>";

        $userRole = user_has_role::where('user_id','=',$request->idUser)->first();
        if($userRole->roles_id !=$request->role)
        {
            $userRole->update(['roles_id'=>$request->role]);
            $sms .="<h6>Role modifié</h6> Votre role a été modifié par votre administrateur <br> A present vous avez un rôle de type  <b>".getARole($request->role)->libelle."</b><br>";
        }       

            //Alert de l'utilisateur
            $sms .= "<h6>Coordonnées d'utilisateur modifiées</h6>. Ci dessous consultés vos nouvelles données d'identification
                <ul>
                <li>Nom & Prenoms : ".$request->name." </li>
                <li>Matricule : ".$request->email." </li>
                <li>Email : ".$request->prenoms." </li>
                <li>Fonction : ".$request->fonction." </li></ul>";
            $sms .=getSignatureNotif()->valeur;

            $notif = ['titre'=>'MODIFICATION DE VOS COORDONNEES',
                      'message' =>$sms,
                      'sender' =>'ADMIN USER ',
                      'expditeur_id' =>Auth::id()];
            $notification = notifications::create($notif);
            $userNotif =['read_at' =>'',
                         'user_id'=>$request->idUser,
                         'notif_id' => $notification->id
                        ];
            userHasNotification::create($userNotif);


            //Envoie de mail 

         return redirect('/listUser');
    }
    //List of user respo projet
    public function respoProjet()
    {

         $respos = DB::table('respo_projets')
            ->join('users','users.id','=','respo_projets.user_id')
            ->join('projets','projets.id','=','respo_projets.projets_id')
            ->select('projets.*', 'users.*')
            ->get();
        return view('pages.user.respoProjet')->with('respos',$respos);
 
    }
}
