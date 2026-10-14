<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    // Show login page
    public function showLogin() {
        return view('welcome'); // your login Blade file
    }

    // Handle login
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->has('remember');

        if (Auth::guard('admin')->attempt($request->only('email','password'), $remember)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard'); // after login, redirect to dashboard
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Show signup page
    public function showRegister() {
        return view('register'); // your signup Blade file
    }

    // Handle signup
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Admin::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
        ]);

        // Redirect to login page after signup
        return redirect()->route('admin.login')
            ->with('success', 'Account created successfully. Please login.');
    }

    // Logout
    public function logout(Request $request) {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }


//    =========================================setttings page
    public function settings()
    {
        $admin = Auth::guard('admin')->user();

        return view('quotes.setting',compact('admin'));
    }

    public function updateProfile(Request $request)
    {

        $admin = Auth::guard('admin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,'.$admin->id,
            'quote_emails' => 'nullable|string|max:5000',
            'password' => 'nullable|min:6|confirmed'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'quote_emails' => $request->quote_emails,
        ];

        if($request->password){
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return back()->with('success','Profile updated successfully');

    }
}
