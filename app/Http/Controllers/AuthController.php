<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login_form(Request $request)
    {
        $data = [
            'pageTitle' => 'Login',
        ];

        return view('back.pages.auth.login', $data);
    }

    public function loginHandler(Request $request)
    {
        dd($request->all());
    }

    public function forgot_form(Request $request)
    {
        $data = [
            'pageTitle' => 'Forgot',
        ];

        return view('back.pages.auth.forgot', $data);
    }
}
