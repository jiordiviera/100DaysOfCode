<?php

namespace App\Livewire\Page;

use App\Models\ChallengeRun;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Mes Challenges')]
#[Layout('components.layouts.app')]
class ChallengeIndex extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $challengeForm = [];

    public function mount(): void
    {
        $this->form->fill([
            'title' => '',
            'start_date' => now()->toDateString(),
            'target_days' => 100,
            'is_public' => false,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('challengeForm')
            ->columns(2)
            ->components([
                TextInput::make('title')
                    ->label('Titre')
                    ->placeholder('100 Days of Code')
                    ->required()
                    ->maxLength(255)
                    ->unique(ChallengeRun::class, 'title'),
                DatePicker::make('start_date')
                    ->label('Date de début')
                    ->native(false)
                    ->required()
                    ->default(now()->toDateString()),
                TextInput::make('target_days')
                    ->label('Nombre de jours')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(365)
                    ->required(),
                Toggle::make('is_public')
                    ->label('Rendre public')
                    ->inline(false)
                    ->columnSpanFull(),
            ]);
    }

    public function create(): void
    {
        $this->form->validate();
        $data = $this->form->getState();

        $run = ChallengeRun::create([
            'owner_id' => auth()->id(),
            'title' => $data['title'],
            'start_date' => $data['start_date'],
            'target_days' => (int) $data['target_days'],
            'status' => 'active',
            'is_public' => (bool) ($data['is_public'] ?? false),
        ]);

        $run->participantLinks()->create([
            'user_id' => auth()->id(),
            'joined_at' => now(),
        ]);

        $this->form->fill([
            'title' => '',
            'start_date' => now()->toDateString(),
            'target_days' => 100,
            'is_public' => false,
        ]);

        redirect()->route('challenges.show', ['run' => $run->id]);
    }

    public function render(): View
    {
        $user = auth()->user();
        $owned = $user->challengeRunsOwned()->latest()->get();
        $joined = $user->challengeRuns()->whereNotIn('challenge_runs.id', $owned->pluck('id'))->latest()->get();

        return view('livewire.page.challenge-index', [
            'owned' => $owned,
            'joined' => $joined,
        ]);
    }
}
