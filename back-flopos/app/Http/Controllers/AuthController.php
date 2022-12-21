<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Str;
// use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|min:3|max:60',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|max:30'
        ],
        [
            'username.required' => ':attribute should not be null',
            'email.required' => ':attribute should not be null',
            'password.required' => ':attribute should not be null'
        ]);

        User::create([
            'username' => ucwords(strtolower($request->username)),
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        
        // Role::create([
        //     'user_id' => $user->id,
        //     'name' => 'User'
        // ]);

        // event(new Registered($user));

        return response()->json('Account Registered Successfully', 201);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ], 
        [
            'email.required' => ':attribute column should not be null',
            'password.required' => ':attribute column should not be null',
        ]);


        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'The provided credentials are incorrect.',
            ]);
            return;
        }
        
        // if (!$user->hasVerifiedEmail()) {
        //     throw ValidationException::withMessages([
        //         'verify' => 'Email not verificated.',
        //     ])->status(403);
        // }

        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function forgot(Request $request){
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
     
        return response()->json($status, 201);
    }

    public function logout(Request $request){
        return $request->user()->currentAccessToken()->delete();
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        if (Hash::check($request->current_password, Auth::user()->password)) {
            $user = User::find(Auth::user()->id);
            $user->update(['password' => Hash::make($request->password)]);
            return response()->json('Your password has been updated', 201);
        }

        throw ValidationException::withMessages([
            'current_password' => 'Your current password does not match with our record'
        ]);
    }
}