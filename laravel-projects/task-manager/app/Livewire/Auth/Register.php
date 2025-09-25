<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Créer un compte')]
#[Layout('components.layouts.auth', [
    'heroTitle' => 'Bienvenue à bord',
    'heroSubtitle' => 'Créez votre compte pour organiser vos projets, prioriser vos tâches et voir vos avancées.',
])]
class Register extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $registerForm = [];

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('registerForm')
            ->components([
                TextInput::make('name')
                    ->label('Nom complet')
                    ->required()
                    ->minLength(3)
                    ->maxLength(255)
                    ->autocomplete('name')
                    ->helperText('Affiché dans vos projets et challenges.'),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->autocomplete('email')
                    ->rule('unique:users,email')
                    ->helperText('Votre adresse principale pour les notifications.'),
                TextInput::make('password')
                    ->label('Mot de passe')
                    ->password()
                    ->required()
                    ->minLength(6)
                    ->maxLength(255)
                    ->autocomplete('new-password')
                    ->helperText('Au moins 6 caractères.'),
                TextInput::make('password_confirmation')
                    ->label('Confirmation du mot de passe')
                    ->password()
                    ->required()
                    ->same('password')
                    ->autocomplete('new-password'),
            ]);
    }

    public function submit()
    {
        $this->form->validate();
        $data = $this->form->getState();

        $user = User::create([
            'name' => trim($data['name'] ?? ''),
            'email' => strtolower(trim($data['email'] ?? '')),
            'password' => $data['password'] ?? '',
        ]);

        auth()->login($user);

        return redirect()->intended(route('dashboard'));
    }

    public function render(): View
    {
        return view('livewire.auth.register');
    }
}
