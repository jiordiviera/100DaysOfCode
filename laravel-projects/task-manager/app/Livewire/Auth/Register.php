<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Register extends Component
{
    public $name = "";
    public $email = "";
    public $password = "";
    public $password_confirmation = "";
    protected $rules = [
        "name" => "required|min:3",
        "email" => "required|email|unique:users,email",
        "password" => "required|min:6|confirmed",
    ];

    public function submit()
    {
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = $this->password;
        $user->save();
        auth()->login($user);
        return redirect()->route("dashboard");
    }
    public function render(): View
    {
        return view('livewire.auth.register');
    }
}
