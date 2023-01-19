<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function charts(Request $request)
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $values = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120];

        return response()->json([
            'months' => $months,
            'values' => $values
        ]);
    }
}
