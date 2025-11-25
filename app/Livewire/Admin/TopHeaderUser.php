<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class TopHeaderUser extends Component
{

    protected $listeners = [
        'updateUserInfo' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.admin.top-header-user', [
            'user' => User::findOrFail(auth()->user()->id)
        ]);
    }
}
