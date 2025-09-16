<?php

use App\Livewire\Page\Dashboard;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Dashboard::class)
        ->assertStatus(200);
});
