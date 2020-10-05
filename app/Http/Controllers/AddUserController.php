<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user
           ->roles()
           ->attach(Role::where('name', 'user')->first());

        return redirect('/')->with('message', "Tambah user $request->name success.");
    }

    public function index(Request $request){
        $request->user()->authorizeRoles(['admin']);
    	return view('/add-user');
    }
}
