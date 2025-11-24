<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\UserStatus;
use App\Models\User;
use App\Helpers\CMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function passwordHandler(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email']
        ], [
            'email.required' => 'Veuillez saisir votre adresse email.',
            'email.email' => 'Le format de l’adresse email est invalide.',
            'email.exists' => 'Aucun utilisateur n’est associé à cette adresse email.',
        ]);

        #Recuperateur user
        $user = User::where('email', $request->email)->first();

        #Create token
        $token = base64_encode(\Str::random(64));

        #Check Token
        $oldToken = DB::table('password_reset_tokens')->where('email', $user->email)->first();

        if ($oldToken) {
            DB::table('password_reset_tokens')
                ->where('email', $user->email)
                ->update([
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]);
        } else {
            DB::table('password_reset_tokens')
                ->where('email', $user->email)
                ->insert([
                    'email' => $user->email,
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]);
        }

        #Link_token
        $actionLink = route('admin.password_reset_token', ['token' => $token]);

        $data = [
            'actionLink' => $actionLink,
            'user' => $user,
        ];

        #Email_body
        $mail_body = view('email-template.forgot-password', $data)->render();

        $mailConfig = [
            'recipeint_address' => $user->email,
            'recipeint_name' => $user->name,
            'subject' => 'Réinitialisation de votre mot de passe',
            'body' => $mail_body,
        ];

        if (CMail::send($mailConfig)) {
            return redirect()->route('admin.forgot')->with('success', 'Un email de réinitialisation vous a été envoyé avec succès.');
        } else {
            return redirect()->route('admin.forgot')->with('fail', 'Échec de l’envoi de l’email. Veuillez réessayer plus tard.');
        }

    }

}
