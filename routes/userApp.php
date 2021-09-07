<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\EntrepriseController;
use App\Http\Controllers\User\ProjetController;
use App\Http\Controllers\User\TaskController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| User not Admin  Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*--------------------------
  GESTION DES TACHES 
----------------------------*/
  /*
   *******************
    * Cas pratique*
    ---------------
     Pour la gestion des actions 
     liées aux utilisateur 
   ********************
  */
Route::get('userListTask', [TaskController::class, 'userListTask'])->name('userListTask');
Route::get('/showAgenda', [UserController::class, 'showAgenda'])->name('showAgenda');

Route::get('/showExc', [TaskController::class, 'showExc'])->name('showExc');

//Montre la tache particuliere d-un user
Route::get('/showUserTask', [TaskController::class, 'showUserTask'])->name('showUserTask');

Route::post('/storeTaskComment', [TaskController::class, 'storeTaskComment'])->name('storeTaskComment');

Route::get('/recupComment', [TaskController::class, 'recupComment'])->name('recupComment');


//Route d'affichage du profilUser
Route::get('/profile',[UserController::class, 'profile'])->name('profile');

//Modif Profil User
Route::post('/settingUser',[UserController::class, 'settingUser'])->name('settingUser');



