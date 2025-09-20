<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Créer un compte')]
#[Layout('components.layouts.auth', [
    'heroTitle' => 'Bienvenue à bord',
    'heroSubtitle' => 'Créez votre compte pour organiser vos projets, prioriser vos tâches et voir vos avancées.',
])]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    protected array $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ];

    protected array $messages = [
        'name.required' => 'Le nom est obligatoire.',
        'name.min' => 'Le nom doit contenir au moins :min caractères.',
        'email.required' => "L'adresse e-mail est obligatoire.",
        'email.email' => 'Veuillez saisir une adresse e-mail valide.',
        'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
        'password.required' => 'Le mot de passe est obligatoire.',
        'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
        'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
    ];

    public function submit()
    {
        $this->validate();

        $user = new User;
        $user->name = trim($this->name);
        $user->email = strtolower(trim($this->email));
        // Le hash est géré par le cast sur le modèle User
        $user->password = $this->password;
        $user->save();

        auth()->login($user);

        return redirect()->route('dashboard');
    }

    public function render(): View
    {
        return view('livewire.auth.register');
    }
}
