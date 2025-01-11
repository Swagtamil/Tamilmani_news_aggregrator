<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $fillable = ['user_id', 'preference_key', 'preference_value']; 

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
