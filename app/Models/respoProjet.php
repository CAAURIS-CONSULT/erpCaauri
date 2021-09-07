<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class respoProjet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','projets_id'];
}
