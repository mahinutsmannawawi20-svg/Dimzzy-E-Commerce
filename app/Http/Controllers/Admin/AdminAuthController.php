<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session([
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'admin_email' => $admin->email,
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        session()->forget(['admin_id', 'admin_name', 'admin_email']);
        return redirect()->route('admin.login')->with('success', 'Logged out successfully');
    }
}
