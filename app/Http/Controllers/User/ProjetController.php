<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\entreprise;
use App\Models\User;
use App\Models\projet;
use App\Models\respoProjet;

class ProjetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    //Add an entreprise 
    public function addProj()
    {

        $users = User::all();
        $projet = projet::max('mat');
        $entreprises = entreprise::all();
        return view('pages.projet.addProj')->with('users',$users)->with('entreprises',$entreprises)->with('projet',$projet);
    }

    //Inserer an entreprise 
    public function insertPrj(Request $request)
    {    

        $info  =['mat' => $request->mat,
                 'libelleProjet' => $request->libelleProjet,
                 'entreprises_id' => $request->entreprises_id
                ];
        $projet  = projet::create($info);
        $respoProjet  = ['user_id'=>$request->user_id,
                        'projets_id'=>$projet->id];

        respoProjet::create($respoProjet);

        return redirect('/listProj');   
    }


    //List of entreprise 
    public function listProj()
    {
        $projets  = projet::orderBy('id', 'desc')->paginate(20);
        return view('pages.projet.listProj')->with('projets',$projets);   
    }

    //show projet
    public function modifPrj(Request $request)
        {
            $prj = projet::find($request->idPrj);
            $users = User::all();
            $respo = getRespoProjet($prj->id)->id;
            $entrs = entreprise::all();
            $output = '<input type="hidden" value="'.$prj->id.'"  name="idPrj" >';
            $output .= '<div class="row">
                        <div class="form-group col-6">
                            <label for="libelleProjet">Identification</label>
                            <input id="libelleProjet" type="text" class="form-control" name="mat" value="'.$prj->mat.'" >
                        </div>
                        <div class="form-group col-6">
                            <label for="libelleProjet">Désignation du projet</label>
                            <input id="libelleProjet" type="text" class="form-control" name="libelleProjet" value="'.$prj->libelleProjet.'"  >
                        </div>
                        <div class="form-group col-6">
                          <label>Chargé du projet</label>
                            <select class="form-control" name="user_id" id="">';
                                foreach($users as $user)
                                {
                                    $output.='<option ';
                                     if ( $user->id == $respo )
                                        { $output.='selected '; }
                                    $output.='value="'.$user->id.'">'.$user->name.' '.$user->prenoms.'</option>';
                                }
                        $output.='</select>
                        </div>
                        <div class="form-group col-6">
                          <label>Entreprises</label>
                            <select class="form-control" name="entreprises_id" id="">';
                                foreach($entrs as $entr)
                                {
                                    $output.='<option ';
                                     if ( $entr->id == $prj->entreprises_id )
                                        { $output.='selected '; }
                                    $output.='value="'.$entr->id.'">'.$entr->nom.'</option>';
                                }
                        $output.='</select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success" id="saveModif">Enregistrer modifications</button>
                  </div>';
            return $output;
        }



    //Update a user 
    public function updtPrj(Request $request)
    {
        $info  =['mat' => $request->mat,
                 'libelleProjet' => $request->libelleProjet,
                 'entreprises_id' => $request->entreprises_id
                ];
        $projet  = projet::where('id','=',$request->idPrj)->update($info);

        $respoProjet  = ['user_id'=>$request->user_id,
                        'projets_id'=>$request->idPrj];

        respoProjet::where('projets_id','=',$request->idPrj)->update($respoProjet);
        return redirect('/listProj');
    }



    //OBTENIR LES projets d'une entrerise 
        public function getProjet(Request $request)
        {
            $prjs=projet::where('entreprises_id','=',$request->idEntr)->orderBy('id', 'desc')->get();
            $output ="";
            foreach ($prjs as $prj) {
                $output .='<option value="'.$prj->id.'">'.$prj->libelleProjet.'</option>';
            }
            return $output;
        }
    //Supression d'un user
    public function delPrj(Request $request)
    {
        // dd($request);
        projet::where('id','=',$request->idPrj)->delete();
        return response()->json();

    }
}
