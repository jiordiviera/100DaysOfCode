<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Title('Connexion')]
#[Layout('components.layouts.auth', [
    'heroTitle' => 'Reprenez votre productivité',
    'heroSubtitle' => 'Connectez-vous pour gérer vos tâches, suivre vos progrès et rester concentré sur vos objectifs.',
])]
class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected array $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    protected array $messages = [
        'email.required' => "L'adresse e-mail est obligatoire.",
        'email.email' => "Veuillez saisir une adresse e-mail valide.",
        'password.required' => 'Le mot de passe est obligatoire.',
        'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
    ];

    public function submit()
    {
        $this->validate();

        $credentials = [
            'email' => strtolower(trim($this->email)),
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, (bool) $this->remember)) {
            session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        $this->addError('email', 'Email ou mot de passe incorrect.');
    }

    public function render(): View
    {
        return view('livewire.auth.login');
    }
}
