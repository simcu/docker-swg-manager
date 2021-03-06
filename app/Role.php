<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role_relations', 'role_id', 'user_id');
    }

    public function acls()
    {
        return $this->hasMany(Acl::class, 'role_id', 'id');
    }

    public function hosts()
    {
        return $this->belongsToMany(Host::class, 'acls', 'role_id', 'host_id');
    }
}
