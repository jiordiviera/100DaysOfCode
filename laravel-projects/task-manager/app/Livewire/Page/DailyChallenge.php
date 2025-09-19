<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\Challenge;
use App\Models\Project;
use Illuminate\Support\Carbon;

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

    public function mount()
    {
        $this->challengeDate = now()->format('Y-m-d');
        $this->allProjects = Project::whereHas('members', fn($q) => $q->where('users.id', auth()->id()))->get();
        $this->loadTodayEntry();
    }

    public function loadTodayEntry()
    {
        $this->todayEntry = Challenge::where('user_id', auth()->id())
            ->where('challenge_date', $this->challengeDate)
            ->first();
        if ($this->todayEntry) {
            $this->description = $this->todayEntry->description;
            $this->projectsWorkedOn = $this->todayEntry->projects_worked_on ?? [];
            $this->hoursCoded = $this->todayEntry->hours_coded;
            $this->learnings = $this->todayEntry->learnings;
            $this->challengesFaced = $this->todayEntry->challenges_faced;
        }
    }

    public function saveEntry()
    {
        $this->validate([
            'description' => 'required|min:10',
            'hoursCoded' => 'required|integer|min:1',
            'projectsWorkedOn' => 'array'
        ]);
        Challenge::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'challenge_date' => $this->challengeDate
            ],
            [
                'description' => $this->description,
                'projects_worked_on' => $this->projectsWorkedOn,
                'hours_coded' => $this->hoursCoded,
                'learnings' => $this->learnings,
                'challenges_faced' => $this->challengesFaced,
                'completed' => true
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
