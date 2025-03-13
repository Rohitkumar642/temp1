<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfileModel;

class SignupController extends Controller
{
    public function signup(Request $request)
    { 
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles,email',
            'mobile' => 'required|digits:10'
        ]);

        // Check if the mobile number already exists in the database
        $existingUser = ProfileModel::where('mobile', $request->mobile)->first();

        if ($existingUser) {
            return response()->json(['status' => false, 'message' => 'You already have an account. Please login.']);
        }

        // Store new user in the database
        ProfileModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'created_at' => now()
        ]);

        return response()->json(['status' => true, 'message' => 'Signup successful!']);
    }
}
