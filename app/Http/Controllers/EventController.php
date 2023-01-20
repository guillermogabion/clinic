<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    //

    public function store(Request $request)
    {
        $event = new Event();
        $requestData = $request->all();
        $data = $event->create($requestData);

        return response()->json([
            'message' => 'New Event Added',
            'event-info' => $data,
            'admin' => Auth::user()->name
        ]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        $requestData = $request->all();
        $event->update($requestData);

        return response()->json([
            'message' => 'Event Updated',
            'event-info' => $event
        ]);
    }

    public function destroy($id)
    {
        $event = Event::where('id', $id)->delete();
        return response()->json([
            'message' => 'Event Removed'
        ]);
    }

    public function index()
    {
        return Event::get();
    }
    public function pagination(Request $request)
    {
        $data = Event::query();
        if ($request->input('keyword') != "") {
            $keyword = $request->input('keyword');
            $data->where(function ($query) use ($keyword) {
                $query->where('date_reserve', 'LIKE', "%$keyword%");
            });
        }
        return $data->orderBy('date_reserve', 'asc')->with('user', 'service_rend')->paginate(10);
    }

    public function count_all()
    {
        return Event::count();
    }
    public function count_today()
    {
        return Event::whereDate('date', Carbon::today())->count();
    }

    public function get_all()
    {
        return Event::with('user', 'service_rend')->get();
    }

    public function add_appointment(Request $request)
    {
        $data = new Event();
        $data->user_id = Auth::user()->id;
        $data->service_id = $request->service;
        $data->date_reserve = $request->picker;
        $data->time = $request->time;
        $data->cost = $request->cost;
        $data->save();

        return response()->json([
            'message' => 'Successfully added a reservation request',
            'info' => $data
        ]);
    }

    public function update_status($id)
    {
        $data = Event::where('id', $id)->first();
        if ($data->status == 0) {
            $data->update(['status' => 1]);
            return "Approved";
        } else {
            $data->update(['status' => 0]);
            return "Waiting";
        }
    }
    public function get_all_history()
    {
        $data = Event::with('service_rend')->where('user_id', Auth::user()->id)->get();
        return $data;
    }
}
