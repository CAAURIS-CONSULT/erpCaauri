<?php

use App\Models\entreprise;


//get a entreprise by ID
if(!function_exists('getEntreprise'))
{
	function getEntreprise($idEntr)
	{
         $user = entreprise::find($idEntr);
			return $user;	
	}
}

//get a entreprise by ID
if(!function_exists('allEntre'))
{
	function allEntre()
	{
         $entr = entreprise::all();
			return $entr;	
	}
}


//get a entreprise by ID
if(!function_exists('getAllEntr'))
{
	function getAllEntr()
	{
         $elets = entreprise::all();	

           return $elets;
	}
}

?>