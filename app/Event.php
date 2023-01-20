<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = [
        'name',
        'color',
        'start',
        'end',
        'status'
    ];

    public function record_event()
    {
        return $this->hasMany(Record::class);
    }

    public function service_rend()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function one_array()
    {
        return $this->hasMany(Services::class);
    }
}
