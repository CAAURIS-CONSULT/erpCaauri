<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_reseau_social extends Model
{
    use HasFactory;
    protected $fillable =['reseau_socials', 'user_id', 'socialLink'];
}
