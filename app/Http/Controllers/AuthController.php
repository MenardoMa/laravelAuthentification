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

        return $data;
    }

    public function forgot_form(Request $request)
    {
        $data = [
            'pageTitle' => 'Forgot',
        ];

        return $data;
    }
}
