<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data = [
            'pageTitle' => 'Dashboard',
        ];

        return view('back.pages.dashboard', $data);
    }

    public function logoutHandler(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('fail', 'Vous etes deconnecter');
    }

    public function profilHandler(Request $request)
    {
        $data = [
            'pageTitle' => 'Profil',
        ];

        return view('back.pages.profil', $data);
    }

}
