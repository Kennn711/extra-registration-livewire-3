<?php

namespace App\Livewire\Student;

use App\Models\User;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormEdit extends Component
{
    public function render()
    {
        return view('livewire.student.form-edit');
    }
}
