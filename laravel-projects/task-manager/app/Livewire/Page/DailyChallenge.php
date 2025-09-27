<?php

namespace App\Livewire\Page;

use App\Models\ChallengeRun;
use App\Models\DailyLog;
use App\Models\Project;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class DailyChallenge extends Component implements HasForms
{
    use InteractsWithForms;

    public string $challengeDate;

    public ?array $dailyForm = [];

    public $todayEntry;

    public $allProjects;

    public $challengeRunId;

    public function mount(): void
    {
        $this->challengeDate = now()->format('Y-m-d');
        $this->allProjects = Project::query()
            ->where('user_id', auth()->id())
            ->orWhereHas('members', fn ($q) => $q->where('users.id', auth()->id()))
            ->get();

        $this->ensureChallengeRun();
        $this->form->fill([
            'description' => '',
            'projects_worked_on' => [],
            'hours_coded' => 1,
            'learnings' => null,
            'challenges_faced' => null,
        ]);
        //        dd(1);
        $this->loadTodayEntry();
        //        dd(1);
    }

    protected function ensureChallengeRun()
    {
        $userId = auth()->id();
        $run = ChallengeRun::where('owner_id', $userId)
            ->orderByDesc('id')
            ->first();
        //        dd($run);

        if (! $run) {
            //            session()->flash('message', 'Créez votre challenge pour commencer votre journal quotidien.');
            Notification::make()
                ->title('Créez votre challenge pour commencer votre journal quotidien.')
                ->warning()
                ->send();

            return;
        }

        $this->challengeRunId = $run->id;

        return null;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('dailyForm')
            ->columns(2)
            ->components([
                Textarea::make('description')
                    ->label('Description du jour')
                    ->required()
                    ->minLength(10)
                    ->columnSpanFull(),
                CheckboxList::make('projects_worked_on')
                    ->label('Projets travaillés')
                    ->options(fn () => $this->allProjects?->pluck('name', 'id')->mapWithKeys(fn ($label, $id) => [(string) $id => $label])->toArray() ?? [])
                    ->columnSpanFull(),
                TextInput::make('hours_coded')
                    ->label('Heures codées')
                    ->numeric()
                    ->minValue(0.25)
                    ->step(0.25)
                    ->required()
                    ->default(1),
                Textarea::make('learnings')
                    ->label('Apprentissages du jour')
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('challenges_faced')
                    ->label('Difficultés rencontrées')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public function loadTodayEntry(): void
    {
        $run = ChallengeRun::find($this->challengeRunId);
        if (! $run) {
            return;
        }
        $date = Carbon::parse($this->challengeDate);
        $start = Carbon::parse($run->start_date);
        $dayNumber = $start->diffInDays($date) + 1;

        $this->todayEntry = DailyLog::where('challenge_run_id', $run->id)
            ->where('user_id', auth()->id())
            ->where('day_number', $dayNumber)
            ->first();

        $entry = $this->todayEntry;

        $this->form->fill([
            'description' => $entry?->notes ?? '',
            'projects_worked_on' => collect($entry?->projects_worked_on ?? [])->map(fn ($id) => (string) $id)->all(),
            'hours_coded' => $entry?->hours_coded ?? 1,
            'learnings' => $entry?->learnings,
            'challenges_faced' => $entry?->challenges_faced,
        ]);
    }

    public function saveEntry(): void
    {
        $this->form->validate();
        $data = $this->form->getState();

        $run = ChallengeRun::findOrFail($this->challengeRunId);
        $date = Carbon::parse($this->challengeDate);
        $dayNumber = Carbon::parse($run->start_date)->diffInDays($date) + 1;

        DailyLog::updateOrCreate(
            [
                'challenge_run_id' => $run->id,
                'user_id' => auth()->id(),
                'day_number' => $dayNumber,
            ],
            [
                'date' => $date->toDateString(),
                'hours_coded' => isset($data['hours_coded']) ? (float) $data['hours_coded'] : 1,
                'projects_worked_on' => collect($data['projects_worked_on'] ?? [])->map(fn ($id) => (string) $id)->all(),
                'notes' => $data['description'] ?? '',
                'learnings' => $data['learnings'] ?? null,
                'challenges_faced' => $data['challenges_faced'] ?? null,
                'completed' => true,
            ]
        );

        session()->flash('message', 'Entrée quotidienne sauvegardée !');
        $this->loadTodayEntry();
    }

    public function render(): View
    {
        return view('livewire.page.daily-challenge');
    }
}
