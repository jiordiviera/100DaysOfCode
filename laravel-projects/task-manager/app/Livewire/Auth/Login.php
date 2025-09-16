<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email = "";
    public $password = "";
    public $remember = false;

    protected $rules = [
        "email" => "required|email",
        "password" => "required|min:6",
    ];

    public function submit()
    {
        $this->validate();

        if (
            Auth::attempt(
                ["email" => $this->email, "password" => $this->password],
                $this->remember,
            )
        ) {
            session()->regenerate();
            return redirect()->intended("/dashboard");
        } else {
            $this->addError(
                "email",
                "The provided credentials do not match our records.",
            );
        }
    }
    public function render()
    {
        return view("livewire.auth.login");
    }
}
