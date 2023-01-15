<?php

namespace App\Http\Controllers;

use App\Services;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    //

    public function get_all()
    {
        return Services::withCount('reserve')->get();
    }

    public function get_reserve()
    {
        return Services::withCount('reserve')->get(['reserve_count']);

        // return Services::withCount('reserve', function ($q) {
        //     $q->count();
        // })->get();
    }
}
