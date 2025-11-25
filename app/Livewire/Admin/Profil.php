<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class Profil extends Component
{
    public $name, $username, $email, $bio;

    public function mount()
    {
        $user = User::findOrFail(auth()->user()->id);

        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->bio = $user->bio;

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
    public function render()
    {
        return view('livewire.admin.profil');
    }
}
