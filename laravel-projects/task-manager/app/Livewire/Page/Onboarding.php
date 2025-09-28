<?php

namespace App\Livewire\Page;

use App\Models\ChallengeRun;
use App\Support\Onboarding\OnboardUserAction;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Onboarding')]
#[Layout('components.layouts.app')]
class Onboarding extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $onboardingForm = [];

    public $publicChallenges;

    public array $publicChallengeOptions = [];

    public function mount(): void
    {
        if (! auth()->user()->needsOnboarding()) {
            $this->redirectRoute('dashboard');

            return;
        }

        $this->publicChallenges = ChallengeRun::query()
            ->where('is_public', true)
            ->with('owner:id,name')
            ->latest('start_date')
            ->limit(15)
            ->get(['id', 'title', 'owner_id', 'public_join_code', 'target_days', 'start_date']);

        $this->publicChallengeOptions = $this->publicChallenges
            ->mapWithKeys(fn ($challenge) => [$challenge->id => $challenge->title])
            ->toArray();

        $this->form->fill([
            'join_reason' => 'start_new',
            'target_days' => 100,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('onboardingForm')
            ->columns(2)
            ->components([
                Radio::make('join_reason')
                    ->label('Que souhaitez-vous faire ?')
                    ->options([
                        'start_new' => 'Lancer mon challenge',
                        'join_code' => 'Rejoindre avec un code',
                        'join_public' => 'Rejoindre un challenge public',
                        'explore' => 'Explorer avant de me lancer',
                    ])
                    ->default('start_new')
                    ->live()
                    ->columnSpanFull(),
                TextInput::make('challenge_title')
                    ->label('Nom du challenge')
                    ->default('Mon défi 100DaysOfCode')
                    ->maxLength(255)
                    ->visible(fn (Get $get) => $get('join_reason') === 'start_new'),
                Textarea::make('challenge_description')
                    ->label('Description (optionnel)')
                    ->rows(2)
                    ->maxLength(255)
                    ->visible(fn (Get $get) => $get('join_reason') === 'start_new')
                    ->columnSpanFull(),
                TextInput::make('target_days')
                    ->label('Durée (jours)')
                    ->numeric()
                    ->default(100)
                    ->minValue(1)
                    ->visible(fn (Get $get) => $get('join_reason') === 'start_new'),
                Toggle::make('make_public')
                    ->label('Rendre ce challenge public')
                    ->default(false)
                    ->visible(fn (Get $get) => $get('join_reason') === 'start_new'),
                TextInput::make('invite_code')
                    ->label('Code d’invitation')
                    ->maxLength(255)
                    ->required(fn (Get $get) => $get('join_reason') === 'join_code')
                    ->visible(fn (Get $get) => $get('join_reason') === 'join_code')
                    ->helperText('Code reçu par mail ou partagé par un organisateur.'),
                Select::make('public_challenge_id')
                    ->label('Challenge public à rejoindre')
                    ->options($this->publicChallengeOptions)
                    ->searchable()
                    ->required(fn (Get $get) => $get('join_reason') === 'join_public')
                    ->visible(fn (Get $get) => $get('join_reason') === 'join_public')
                    ->placeholder('Choisir…'),
                TextInput::make('focus_area')
                    ->label('Votre objectif principal')
                    ->maxLength(120)
                    ->helperText('Exemple : "Apprendre Laravel" ou "Automatiser mes workflows"')
                    ->columnSpanFull(),
                TextInput::make('origin')
                    ->label('Comment avez-vous connu la plateforme ?')
                    ->maxLength(120)
                    ->columnSpanFull(),
            ]);
    }

    public function submit()
    {
        $this->form->validate();
        $data = $this->form->getState();

        $action = app(OnboardUserAction::class);
        $summary = $action->execute(auth()->user(), Arr::only($data, [
            'join_reason',
            'challenge_title',
            'challenge_description',
            'target_days',
            'make_public',
            'invite_code',
            'public_challenge_id',
            'focus_area',
            'origin',
        ]));

        session()->flash('onboarding_messages', $summary['messages'] ?? []);
        session()->flash('onboarding_new_badges', $summary['new_badges'] ?? []);

        return redirect()->route('dashboard');
    }

    public function render(): View
    {
        return view('livewire.page.onboarding');
    }
}
