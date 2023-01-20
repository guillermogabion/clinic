<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function self()
    {
        $user = User::find(auth()->user()->id);
        $token = $user->createToken('authToken')->accessToken;
        return response(['user' => $user, 'access_token' => $token]);
    }

    public function index()
    {
        return view('users');
    }
    public function login(Request $request)
    {
        // return $request;
        $login = $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();

        // return $user;
        if (!Auth::attempt($login)) {
            return response(['message' => 'login Credentials are incorrect'], 401);
        }
        $token = $user->createToken('authToken')->accessToken;
        return response(['user' => Auth::user(), 'access_token' => $token]);
    }

    public function store(Request $request)
    {
        $data = new User();

        $data->first_name = $request->first_name;
        $data->last_name = $request->last_name;
        $data->age = $request->age;
        $data->birthdate = $request->birthdate;
        $data->address = $request->address;
        $data->contact = $request->contact;
        $data->email = $request->email;
        $data->password =  Hash::make($request->password);
        $data->medical = $request->medical;
        $data->medical_record = $request->medical_record;
        $data->dental = $request->dental;
        $data->dental_record = $request->dental_record;

        $data->save();

        return response()->json([
            'message' => 'New Patient Info Added',
            'info' => $data
        ]);
    }

    public function pagination(Request $request)
    {
        $data = User::query();
        if ($request->input('keyword') != "") {
            $keyword = $request->input('keyword');

            $data->where(function ($query) use ($keyword) {
                $query->where('last_name', 'LIKE', "%$keyword%");
            });
        }
        return $data->where('user_type', 0)->orderBy('last_name', 'asc')->paginate(10);
    }

    public function get_record($id)
    {
        $data = User::where('id', $id)->with('service.service_rend')->first();
        return $data;
    }
}
