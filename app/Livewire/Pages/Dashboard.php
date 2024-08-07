<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Dashboard extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.pages.dashboard');
    }
}
