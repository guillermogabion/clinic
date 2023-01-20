<?php

namespace App\Http\Controllers;

use App\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function get_services()
    {
        return Services::get();
    }

    public function search_service(Request $request)
    {
        $user = Services::query();
        if ($request->input('searchkey') != "") {
            $keyword = $request->input('searchkey');
            $user->where(function ($query) use ($keyword) {
                $query->where('id', 'LIKE', "$keyword");
            });
        }
        return $user->first(['price']);
    }
}
