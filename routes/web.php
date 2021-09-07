<?php


use App\Http\Controllers\UserController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\TaskController; 
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DriveController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});


Route::get('/app', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';




/*--------------------------
  GESTION DES UTILISATEURS
----------------------------*/
  /*
   *******************
    * Cas pratique*
    ---------------
     Pour la gestion des actions 
     liées aux utilisateur 
   ********************
  */
Route::get('/addUser', [UserController::class, 'addUser'])->name('addUser');
Route::post('/insertUser', [UserController::class, 'insertUser'])->name('insertUser');
Route::get('/showUser', [UserController::class, 'showUser'])->name('showUser');
Route::get('/modifUser', [UserController::class, 'modifUser'])->name('modifUser');
Route::post('updtUser',[UserController::class, 'updtUser'])->name('updtUser'); 
Route::get('delUser',[UserController::class, 'delUser'])->name('delUser'); 
Route::get('/listeRole', [UserController::class, 'listeRole'])->name('listeRole');
Route::get('/listUser', [UserController::class, 'listUser'])->name('listUser');
Route::get('/respoProjet', [UserController::class, 'respoProjet'])->name('respoProjet');

/*--------------------------
  GESTION DES ENTREPRISES
----------------------------*/
  /*
   *******************
    * Cas pratique*
    ---------------
     Pour la gestion des 
     des operation lie
     aux entreprises
   ********************
  */
Route::get('/addEntr', [EntrepriseController::class, 'addEntr'])->name('addEntr');
Route::get('/listEntr', [EntrepriseController::class, 'listEntr'])->name('listEntr');
Route::post('/insertEntr', [EntrepriseController::class, 'insertEntr'])->name('insertEntr');
Route::get('/showEntr', [EntrepriseController::class, 'showEntr'])->name('showEntr');
Route::post('updtEntr',[EntrepriseController::class, 'updtEntr'])->name('updtEntr'); 
Route::get('/modifEntr', [EntrepriseController::class, 'modifEntr'])->name('modifEntr');
Route::get('delEntr',[EntrepriseController::class, 'delEntr'])->name('delEntr');



/*--------------------------
  GESTION DES PROJETS
----------------------------*/
  /*
   *******************
    * Cas pratique*
    ---------------
     Pour la gestion des 
     des projets lie
     aux entreprises
   ********************
  */

Route::get('/addProj', [ProjetController::class, 'addProj'])->name('addProj');
Route::post('/insertPrj', [ProjetController::class, 'insertPrj'])->name('insertPrj');
Route::get('/getProjet', [ProjetController::class, 'getProjet'])->name('getProjet');
Route::get('/listProj', [ProjetController::class, 'listProj'])->name('listProj');
Route::get('/modifProj', [ProjetController::class, 'modifProj'])->name('modifProj');
Route::get('/modifPrj', [ProjetController::class, 'modifPrj'])->name('modifPrj');
Route::post('updtPrj',[ProjetController::class, 'updtPrj'])->name('updtPrj'); 
Route::get('delPrj',[ProjetController::class, 'delPrj'])->name('delPrj');

/*--------------------------
  GESTION DES TACHES
----------------------------*/
  /*
   *******************
    * Cas pratique*
    ---------------
     Pour la gestion des 
     des projets lie
     aux entreprises
   ********************
  */
Route::get('/addTask', [TaskController::class, 'addTask'])->name('addTask');
Route::post('/insertTask', [TaskController::class, 'insertTask'])->name('insertTask');
Route::get('/listTask', [TaskController::class, 'listTask'])->name('listTask');
Route::get('/doingTask', [TaskController::class, 'doingTask'])->name('doingTask');
Route::get('/doneTask', [TaskController::class, 'doneTask'])->name('doneTask');

Route::get('/modifTask', [TaskController::class, 'modifTask'])->name('modifTask');
Route::post('updtTask',[TaskController::class, 'updtTask'])->name('updtTask'); 
Route::get('delTask',[TaskController::class, 'delTask'])->name('delTask');

//Montre la tache particuliere d-un user
Route::get('/showTask', [TaskController::class, 'showTask'])->name('showTask');

//
Route::post('/storeTaskComment', [TaskController::class, 'storeTaskComment'])->name('storeTaskComment');

//Ajout d'executant
Route::get('/addExec', [TaskController::class, 'addExec'])->name('addExec');

//Show executant 
Route::get('/showExc', [TaskController::class, 'showExc'])->name('showExc');
Route::get('/delExc', [TaskController::class, 'delExc'])->name('delExc');


/*--------------------------
  GESTION DES NOTIFICATIONS
----------------------------*/
  /*
   *******************
    * Cas pratique*
    ---------------
     Pour la gestion des 
     des projets lie
     aux entreprises
   ********************
  */

// notifView
Route::get('/notifView', [NotificationController::class, 'notifView'])->name('notifView');

//Not readed Notification
Route::get('/notReadedNotif', [NotificationController::class, 'notReadedNotif'])->name('notReadedNotif');

//Les notifiations deja lue par le user 
Route::get('/readedNotif', [NotificationController::class,'readedNotif'])->name('readedNotif');

//Recuperation des notifiactions de user
Route::get('/recupNotif', [NotificationController::class, 'recupNotif'])->name('recupNotif');

//Suprimer des notifcation
Route::get('/delNotif', [NotificationController::class, 'delNotif'])->name('delNotif');

// notifAdd

/*--------------------------
  GESTION DU DRIVE
----------------------------*/
  /*
   *******************
    * Route de drive*
    ---------------
   ********************
  */
//Ajout de fichiers au drive
Route::get('/addFile', [DriveController::class, 'addFile'])->name('addFile');

//Upload temporaire de fihier au drive
Route::post('/saveFile', [DriveController::class, 'saveFile'])->name('saveFile');

//Suression de fichier uploader temporairement
Route::post('/delUploadImg', [DriveController::class, 'delUploadImg'])->name('delUploadImg');

//Montre les fichier en ligne
Route::get('/showFiles', [DriveController::class, 'showFiles'])->name('showFiles');

//Montre les fichier sauvegarder
Route::get('/showSauv', [DriveController::class, 'showSauv'])->name('showSauv');

//Enregistre fichier sauvegarder
Route::post('/confirmSavedFile', [DriveController::class, 'confirmSavedFile'])->name('confirmSavedFile');

//suprime les fichier sauvegarder
Route::post('/resetSavedFile', [DriveController::class, 'resetSavedFile'])->name('resetSavedFile');


