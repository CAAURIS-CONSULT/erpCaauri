<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ressourcesTache extends Model
{
    use HasFactory;
    protected $fillable = ['nom','lien','taches_id','type_id'];
}
