<?php

namespace App\Http\Controllers;

use App\Jobs\ServerReport;
use App\Mail\WelecomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    // show login page
    public function show()
    {
        return view('auth.login');
    }

    //login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->admin) {
                return redirect()->route('admin.center');
            } else {
                return redirect()->route('home');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    //logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    //sign up
    public function signUp(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $users = $user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Mail::to($users->email)->send(new WelecomeMail($users));

        if (isset($users)) {
            $job = new ServerReport($users);
            dispatch($job->delay(5));//delay 5 second
        };

        return redirect()->route('login')->with('status', '帳戶註冊成功 ! ');
    }
}
