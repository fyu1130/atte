<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Stamp extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','start_work','end_work','total_work','total_rest','stamp_date' ];

    public function user(){
        $this->belongsTo(User::class, 'user_id');
    }
    public function rests(){
        return $this->hasMany(Rest::class);
    }
}
