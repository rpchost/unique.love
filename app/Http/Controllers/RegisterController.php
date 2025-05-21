<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Validate and create user (simplified)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Send welcome email
        Mail::to($user->email)->send(new WelcomeEmail($user));

        return redirect('/home')->with('success', 'Registration successful!');
    }
}
