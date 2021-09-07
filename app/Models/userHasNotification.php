<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userHasNotification extends Model
{
    use HasFactory;
    protected $fillable = ['read_at','user_id','notif_id'];
}
