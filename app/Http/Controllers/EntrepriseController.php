<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\entreprise;
use App\Models\User;


class EntrepriseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isSuperAdmin');
    }


    //Add an entreprise 
    public function addEntr()
    {


        return view('pages.entreprise.addEntr');
    }


    //Inserer an entreprise 
    public function insertEntr(Request $request)
    {    

        $info  = ['matricule'=>$request->matricule,
                  'nom'=>$request->name,
                  'contact'=>$request->contact,
                  'adresse'=>$request->adresse,
                  'email'=>$request->email,
                  'image'=>$request->image,
                  'responsable'=>$request->responsable,
                  'contactRespo'=>$request->contactRespo
              ];

        entreprise::create($info);
        return redirect('/listEntr');   
    }
    //List of entreprise 
    public function listEntr()
    {
        $entreprises = entreprise::orderBy('id', 'desc')->paginate(20);
        return view('pages.entreprise.listEntr')->with('entreprises',$entreprises);   
    }


    //Show a user 
    public function showEntr(Request $request)
        {
            $entreprise = entreprise::find($request->idEntr);
    
            $output = '';
            $output .= '<form>
              <input type="hidden" value="'.$entreprise->id.'" >
              <div class="row">
                <div class="form-group col-5">
                  <label for="nom" class="col-form-label">Nomination:</label>
                  <input type="text" class="form-control"  id="detailNOM" value="'.$entreprise->nom.'" readonly >
                </div>
                <div class="form-group col-7">
                  <label for="prenom" class="col-form-label">Contact:</label>
                  <input type="text" class="form-control" id="detailPRENOM " value="'.$entreprise->contact.'" readonly>
                </div>
              </div>
              <div class="form-group">
                <label for="fonction" class="col-form-label">Adresse:</label>
                <input type="text" class="form-control" id="adresse" value="'.$entreprise->adresse.'" readonly>
              </div>

              <div class="form-group">
                <label for="fonction" class="col-form-label"> Responsable:</label>
                <input type="text" class="form-control" id="detailFONCTION" value="'.$entreprise->responsable.'" readonly>
              </div>
              <div class="form-group">
                <label for="email" class="col-form-label">N° du respo:</label>
                <input type="text" placeholder="#" class="form-control" id="m" value="'.$entreprise->contactRespo.'" readonly>
              </div>

            </form>';
            return $output;
        }



    //Show a user 
    public function modifEntr(Request $request)
        {
            $entreprise = entreprise::find($request->idEntr);
    
            $output = '';
            $output .= '<input type="hidden" value="'.$entreprise->id.'" name="idEntr" >
              <div class="row">
                <div class="form-group col-6">
                  <label for="nom" class="col-form-label">Nomination:</label>
                  <input type="text" class="form-control"  name="nom" value="'.$entreprise->nom.'" >
                </div>
                <div class="form-group col-6">
                  <label for="prenom" class="col-form-label">Contact:</label>
                  <input type="text" class="form-control" name="contact" value="'.$entreprise->contact.'">
                </div>
              </div>

              <div class="row">
                <div class="form-group col-6">
                <label for="fonction" class="col-form-label">Adresse:</label>
                <input type="text" class="form-control" name="adresse" value="'.$entreprise->adresse.'">
                </div>
                <div class="form-group col-6">
                <label for="fonction" class="col-form-label"> Responsable:</label>
                <input type="text" class="form-control" name="responsable" value="'.$entreprise->responsable.'">
                </div>
              </div>

              <div class="row">
                <div class="form-group col-6">
                <label for="email" class="col-form-label">Email Entrprise</label>
                <input type="text" placeholder="#" class="form-control" name="email" value="'.$entreprise->email.'">
                </div>
                <div class="form-group col-6">
                <label for="fonction" class="col-form-label"> N° du responsable</label>
                <input type="text" class="form-control" name="contactRespo" value="'.$entreprise->contactRespo.'">
                </div>
              </div>
              <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-success" name="saveModif">Enregistrer modifications</button>      </div      </div>';
            return $output;
        }



    public function updtEntr(Request $request)
    {

        $info  = ['nom'=>$request->nom,
                  'contact'=>$request->contact,
                  'adresse'=>$request->adresse,
                  'email'=>$request->email,
                  'image'=>'',
                  'responsable'=>$request->responsable,
                  'contactRespo'=>$request->contactRespo
              ];


            // dd($request->idUser);
        $user = entreprise::where('id','=',$request->idEntr)->update($info);
         return redirect('/listEntr');
    }

    //Supression d'une entreprise
    public function delEntr(Request $request)
    {
        // dd($request);
        entreprise::where('id','=',$request->idUser)->delete();
        return response()->json();

    }


}
