<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    //

    public function reserve()
    {
        return $this->hasMany(Event::class, 'service_id');
    }
}
