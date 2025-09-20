<?php

namespace App\Livewire\Page;

use App\Models\ChallengeRun;
use App\Models\DailyLog;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class DailyChallenge extends Component
{
    public $challengeDate;

    public $description;

    public $projectsWorkedOn = [];

    public $hoursCoded = 1;

    public $learnings;

    public $challengesFaced;

    public $todayEntry;

    public $allProjects;

    public $challengeRunId;

    public function mount()
    {
        $this->challengeDate = now()->format('Y-m-d');
        $this->allProjects = Project::query()
            ->where('user_id', auth()->id())
            ->orWhereHas('members', fn ($q) => $q->where('users.id', auth()->id()))
            ->get();
        if ($redirect = $this->ensureChallengeRun()) {
            return $redirect;
        }
        $this->loadTodayEntry();
    }

    protected function ensureChallengeRun(): ?RedirectResponse
    {
        $userId = auth()->id();
        // Try to find latest active run owned by the user
        $run = ChallengeRun::where('owner_id', $userId)
            ->orderByDesc('id')
            ->first();

        // If no run yet, redirect to challenges page to create one explicitly
        if (! $run) {
            session()->flash('message', 'Créez votre challenge pour commencer votre journal quotidien.');

            return redirect()->route('challenges.index');
        }

        $this->challengeRunId = $run->id;

        return null;
    }

    public function loadTodayEntry()
    {
        $run = ChallengeRun::findOrFail($this->challengeRunId);
        $date = Carbon::parse($this->challengeDate);
        $start = Carbon::parse($run->start_date);
        $dayNumber = $start->diffInDays($date) + 1;

        $this->todayEntry = DailyLog::where('challenge_run_id', $run->id)
            ->where('user_id', auth()->id())
            ->where('day_number', $dayNumber)
            ->first();

        if ($this->todayEntry) {
            $this->description = $this->todayEntry->notes;
            $this->projectsWorkedOn = $this->todayEntry->projects_worked_on ?? [];
            $this->hoursCoded = $this->todayEntry->hours_coded ?? 1;
            $this->learnings = $this->todayEntry->learnings;
            $this->challengesFaced = $this->todayEntry->challenges_faced;
        } else {
            // Reset fields for a new entry
            $this->description = '';
            $this->projectsWorkedOn = [];
            $this->hoursCoded = 1;
            $this->learnings = null;
            $this->challengesFaced = null;
        }
    }

    public function saveEntry()
    {
        $this->validate([
            'description' => 'required|min:10',
            'hoursCoded' => 'required|numeric|min:0.25',
            'projectsWorkedOn' => 'array',
        ]);

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
                'hours_coded' => $this->hoursCoded,
                'projects_worked_on' => $this->projectsWorkedOn,
                'notes' => $this->description,
                'learnings' => $this->learnings,
                'challenges_faced' => $this->challengesFaced,
                'completed' => true,
            ]
        );
        session()->flash('message', 'Entrée quotidienne sauvegardée !');
        $this->loadTodayEntry();
    }

    public function render()
    {
        return view('livewire.page.daily-challenge');
    }
}
