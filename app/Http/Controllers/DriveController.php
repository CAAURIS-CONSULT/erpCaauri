<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\Models\drive;


class DriveController extends Controller
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


    //Show upload file Form
    public function addFile()
    {
        unset($_SESSION['fileUpload']);
        return view('pages.drive.addFile');
    }



    //Save a file Uploaded
    public function saveFile(Request $request)
    {
        //Get file
        if (!empty($request->file('file'))) 
        {
            //Save file in temprary directory
                $myFile = $request->file('file');
                $lien = $this->folderLink;
                // dossier de stockage
                $path = $myFile->store('drive','public');
                // Chemin d'accès de l'image 
                 $src = $lien.$path;
                 //Unique file name
                    $filename = $myFile->getClientOriginalName();
                    $filename  = createLibele($filename,100);

            //Save path in session
                 $_SESSION['fileUpload'][] = ['path'=>$src, 'filename'=>$filename];

        }
        return response()->json([ 'success' => 'fihier']);
    }

    //Confirm Saved File
    public function confirmSavedFile()
    {

        $lien = $this->folderLink; // Folder registered link
         $compter = 0;
        //Save all path with name in DB
        foreach($_SESSION['fileUpload'] as $line)
        {
            //Enregistrement en BD
            drive::create(['lienFichier' =>$line['path'],
                            'nomFichier'=>$line['filename'],
                            'statut' => 1]);


            $compter++; //Increment compteur
        }
        unset($_SESSION['fileUpload']);
        return response()->json();
    }

    //Confirm Saved File
    public function resetSavedFile()
    {
        $lien = $this->folderLink; // Folder registered link
        //delete From session
        foreach($_SESSION['fileUpload'] as $line)
        {
                //Supression du fichier 
                $newpaths[] = str_replace($lien,'public/', $line['path']);
            //Increment compteur

        }


                Storage::delete($newpaths);
                unset($_SESSION['fileUpload']);
        //Delete from temporary directory
        return response()->json();
    }


    //Delete img on uploded
    public function delUploadImg(Request $request)
    {
        $lien = $this->folderLink; // Folder registered link
        $name = $request->filename;
        $filename  = createLibele($name,100);
        $compter = 0;

        //delete From session
        foreach($_SESSION['fileUpload'] as $line)
        {
            if($line['filename'] == $filename)
            {
                //Supression du fichier 
                $newpath = str_replace($lien,'public/', $line['path']);
                Storage::delete($newpath);
                unset($_SESSION['fileUpload'][$compter]);
            }
            //Increment compteur
            $compter++;
        }
        //Delete from temporary directory
        return response()->json();
    }

    public function showFiles(Request $request)
    {
        $files = drive::orderBy('id','desc')->paginate('100');
        return view('pages.drive.showFile')->with('files',$files);
    }
    
    public function showSauv(Request $request)
    {

    }
       
}
