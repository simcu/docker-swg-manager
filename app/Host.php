<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    public function acls()
    {
        return $this->hasMany(Acl::class, 'host_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'acls', 'host_id', 'role_id');
    }
}
