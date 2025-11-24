<?php

namespace App\Http\Controllers;

use App\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $fielType = filter_var($request->input('login_id'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($fielType == 'email') {

            $request->validate([
                'login_id' => ['required', 'email', 'exists:users,email'],
                'password' => ['required', 'min:5'],
            ], [
                'login_id.required' => 'Veuillez saisir votre adresse email.',
                'login_id.email' => 'Le format de l\'adresse email est invalide.',
                'login_id.exists' => 'Aucun compte n’est associé à cette adresse email.',

                'password.required' => 'Veuillez entrer votre mot de passe.',
                'password.min' => 'Le mot de passe doit contenir au moins 5 caractères.',
            ]);

        } else {

            $request->validate([
                'login_id' => ['required', 'exists:users,username'],
                'password' => ['required', 'min:5'],
            ], [
                'login_id.required' => 'Veuillez saisir votre nom d’utilisateur.',
                'login_id.exists' => 'Aucun compte n’est associé à ce nom d’utilisateur.',
                'password.required' => 'Veuillez entrer votre mot de passe.',
                'password.min' => 'Le mot de passe doit contenir au moins 5 caractères.',
            ]);

        }

        $credentie = [
            $fielType => $request->login_id,
            'password' => $request->password,
        ];

        #Authentificate User
        if (Auth::attempt($credentie)) {

            # Check Status
            if (auth()->user()->status == UserStatus::Pending) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->with('info', 'Votre compte est en cours de validation. Veuillez patienter.');
            }

            if (auth()->user()->status == UserStatus::Inactive) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->with('fail', 'Votre compte est désactivé. Veuillez contacter l’administrateur.');
            }

            return redirect()->route('admin.dashboard');


        } else {
            return redirect()->route('admin.login')->withInput()->with('fail', 'Le mot de passe est incorrect');
        }

    }

    public function forgot_form(Request $request)
    {
        $data = [
            'pageTitle' => 'Forgot',
        ];

        return view('back.pages.auth.forgot', $data);
    }
}
