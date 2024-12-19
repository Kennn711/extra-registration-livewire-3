<?php

namespace App\Livewire\Leader;

use Livewire\Attributes\Title;
use Livewire\Component;

class Data extends Component
{
    #[Title('Registrasi Ekstra | Data Pembina')]

    public function render()
    {
        return view('livewire.leader.data');
    }
}
