<?php

use App\Models\role;
use App\Models\user_has_role;
use App\Models\User;
use App\Models\entreprise;
use App\Models\niveauEvolution;
use App\Models\projet;
use App\Models\setting;

session_start();


//LES HELPERS UTILSER

include('entrepriseHelper.php');
include('taches.php');



if(!function_exists('formatPriorite'))
{
	function formatPriorite($priorite)
	{
		switch ($priorite) {
			case 1:
				$output = 'badge badge-danger';
				break;
			case 2:
				$output = 'badge badge-warning';
				break;
			case 3:
				$output = 'badge badge-success';
				break;
			
			default:
				$output = 'badge badge-success';
				break;
		}

		return $output;
	}
}



//Donne la valeur $default a une variable  si elle est  vide
if(!function_exists('getRole'))
{
	function getRole($idUser)
	{
         $role = DB::table('roles')
            ->join('user_has_roles','user_has_roles.roles_id','=','roles.id')
            ->select('user_has_roles.*', 'roles.*')
            ->where('user_has_roles.user_id','=',$idUser)
            ->first();
		return $role;	
	}
}


//Donne la valeur $default a une variable  si elle est  vide
if(!function_exists('getARole'))
{
	function getARole($idRole)
	{
         $role = role::find($idRole);
		return $role;	
	}
}


//get a user by ID
if(!function_exists('getUser'))
{
	function getUser($idUser)
	{
         $user = User::find($idUser);
			return $user;	
	}
}

if (!function_exists('getSignatureNotif')) 
{
	function getSignatureNotif()
	{
		$sign = setting::where('cle','=', 'signatureSystem')->first();
		return $sign;
	}
	
}


    //Creation de libelle 
        if(!function_exists('createLibele'))
        {
            function createLibele($chaine,$taille)
            {
            	$chaine = trim($chaine);
                $taille = (strlen($chaine) > $taille) ?  $taille : strlen($chaine);
                $msg=substr($chaine,0,$taille); 
               // Filtrer le messages
                 $nvMsg = str_replace('à','a', $msg);
                 $nvMsg = str_replace('á','a', $nvMsg);
                 $nvMsg = str_replace('â','a', $nvMsg);
                 $nvMsg = str_replace('ç','c', $nvMsg);
                 $nvMsg = str_replace('è','e', $nvMsg);
                 $nvMsg = str_replace('é','e', $nvMsg);
                 $nvMsg = str_replace('ê','e', $nvMsg);
                 $nvMsg = str_replace('ë','e', $nvMsg);
                 $nvMsg = str_replace('ù','u', $nvMsg);
                 $nvMsg = str_replace('ù','u', $nvMsg);
                 $nvMsg = str_replace('ü','u', $nvMsg);
                 $nvMsg = str_replace('û','u', $nvMsg);
                 $nvMsg = str_replace('ô','o', $nvMsg);
                 $nvMsg = str_replace('î','i', $nvMsg);
                 $nvMsg = str_replace(' ','_', $nvMsg);

               return strtolower($nvMsg);

            }
        }


    //Recup extension File 
        if(!function_exists('fileExtension'))
        {
            function fileExtension($link)
            {

               $tab = explode('.', $link);

               return strtolower($tab[1]);

            }
        }




//get a entreprise by ID
if(!function_exists('getRespoProjet'))
{
	function getRespoProjet($idProj)
	{
         $respos = DB::table('respo_projets')
            ->join('users','users.id','=','respo_projets.user_id')
            ->join('projets','projets.id','=','respo_projets.projets_id')
            ->where('projets.id','=',$idProj)
            ->select('projets.*', 'users.*','users.id as user_id')
            ->get();	

           return $respos->first();
	}
}


//get a entreprise by ID
if(!function_exists('getAllUser'))
{
	function getAllUser()
	{
         $elets = User::all();	

           return $elets;
	}
}

//get a entreprise by ID
if(!function_exists('getAllNiveau'))
{
	function getAllNiveau()
	{
         $elets = niveauEvolution::all();	

           return $elets;
	}
}



//get all projet by ID
if(!function_exists('getAllPrj'))
{
	function getAllPrj()
	{
         $elets = projet::all();	

           return $elets;
	}
}


//get all projet by ID
if(!function_exists('getPrj'))
{
	function getPrj($idPrj)
	{
         $elets = projet::find($idPrj);	

           return $elets;
	}
}

//Format quantite
	if(!function_exists('formatQte'))
	{
		function formatQte($qte)
		{
			if (is_int($qte) && $qte <10) 
			{
				return sprintf("%02d", $qte);
			}
			else
			{
				$qteF = number_format( $qte,0,',',' .');
				return $qteF;	
			}

		}
	}

//Get niveau evolution
	if(!function_exists('getLevelExc'))
	{
		function getLevelExc($id)
		{
			$level = niveauEvolution::find($id);
			return $level;

		}
	}


//Format my date
	if(!function_exists('formatDate'))
	{
		function formatDate($date)
		{
			return date("d/m/Y",strtotime($date));
		}
	}	

//Formater le niveau evolution
	if(!function_exists('formatLevel'))
	{
		function formatLevel($level)
		{
			switch ($level) {
				case 1:
						$color= 'btn-primary';
						$icone = 'fas fa-spinner';
						$text = 'En cours';
						$texColor = '#6777ef';
					break;
				case 2:
						$color= 'btn-warning';
						$icone = 'fas fa-check-double';
						$text = 'Terminé';
						$texColor = '#ffa426';

					break;
				case 3:
						$color= 'btn-success';
						$icone = 'fas fa-star';
						$text = 'Validé';
						$texColor = '#54ca68';

					break;
				case 4:
						$color= 'btn-info';
						$icone = 'fas fa-spinner';
						$text = 'Non attribué';
						$texColor = '#3abaf4';

					break;

				case 5:
						$color= 'btn-secondary text-dark';
						$icone = 'fas fa-exclamation-triangle';
						$text = 'Suspendue';
						$texColor = '#aa6460';

					break;

				case 6:
						$color= 'btn-danger';
						$icone = 'fas fa-calendar-times';
						$text = 'Retardé';
						$texColor = '#fc544b';

					break;
				
				default:
						$color= 'btn-primary';
						$icone = 'fas fa-spinner';
						$text = 'En cours';
						$texColor = '#00bcd4';

					break;
			}

			$tab = ['color' =>$color,
						'icone' =>$icone,
						'text' =>$text,
						'textColor'=>$texColor,
							];
			return $tab;

		}
	}



//Get user role 
if(!function_exists('getUserRole'))
{
	function getUserRole($idUser)
	{
		$role = DB::table('user_has_roles')
            ->join('roles', 'roles.id', '=', 'user_has_roles.roles_id')
            ->select('roles.*','roles.id as roleId')
            ->where('user_has_roles.user_id','=', $idUser)
            ->first();

           return $role;
	}
}


//Verifiy connecte user role 
if(!function_exists('isSuperAdmin'))
{
	function isSuperAdmin($idUser)
	{
		$role = DB::table('user_has_roles')
            ->join('roles', 'roles.id', '=', 'user_has_roles.roles_id')
            ->select('roles.*')
            ->where('user_has_roles.user_id','=', Auth::id())
            ->where('user_has_roles.roles_id','=',3) // Role 3 => superAdmin
            ->first();

         if(!empty($role))
         {
         	return 1;
         }
					return 0;

	}
}

//Function to get the matricule of last registered
//Return mat of new user to be saved
if(!function_exists('getNewMat'))
{
	function getNewMat()
	{
		$newMat = User::latest()->first(['id']);
		if ($newMat->id <10) 
		{
			$newMat = "CA000".($newMat->id+1);
		}
		else
		{
			if ($newMat->id <100) 
			{
				$newMat = "CA00".($newMat->id+1);
			}
			else
			{
				$newMat = "CA0".($newMat->id+1);	
			}
		}

		return $newMat;
	}




}

	//Get a social media
if(!function_exists('getUserSocial'))
{
	function getUserSocial($idSocial,$idUser)
	{
        $socials = DB::table('user_reseau_socials')
        ->join('reseau_socials','reseau_socials.id','=','user_reseau_socials.reseau_socials')
        ->where('reseau_socials.id','=',$idSocial)
        ->where('user_reseau_socials.user_id','=',$idUser)
        ->select('user_reseau_socials.*','reseau_socials.*')
        ->get();
        return $socials;		
	}
}


if (!function_exists('collectionEmpty')) 
{
	function collectionEmpty($myCollection)
	{
		$myCollection->whenEmpty(function($myCollection)
		{
			$myCollection->put('socialLink','');

		});

		return $myCollection;

	}
}


if (!function_exists('objectStat')) 
{
	function objectStat($myObject,$prop)
	{
		 $val = empty($myObject) ? '': $myObject->$prop;
		 // echo $val;
		 return $val;

	}
}












?>