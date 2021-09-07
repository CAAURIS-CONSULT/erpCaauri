<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\taches;
use App\Models\user_has_taches;
use App\Models\commentairesTache;
use App\Models\ressourcesTache;
use App\Models\typeRessources;
use App\Models\notifications;
use App\Models\userHasNotification;

use DB;
use Auth;



class TaskController extends Controller
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


    //Add an tache 
    public function addTask()
    {
        return view('pages.taches.addTask');
    }


    //Insertion de tache 
    public function insertTask(Request $request)
    {
        //Reception de donnees du formulaire TaskForm
            $info = [
             'nomTache'=>$request->nomTache,
             'description'=>$request->description,
             'delaisExec'=>$request->delaisExec, 
             'niveau_evolutions_id'=>$request->niveau_evolutions_id,    
             'entreprises_id'=>$request->entreprises_id, 
             'projets_id'=>$request->projets_id
         ] ;

         //Creation taches
         $tast = taches::create($info);

         //Insertion respo projet as executant
            //Recup respo 
             $respo = getRespoProjet($request->projets_id);

            //Notification au chef du projet 
                // **************************
                //  SYSTEME DE NOTIFICATION 
                // **************************
                $sms = "<center><strong style='color:red; text-align:center'>NOUVELLE TACHE DE PROJET</strong></center>";      

            //Alert de l'utilisateur
            $sms .= "<h6>Vous êtes responsable de la suivit du projet </h6> Cet message tient lieu d'information de l'ajout d'une nouvelle tache au projet sus-cité. Ci dessous un recapitualtif
                <ul>
                <li>Entreprises : ".getEntreprise($request->entreprises_id)->nom." </li>
                <li>Projet : ".getPrj($request->projets_id)->libelleProjet." </li>
                <li style='color:blue; font-weight: bold;'>Nouvelle tache : ".$request->nomTache." </li>
                <li style='color:red; font-weight: bold;'>Deadline Tache : ".$request->delaisExec." </li></ul>
                <i>Consulter la tache en parcourant votre liste de tache / l'onglet Respo Projet</i>";
            $sms .=getSignatureNotif()->valeur;

            $notif = ['titre'=>'AJOUT DE TACHE A UN PROJET DONT VOUS ETES RESPONSABLE',
                      'message' =>$sms,
                      'sender' =>'SYSTEME GESTION DES PROJETS ',
                      'expditeur_id' =>Auth::id()];
            $notification = notifications::create($notif);
            $userNotif =['read_at' =>'',
                         'user_id'=>$respo->user_id,
                         'notif_id' => $notification->id
                        ];
            userHasNotification::create($userNotif);
        return redirect('/listTask');
    }

    //List of tache 
    public function listTask()
    {
        $taches=  taches::orderBy('id', 'desc')->paginate(20);
        return view('pages.taches.listTask')->with('taches',$taches);
    }


    //Recup executant taches
    public function showExc(Request $request)
    {
        //reception de donnees
            $idTask = $request->idTask;
            return $this->showListExec($idTask);
    }

    //Affiche la liste des executant 
    public function showListExec($idTask)
    {
           $execs = user_has_taches::where('taches_id','=' ,$idTask)->get();
                // dd($execs);

            $output ='<tbody>
                            <tr>
                            <th>N°</th>
                            <th>Nom & Prenoms</th>
                            <th>Profil</th>
                            <th>Attribué le</th>
                            <th>Action</th>
                          </tr>';
                $i = 0; //Compteur

                foreach($execs as $exec)
                {   
                    //info user
                    $user = getUser($exec->user_id);
                    $output.='<tr>
                            <td>'.$i++.'</td>
                            <td>'.$user->name.' '.$user->prenoms.'</td>
                            <td><img alt="image" src="'.$user->photo.'" class="rounded-circle" width="35"></td>
                            <td>'.$exec->attributed_at.'</td>
                            <td><a href="#" idTask="'.$exec->taches_id.'" idUser="'.$user->id.'"  
                             class="btn btn-danger delExc">Suprimer</a></td>
                             </tr>';     
                }
        $output.='</tbody>';

        //Script d'activation des boutons
        $output.="<script type='text/javascript'>
                  $('.delExc').click(function(event)
                  {
                    var idTask = $(this).attr('idTask');
                    var idUser = $(this).attr('idUser');
                    $.ajax({
                            url: 'delExc',
                            method:'GET',
                            data: {idTask:idTask,idUser:idUser},
                            dataType:'html',
                            success:function(data)
                                    {
                                    $('#tableContent').html(data);
                                    },
                            error:function(){
                                    toastr.error('Erreur ! Problème de connexion internet ');
                                                            
                                    }
                        });
                  })



        </script>";

        return $output;    

    }

    //Ajout d'executant d'une tache
    public function addExec(Request $request)
    {
        //reception de donnees
          $user = $request->user;
          $dateTache = $request->dateTache;
          $idTask = $request->idTask;
        //Insertion de l'executant 
          $task = ['user_id'=>$user,'taches_id'=>$idTask,'attributed_at'=>$dateTache];
          user_has_taches::create($task);

                // **************************
                //  SYSTEME DE NOTIFICATION 
                // **************************
            $sms = "<center><strong style='color:red; text-align:center'>NOUVELLE TACHES</strong></center>";      
            $tache = taches::find($idTask);

            //Alert de l'utilisateur
            $sms .= "<h6>Une nouvelle tâche vous a été confié </h6> Cet message tient lieu d'information de l'ajout d'une nouvelle tache à votre agenda. Ci dessous un recapitualtif
                <ul>
                <li>Entreprises : ".getEntreprise($tache->entreprises_id)->nom." </li>
                <li>Projet : ".getPrj($tache->projets_id)->libelleProjet." </li>
                <li style='color:blue; font-weight: bold;'>Nouvelle tache : ".$tache->nomTache." </li>
                <li style='color:red; font-weight: bold;'>Deadline Tache : ".$tache->delaisExec." </li></ul>
                <i>Consulter la tache en parcourant votre liste de tache </i>";
            $sms .=getSignatureNotif()->valeur;

            $notif = ['titre'=>'NOUVELLE TACHE A EXECUTER',
                      'message' =>$sms,
                      'sender' =>'ALERT TACHE ',
                      'expditeur_id' =>Auth::id()];
            $notification = notifications::create($notif);
            $userNotif =['read_at' =>'',
                         'user_id'=>$request->user,
                         'notif_id' => $notification->id
                        ];

            userHasNotification::create($userNotif);
        //Recuperation de la liste des executants du projets
            return  $this->showListExec($idTask);      
    }


    //Del executant 
    public function delExc(Request $request)
    {
        // recup val
        $user = $request->idUser;
        $idTask = $request->idTask;
        $exec = [['user_id','=',$user], ['taches_id', '=', $idTask]];
        user_has_taches::where($exec)->delete();

        //Recuperation de la liste des executants du projets
           return  $this->showListExec($idTask);

    }

    //Modif a a task
    public function modifTask( Request $request)
    {
        $idTask = $request->idTask;
        $task = taches::find($idTask);
        $output = '';

        $niveaux = getAllNiveau();
        $niveauTask = $task->niveau_evolutions_id;
        //Show info task in form
        $output .="<div class='row'>
                       <div class='form-group col-6'>
                            <label for='nomTache'>Projet</label>
                            <input id='prjt' type='text' class='form-control' name='prjt'  value='".getPrj($task->projets_id)->libelleProjet."' readonly>
                        </div>
                       <div class='form-group col-6'>
                            <label for='nomTache'>Nom de la tâche</label>
                            <input id='nomTache' type='text' class='form-control' name='nomTache'  value='".$task->nomTache."'>
                        </div>
                    <div class='form-group col-6'>
                      <label for='delaisExec'>Deadline de la tache</label>

                      <input id='delaisExec' type='date' class='form-control' name='delaisExec' value='".$task->delaisExec."'>
                    </div>
                    <div class='form-group col-6'>
                      <label for='niveau_evolutions_id'>Niveau d'evolution</label>
                            <select class='form-control' name='niveau_evolutions_id'>";
                                  foreach($niveaux as $level)
                                  {
                                    $output.='<option ';
                                     if ( $level->id == $niveauTask )
                                        { $output.='selected '; }
                                    $output.='value="'.$level->id.'">'.$level->libelle.'</option>';
                                    
                                  }    
                    $output.="</select>
                    </div>

                    <div class='form-group col-12'>
                      <label>Description de la tache</label>
                      <textarea class='form-control' name='description'>".$task->description."</textarea>
                    </div>
                  <div class='form-group col-12 '>
                    <button type='submit' class='btn btn-primary btn-lg btn-block' id='sendForm' style='font-size:20px' >
                      Enregistrer
                    </button>
                  </div>";


        return $output;
    }

    //Update les task
    public function updtTask(Request $request)
    {

        //rECEPTION DES DONNEES
            $info = [
             'nomTache'=>$request->nomTache,
             'description'=>$request->description,
             'delaisExec'=>$request->delaisExec, 
             'niveau_evolutions_id'=>$request->niveau_evolutions_id,    
         ] ;

         $tache = taches::find($request->idTask);
         $tache->update($info);

                // **************************
                //  SYSTEME DE NOTIFICATION 
                // **************************
            $sms = "<center><strong style='color:red; text-align:center'>MODIFICATION DE TACHE</strong></center>";

            //Alert de l'utilisateur
            $sms .= "<h6>La tache < ".$tache->nomTache." ></h6> Cet message tient lieu d'information de l'ajout d'une nouvelle tache à votre agenda. Ci dessous un recapitualtif
                <ul>
                <li>Entreprises : ".getEntreprise($tache->entreprises_id)->nom." </li>
                <li>Projet : ".getPrj($tache->projets_id)->libelleProjet." </li>
                <li style='color:blue; font-weight: bold;'>Nom  tache : ".$tache->nomTache." </li>
                <li style='color:red; font-weight: bold;'>Deadline Tache : ".$tache->delaisExec." </li></ul>
                <i>Consulter la tache en parcourant votre liste de tache </i>";
            $sms .=getSignatureNotif()->valeur;

            $notif = ['titre'=>'MODIFICATION DE TACHE',
                      'message' =>$sms,
                      'sender' =>'ALERT TACHE ',
                      'expditeur_id' =>Auth::id()];
            $notification = notifications::create($notif);

            //Get executant d'une taches 
              $execs = user_has_taches::where('taches_id','=' ,$tache->id)->get();
                foreach($execs as $exec)
                    {   
                        //info user
                        $userNotif =
                            ['read_at' =>'',
                             'user_id'=>$exec->user_id,
                             'notif_id' => $notification->id
                            ];
                        userHasNotification::create($userNotif);
                    }


         return redirect('/listTask');
    }

    //Del task 
    public function delTask(Request $request)
    {
        $idTask = $request->idTask;
        $tache = taches::find($idTask);

                // **************************
                //  SYSTEME DE NOTIFICATION 
                // **************************
            $sms = "<center><strong style='color:red; text-align:center'>SUPPRESSION DE DE TACHE</strong></center>";

            //Alert de l'utilisateur
            $sms .= "<h6>Suppression de la tache < ".$tache->nomTache." ></h6> La tache spécifié ci-dessus a été suprimé par votre administrateur. Elle disparaitra de votre agenda. Ci dessous les informations de la tache :
                <ul>
                <li>Entreprises : ".getEntreprise($tache->entreprises_id)->nom." </li>
                <li>Projet : ".getPrj($tache->projets_id)->libelleProjet." </li>
                <li style='color:blue; font-weight: bold;'>Nom tache : ".$tache->nomTache." </li></ul>";

            $sms .=getSignatureNotif()->valeur;

            $notif = ['titre'=>'SUPPRESSION DE TACHE',
                      'message' =>$sms,
                      'sender' =>'ALERT TACHE ',
                      'expditeur_id' =>Auth::id()];
            $notification = notifications::create($notif);

            //Get executant d'une taches 
              $execs = user_has_taches::where('taches_id','=' ,$tache->id)->get();
                foreach($execs as $exec)
                    {   
                        //info user
                        $userNotif =
                            ['read_at' =>'',
                             'user_id'=>$exec->user_id,
                             'notif_id' => $notification->id
                            ];
                        userHasNotification::create($userNotif);
                    }

        $tache->delete();
        return response()->json();
    }

    //List of tache 
    public function doingTask()
    {
        return view('pages.taches.doingTask');   
    }

    //List of tache 
    public function doneTask()
    {
        return view('pages.taches.doneTask');   
    }

    //Montre la tache d'un utilisateur
    public function showTask(Request $request)
    {
        
        $task = taches::find($request->task);
        
         $ressources = DB::table('ressources_taches')
            ->join('type_ressources','type_ressources.id','=','ressources_taches.type_id')
            ->where('ressources_taches.taches_id','=',$request->task)
            ->select('ressources_taches.*', 'type_ressources.*')
            ->orderBy('ressources_taches.id', 'desc')->get();


        $comment = commentairesTache::where('taches_id',$request->task)
                                            ->orderBy('id','desc')->get();

            

        // dd($comment);
        $exec = user_has_taches::where('taches_id','=' ,$request->task)->first();

// dd($exec);
        return view('pages.taches.showTask')->with('tache',$task)
                                                  ->with('exec',$exec)
                                                  ->with('ressources',$ressources)
                                                  ->with('comments',$comment);
    }



    //Public function store TaskComment
    public function storeTaskComment(Request $request)
    {
        // dd($request);
        $msg = [
                'text'=>$request->description,
                'titre'=>$request->titre,
                'user_id'=> Auth::id(),
                'taches_id'=> $request->idTask,
                'niveau_evolutions_id'=> $request->niveau,
            ];
        commentairesTache::create($msg);

            //Update du last modif
                user_has_taches::where([['user_id','=',Auth::id()],
                                            ['taches_id','=',$request->idTask]])
                                        ->update(['last_modif'=>date('Y-m-d H:i')]);

        $tache = taches::find($request->idTask);
        $tache->update(['niveau_evolutions_id'=>$request->niveau]);


                // **************************
                //  SYSTEME DE NOTIFICATION 
                // **************************
            $sms = "<center><strong style='color:red; text-align:center'>NOUVEAU COMMENTAIRE DE TACHE</strong></center>";

            //Alert de l'utilisateur
            $sms .= "<h6>La tache < ".$tache->nomTache."> a été commenté </h6> La tache spécifié ci-dessus vient d'être commenté par un utilisateur / administrateur de la plateforme. Consulter les infomations
                <ul>
                <li>Entreprises : ".getEntreprise($tache->entreprises_id)->nom." </li>
                <li>Projet : ".getPrj($tache->projets_id)->libelleProjet." </li>
                <li style='color:blue; font-weight: bold;'>Nom tache : ".$tache->nomTache." </li></ul>";

            $sms .=getSignatureNotif()->valeur;

            $notif = ['titre'=>'COMMENTAIRE DE TACHE',
                      'message' =>$sms,
                      'sender' =>'GESTION TACHE ',
                      'expditeur_id' =>Auth::id()];
            $notification = notifications::create($notif);

            //Get executant d'une taches 
              $execs = user_has_taches::where('taches_id','=' ,$tache->id)->get();
                foreach($execs as $exec)
                    {   
                        //info user
                        $userNotif =
                            ['read_at' =>'',
                             'user_id'=>$exec->user_id,
                             'notif_id' => $notification->id
                            ];
                        userHasNotification::create($userNotif);
                    }
        //Enregistrement des fichiers ressourcs dans la BD
            //Verifie si des fichiers ont été soummis 
                if (!empty($request->file('file1'))) 
                {
                    $fileName = (empty($request->file1Name)) ? 'file1': $request->file1Name ;
                    $this->saveRessourcesFile($request->file('file1'),$fileName,$request->idTask);
                }
                 if (!empty($request->file('file2'))) 
                {
                    $fileName = (empty($request->file2Name)) ? 'file2': $request->file2Name ;
                    $this->saveRessourcesFile($request->file('file2'),$fileName,$request->idTask);
                }
                 if (!empty($request->file('file3'))) 
                {
                    $fileName = (empty($request->file3Name)) ? 'file3': $request->file3Name ;
                    $this->saveRessourcesFile($request->file('file3'),$fileName,$request->idTask);
                }

        return redirect('showTask?task='.$request->idTask);
    }


    public function saveRessourcesFile($myFile,$fileName,$taskId)
    {
            $lien = $this->folderLink;
            // dossier de stockage
             $path = $myFile->store('ressourceTache','public');

            // Chemin d'accès de l'image 
             $src = $lien.$path;

            //Get type
             $ext = fileExtension($src);
             $type = typeRessources::where('extension',$ext)->first();

            // Données
             $dataImg1 = ['nom'=>$fileName,
                          'lien' =>$src,
                          'taches_id'=>$taskId,
                          'type_id' =>$type->id];

            // Enregistrement
            ressourcesTache::create($dataImg1);

    }




}
