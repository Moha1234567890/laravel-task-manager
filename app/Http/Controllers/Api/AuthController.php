<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    

    ///register user 


    public function register(Request $request) {

         // Validate incoming request
         $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


         // Generate a Sanctum token
         $user['token'] = $user->createToken('auth_token')->plainTextToken;

         // Return response
         return response()->json([
             'message' => 'User registered successfully',
             'user' => $user,
             //'token' => $token,
             'status' => true
         ]);
    }


    

    //login user 
    public function login(Request $request) {
        // Validate request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Find user by email
        $user = User::where('email', $request->email)->first();
    
        // Check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => 401
            ]);
        }
    
        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ]);
            
    }


    //logout user 
    public function logout(Request $request) {

        // Revoke the token
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);

    }


}
