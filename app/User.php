<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function roles(){
        return $this->belongsToMany(Role::class,'user_role_relations','user_id','role_id');
    }
}
