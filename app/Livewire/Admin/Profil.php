<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Helpers\CMail;
use App\Models\SocialLinks;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Profil extends Component
{

    public $tab = null;

    protected $tab_default = 'update_personnal';

    protected $queryString = ['tab' => ['keep' => true]];

    public function selectTab($tab)
    {
        $this->tab = $tab;
    }

    public $name, $username, $email, $bio;
    public $current_password, $new_password, $new_password_config;
    public $facebook, $github, $linkedin, $twitter, $instagram, $youtube;

    public function mount()
    {

        $this->tab = Request('tab') ? Request('tab') : $this->tab_default;
        $user = User::with('social_links')->findOrFail(auth()->user()->id);

        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->bio = $user->bio;

        if ($user->social_links()) {

            $this->facebook = $user->social_links->facebook;
            $this->github = $user->social_links->github;
            $this->linkedin = $user->social_links->linkedin;
            $this->twitter = $user->social_links->twitter;
            $this->instagram = $user->social_links->instagram;
            $this->youtube = $user->social_links->youtube;
        }

    }

    public function updatePersonnalDetail()
    {
        $user = User::findOrFail(auth()->user()->id);

        $this->validate([
            'name' => ['required', 'min:3'],
            'username' => [
                'required',
                'min:3',
                'alpha_num',
                'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9_-]+$/',
                'unique:users,username,' . $user->id
            ],
        ], [
            'name.required' => 'Veuillez saisir votre nom.',
            'name.min' => 'Le nom doit contenir au moins 3 caractères.',

            'username.required' => 'Veuillez saisir un nom d’utilisateur.',
            'username.unique' => 'Ce nom d’utilisateur est déjà utilisé. Veuillez en choisir un autre.',
            'username.min' => 'Le nom d’utilisateur doit contenir au moins 3 caractères.',
            'username.alpha_num' => 'Le nom d’utilisateur ne peut contenir que des lettres et des chiffres.',
            'username.regex' => 'Le nom d’utilisateur doit contenir au moins une lettre.',
        ]);

        #UPDATE

        $user->name = $this->name;
        $user->username = $this->username;
        $user->bio = $this->bio;

        $updateUserData = $user->save();

        sleep(0.6);

        if ($updateUserData) {
            $this->dispatch('toastr', message: [
                'type' => 'success',
                'message' => 'Information Personnel mise a jour'
            ]);
        } else {
            $this->dispatch('toastr', message: [
                'type' => 'error',
                'message' => 'Une erreur est survenue.'
            ]);
        }

        #Transmission
        $this->dispatch('updateUserInfo')->to(TopHeaderUser::class);

    }

    public function updateUserPassword()
    {
        $user = User::findOrFail(auth()->user()->id);

        $this->validate([
            'current_password' => [
                'required',
                'min:5',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail("Le mot de passe actuel est incorrect.");
                    }
                }
            ],
            'new_password' => ['required', 'min:5', 'required_with:new_password_config', 'same:new_password_config'],
            'new_password_config' => ['required', 'min:5']
        ], [
            'current_password.required' => 'Veuillez saisir votre mot de passe actuel.',
            'current_password.min' => 'Le mot de passe actuel doit contenir au moins 5 caractères.',

            'new_password.required' => 'Veuillez saisir un nouveau mot de passe.',
            'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 5 caractères.',
            'new_password.required_with' => 'Veuillez confirmer votre nouveau mot de passe.',
            'new_password.same' => 'Les mots de passe ne correspondent pas. Veuillez réessayer.',

            'new_password_config.required' => 'Veuillez confirmer votre nouveau mot de passe.',
            'new_password_config.min' => 'La confirmation doit contenir au moins 5 caractères.',
        ]);


        $userUpdatePassword = $user->update([
            'password' => Hash::make($this->new_password)
        ]);

        sleep(0.6);

        if ($userUpdatePassword) {
            $this->dispatch('toastr', message: [
                'type' => 'success',
                'message' => 'Vous venez de modifier votre mot de passe',
            ]);
        } else {
            $this->dispatch('toastr', message: [
                'type' => 'error',
                'message' => 'Une erreur est survenue',
            ]);
        }

        #Send Mail
        $data = [
            'user' => $user,
            'actionLink' => route('admin.login'),
        ];

        $mail_body = view('email-template.confirm-password-reset', $data)->render();

        $mailConfig = [
            'recipient_address' => $user->email,
            'recipient_name' => $user->name,
            'subject' => 'Vous venez de modifier votre mot de passe',
            'body' => $mail_body,
        ];

        if (CMail::send($mailConfig)) {
            $this->dispatch('toastr', message: [
                'type' => 'success',
                'message' => 'Mot de passe mise a jour avec success',
            ]);
            #Je deconnecte le User
            Auth::logout();
            return redirect()->route('admin.login')->with('success', 'vous devez vous connecter en utilisant de nouvelle identifiant');
        } else {
            return redirect()->route('admin.profil_handler')->with('fail', 'une erreur est survenue');
        }

    }

    public function updateSocialLink()
    {
        #check social link for user
        $user = User::With('social_links')->findOrFail(auth()->user()->id);

        #validation
        $this->validate([
            'github' => ['nullable', 'url'],
            'facebook' => ['nullable', 'url'],
            'linkedin' => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
            'twitter' => ['nullable', 'url'],
            'youtube' => ['nullable', 'url'],
        ]);

        if (!is_null($user->social_links)) {
            $query = $user->social_links->update([
                'github' => $this->github,
                'facebook' => $this->facebook,
                'linkedin' => $this->linkedin,
                'instagram' => $this->instagram,
                'twitter' => $this->twitter,
                'youtube' => $this->youtube,
            ]);
        } else {
            $query = SocialLinks::insert([
                'github' => $this->github,
                'facebook' => $this->facebook,
                'linkedin' => $this->linkedin,
                'instagram' => $this->instagram,
                'twitter' => $this->twitter,
                'youtube' => $this->youtube,
                'user_id' => $user->id
            ]);
        }

        if ($query) {
            $this->dispatch('toastr', message: [
                'type' => 'success',
                'message' => 'Social lien ajouter avec succes'
            ]);
        } else {
            $this->dispatch('toastr', message: [
                'type' => 'error',
                'message' => 'une erreur est survenus'
            ]);
        }

    }

    public function render()
    {
        return view('livewire.admin.profil');
    }
}
