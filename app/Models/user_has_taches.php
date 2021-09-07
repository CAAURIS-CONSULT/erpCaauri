<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_has_taches extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','taches_id','attributed_at','read_at' ,'last_modif'];
}
