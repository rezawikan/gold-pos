<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class SearchForm extends Component
{

    #[Modelable]
    public $search = '';

    public function render()
    {
        return view('livewire.forms.search-form');
    }
}
