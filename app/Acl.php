<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acl extends Model
{
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function host()
    {
        return $this->belongsTo(Host::class, 'host_id', 'id');
    }
}
