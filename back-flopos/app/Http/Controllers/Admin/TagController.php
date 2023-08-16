<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->has('search'), function($q)use($request){
            $q->where('name', 'like', '%'.$request->search.'%')->orWhere('id', (int)$request->search);
        })->latest()->get(['id', 'email', 'email_verified_at', 'phone', 'address', 'zipcode', 'created_at']);
        return response()->json([$users, 200]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json('User deleted sucessfullfy', 200);
    }
}
