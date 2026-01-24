<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends Model
{
    

    protected $table = 'notifications'; // Table name
    protected $primaryKey = 'id'; // Default primary key

    protected $fillable = [
        'id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
        'created_at',
        'updated_at'
    ];

    // Relationship to the notifiable (Customer/User)
    public function notifiable()
    {
        return $this->morphTo();
    }
    
}
