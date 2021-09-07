<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class taches extends Model
{
    use HasFactory;
    protected $fillable = ['nomTache', 'description', 'delaisExec',  'niveau_evolutions_id',    'entreprises_id',  'projets_id'];
}
