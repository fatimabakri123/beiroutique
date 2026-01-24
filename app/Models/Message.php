<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Message extends Model
{
    protected $fillable = [
        'conversation_id','sender_id','message','type','file_path','is_seen'
    ];

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
