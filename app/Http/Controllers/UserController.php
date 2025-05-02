<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Store new user
     */
    public function store(StoreUserRequest $request)
    {
        //validate the form data
        //validate the form data
        if($request->validated()) {
            $data = $request->validated();
            //hash the password
            $data['password'] = Hash::make($request->password);
            //create the user
            User::create($data);
            //return the response
            return response()->json([
                'message' => 'Account created successfully'
            ]);
        }
    }

    /**
     * Log in users
     */
    public function auth(AuthUserRequest $request)
    {
        //validate the form data
        if($request->validated()) {
            //get the user by email
            $user = User::whereEmail($request->email)->first();
            if(!$user || !Hash::check($request->password, $user->password)) {
                //return an error
                throw ValidationException::withMessages([
                    'email' => 'This credentials do not match any of our records'
                ]);
            }else {
                return UserResource::make($user)->additional([
                    'access_token' => $user->createToken('new_user')->plainTextToken,
                    'message' => 'Logged in successfully'
                ]);
            }
        }
    }

    /**
     * Logout users
     */
    public function logout(Request $request)
    {
        //delete the current access token
        $request->user()->currentAccessToken()->delete();
        //return the response
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
