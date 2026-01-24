<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    
    protected $fillable = ['user_id','username','role'];

    public function user() { return $this->belongsTo(User::class); }
}
