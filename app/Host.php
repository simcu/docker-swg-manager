<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    public function acls()
    {
        return $this->hasMany(Acl::class, 'id', 'host_id');
    }
}
