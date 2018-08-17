<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id','title','task','urgency','importance','status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    
    
}
