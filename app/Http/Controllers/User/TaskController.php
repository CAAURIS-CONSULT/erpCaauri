<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\taches;
use App\Models\user_has_taches;
use App\Models\commentairesTache;
use App\Models\ressourcesTache;
use App\Models\typeRessources;

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
    }




    //List of tache 
    public function userListTask()
    {
        // $taches=  taches::orderBy('id', 'desc')->paginate(20);
         $task = DB::table('user_has_taches')
            ->join('users','users.id','=','user_has_taches.user_id')
            ->join('taches','taches.id','=','user_has_taches.taches_id')
            ->where('user_has_taches.user_id','=',Auth::id())
            ->select('taches.*', 'users.*','taches.id as idTask')
            ->orderBy('user_has_taches.id', 'desc')->paginate(20);   

            return view('pages.userDash.listTask')->with('taches',$task);
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

           // dd($execs);
            $output ='<tbody>
                            <tr>
                            <th>N°</th>
                            <th>Nom & Prenoms</th>
                            <th>Profil</th>
                            <th>Attribué le</th>
                          </tr>';
                $i = 0; //Compteur

                foreach($execs as $exec)
                {   
                    //info user
                    $user = getUser($exec->user_id);
                    $output.='<tr>
                            <td>'.$i++.'</td>
                            <td>'.$user->name.' '.$user->prenoms.'</td>
                            <td><img alt="image" src="'.asset($user->photo).'" class="rounded-circle" width="35"></td>
                            <td>'.$exec->attributed_at.'</td>
                             </tr>';     
                }
        $output.='</tbody>';

        return $output;    

    }

    

    //Montre la tache d'un utilisateur
    public function showUserTask(Request $request)
    {
        
        $task = taches::find($request->task);
        
         $ressources = DB::table('ressources_taches')
            ->join('type_ressources','type_ressources.id','=','ressources_taches.type_id')
            ->where('ressources_taches.taches_id','=',$request->task)
            ->select('ressources_taches.*', 'type_ressources.*')
            ->orderBy('ressources_taches.id', 'desc')->get();  

        $comment = commentairesTache::where('taches_id',$request->task)->orderBy('id','desc')->get();
        // dd($comment);

        //Initialiser le moment de la l'ouverture de la tache
            $userTask = user_has_taches::where([['user_id','=',Auth::id()],
                                            ['taches_id','=',$request->task]])->first();
            if (!$userTask->read_at) 
            {
                //Premiere ouverture de la tache ==> Initialisation
                    $userTask->read_at = date('Y-m-d H:i');
                    $userTask->save();                
            }
        return view('pages.userDash.showUserTask')->with('tache',$task)
                                                  ->with('ressources',$ressources)
                                                  ->with('comments',$comment);
    }


    //Public function store TaskComment
    public function storeTaskComment(Request $request)
    {
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

        taches::find($request->idTask)->update(['niveau_evolutions_id'=>$request->niveau]);

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

        return redirect('userApp/showUserTask?task='.$request->idTask);
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

    //Recuperation de commentaire 
    public function recupComment(Request $request)
    {
        $comment = commentairesTache::find($request->idComment);
        return $comment->text;
    }




}
