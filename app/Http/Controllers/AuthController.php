<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\UserStatus;
use App\Models\User;
use App\Helpers\CMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    #Password Reset 
    public function passwordResetToken(Request $request)
    {
        $tokenUser = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->first();

        if ($tokenUser) {

            $data = [
                'pageTitle' => 'Password reset',
                'token' => $request->token,
            ];

            return view('back.pages.auth.password-reset', $data);
        } else {
            return redirect()->route('admin.forgot')->with('fail', 'Le lien de réinitialisation est invalide ou a expiré.');
        }

    }

    #Password Reset Traitement
    public function passwordResetHandler(Request $request)
    {
        $request->validate([
            'new_password' => ['required', 'min:5', 'required_with:new_password_config', 'same:new_password_config'],
            'new_password_config' => ['required', 'min:5']
        ], [
            'new_password.required' => 'Veuillez saisir un nouveau mot de passe.',
            'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 5 caractères.',
            'new_password.required_with' => 'Veuillez confirmer votre mot de passe.',
            'new_password.same' => 'Les mots de passe ne correspondent pas. Veuillez réessayer.',

            'new_password_config.required' => 'Veuillez confirmer votre nouveau mot de passe.',
            'new_password_config.min' => 'La confirmation doit contenir au moins 5 caractères.',
        ]);

        $tokenUser = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->first();

        #USER
        $user = User::where('email', $tokenUser->email)->first();

        $new_password = User::where('email', $user->email)->update([
            'password' => Hash::make($request->new_password)
        ]);

        #Check
        if ($new_password) {

            $data = [
                'actionLink' => route('admin.login'),
                'user' => $user,
            ];

            // #template mail
            $mail_body = view('email-template.confirm-password-reset', $data);

            $mailConfig = [
                'recipient_address' => $user->email,
                'recipeint_name' => $user->name,
                'subject' => 'Changement de mot de passe confirmé',
                'body' => $mail_body,
            ];

            if (CMail::send($mailConfig)) {
                return redirect()->route('admin.login')->with('success', 'Vous devez vous connecter.');
            } else {
                return redirect()->route('admin.forgot')->with('fail', 'Échec de l’envoi de l’email. Veuillez réessayer plus tard.');
            }

        } else {
            return redirect()->route('admin.forgot')->with('fail', 'Une erreur est survenue lors de la mise à jour du mot de passe. Veuillez réessayer.');
        }


    }

}
