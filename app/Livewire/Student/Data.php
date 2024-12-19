<?php

namespace App\Livewire\Student;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Data extends Component
{
    use WithFileUploads;

    #[Title('Registrasi Ekstra | Data Siswa')]

    public $student;

    #[Validate('required', message: "Name is required !")]
    #[Validate('min:3', message: "Name must be 3 chars minimum long !")]
    public $name;

    #[Validate('required', message: "Email is required !")]
    public $email;

    #[Validate('required', message: "Password is required !")]
    public $password;

    #[Validate('nullable', message: "File must be an image !")]
    #[Validate('max:2048', message: "Image must be not more than 2 MB !")]
    #[Validate('mimes:jpg,jpeg,webp,png', message: "Image must be jpg, jpeg, webp, / png !")]
    public $avatar;

    public function save()
    {
        $validatedData = $this->validate();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function validationClass($field)
    {
        if ($this->getErrorBag()->has($field)) {
            return 'is-invalid';
        }

        return isset($this->$field) ? 'is-valid' : '';
    }

    public function store()
    {
        $validasi = $this->validate();

        if (!empty($validasi['avatar'])) {
            $avatarName = rand(1000, 9999) . date('ymdHis') . '.' . $this->avatar->getClientOriginalExtension();
            $validasi['avatar'] = $this->avatar->storePubliclyAs('student', $avatarName, 'public');
        }

        $validasi['role'] = 'student';

        $execute = User::create($validasi);

        if ($execute) {
            session()->flash('message', 'Berhasil tambah akun ' . $validasi['name'] . ' !');
            session()->flash('type-message', 'success');
        } else {
            session()->flash('message', 'Gagal tambah akun siswa !');
            session()->flash('type-message', 'error');
        }

        return $this->redirectRoute('student.index', navigate: true);
    }

    public function mount()
    {
        $this->student = User::where('role', 'student')->get();
    }

    public function destroy(User $student)
    {
        if ($student) {
            if (empty($student->avatar)) {
                $student->delete();
                session()->flash('type-message', 'success');
                session()->flash('message', 'Berhasil hapus akun ' . $student->name . ' !');
            } else {
                Storage::disk('public')->delete($student->avatar);
                $student->delete();
                session()->flash('type-message', 'success');
                session()->flash('message', 'Berhasil hapus akun ' . $student->name . ' !');
            }
        }

        return $this->redirectRoute('student.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.student.data');
    }
}
