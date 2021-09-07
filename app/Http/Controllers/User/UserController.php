<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\user_has_role;
use App\Models\projet;
use App\Models\respoProjet;
use App\Models\role;
use App\Models\user_reseau_social;
use DB;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



//IMPORTANT INFORMATIONS
//  This Controller is for not admin user request
//  getUser() ==> Voir helper.php 


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
   
    }

    public function showAgenda()
    {
        // Returun la page de lagenda 
        return view('pages.userDash.myAgenda');


    }

    public function profile(Request $request)
    {
        //get the user by id in request
        $user = getUser($request->id);
        $socials = DB::table('user_reseau_socials')
        ->join('reseau_socials','reseau_socials.id','=','user_reseau_socials.reseau_socials')
        ->where('user_reseau_socials.user_id','=',$request->id)
        ->select('user_reseau_socials.*','reseau_socials.*')
        ->get();

        return view('profile')->with('userInfo',$user)->with('socials',$socials);
    }

    public function settingUser(Request $request)
     {
    
        if($request->password !="")
        {
            $info['password'] = $request->password;         
        }

        if(isset($request->biographie))
        {
            $info['biographie'] = $request->biographie;         
        }
        $info['telephone'] = $request->telephone;
        $info['dateNaissance'] = $request->dateNaissance;
        // dd($info);
        //Save Modif Of Usser
        $user =User::find($request->user);
        $user->update($info);

        //Enregistrement des social link
            $facebook =$request->facebook ;
            $valeur[0] = ['reseau_socials'=>1 , 'user_id' =>$request->user , 'socialLink' =>$facebook];
            user_reseau_social::updateOrCreate(
                ['reseau_socials'=>1 , 'user_id' =>$request->user],$valeur[0]);

            $github =$request->github ;
            $valeur[1]= ['reseau_socials'=>3 , 'user_id' =>$request->user , 'socialLink' =>$github];
            user_reseau_social::updateOrCreate(['reseau_socials'=>3 , 'user_id' =>$request->user],$valeur[1]);

            $instagram =$request->instagram ;
            $valeur[2]= ['reseau_socials'=>4 ,'user_id'=>$request->user ,'socialLink' =>$instagram];
            user_reseau_social::updateOrCreate(['reseau_socials'=>4 ,'user_id'=>$request->user],$valeur[2]);

            $linkedIn =$request->linkedIn;
            $valeur[3]= ['reseau_socials'=>2 ,'user_id' =>$request->user ,'socialLink' =>$linkedIn];
            user_reseau_social::updateOrCreate(['reseau_socials'=>2 ,'user_id' =>$request->user],$valeur[3]);
        return redirect()->route('profile',['id' =>$request->user]);

     }
}
