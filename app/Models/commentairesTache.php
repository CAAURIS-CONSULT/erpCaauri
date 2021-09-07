<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commentairesTache extends Model
{
    use HasFactory;

    protected $fillable = ['text','user_id','taches_id','titre','niveau_evolutions_id'];
}
