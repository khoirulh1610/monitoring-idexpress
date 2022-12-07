<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('id', $request->id)->first();
            return $users;
        }
        $users = User::all();
        return view('users.index', compact('users'));
    }
    public function store(Request $request)
    {
        if ($request->id_user) {
            $user           = User::where('id', $request->id_user)->first();
            if ($request->password) {
                $user->password    = Hash::make($request->password);
            } else {
                $user->password    = $user->password;
            }
            $user->email        = $request->email_user;
            $user->name         = $request->nama_user;
            $user->save();
        } else {
            $user               = new User();
            $user->password     = Hash::make($request->password);
            $user->email        = $request->email_user;
            $user->name         = $request->nama_user;
            $user->save();
        }

        return redirect('setting/user');
    }

    public function remove(Request $request)
    {
        $user =  User::where('id', $request->id)->delete();
        return redirect('setting/user');
    }
}
