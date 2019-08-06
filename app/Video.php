<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    #Relación one to many

    public function comments(){
    	return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }

    #Relación many to one
    public function user() {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
