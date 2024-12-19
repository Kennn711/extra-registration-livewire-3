<?php

namespace App\Livewire\Extra;

use Livewire\Attributes\Title;
use Livewire\Component;

class Data extends Component
{
    #[Title('Registrasi Ekstra | Data Ekstra')]

    public function render()
    {
        return view('livewire.extra.data');
    }
}
