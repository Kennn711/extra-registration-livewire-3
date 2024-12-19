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
    use WithFileUploads;

    public $studentId;

    #[Validate('required', message: "Name is required !")]
    #[Validate('min:3', message: "Name must be 3 chars minimum long !")]
    public $name;

    #[Validate('required', message: "Email is required !")]
    public $email;

    public $password;

    public $oldPassword;

    #[Validate('nullable', message: "File must be an image !")]
    #[Validate('max:2048', message: "Image must be not more than 2 MB !")]
    #[Validate('mimes:jpg,jpeg,webp,png', message: "Image must be jpg, jpeg, webp, / png !")]
    public $avatar;

    public $oldAvatar;

    #[Title('Registrasi Ekstra | Edit Akun Siswa')]

    public function mount($id)
    {
        $student = User::find($id);

        $this->studentId = $student->id;
        $this->name = $student->name;
        $this->email = $student->email;
        $this->oldPassword = $student->password;
        $this->oldAvatar = $student->avatar;
    }

    public function validationClass($field)
    {
        if ($this->getErrorBag()->has($field)) {
            return 'is-invalid';
        } else {
            return isset($this->$field) ? 'is-valid' : '';
        }
    }

    public function update()
    {
        $validasi = $this->validate();

        if ($this->avatar) {
            if ($this->oldAvatar && FacadesStorage::disk('public')->exists($this->oldAvatar)) {
                FacadesStorage::disk('public')->delete($this->oldAvatar);
            }

            $newAvatar = rand(1000, 9999) . date('ymdHis') . '.' . $this->avatar->getClientOriginalExtension();
            $validasi['avatar'] = $this->avatar->storePubliclyAs('student', $newAvatar, 'public');
        } else {
            $validasi['avatar'] = $this->oldAvatar;
        }

        if ($this->password) {
            $validasi['password'] = bcrypt($this->password);
        } else {
            $validasi['password'] = $this->oldPassword;
        }

        $student = User::find($this->studentId);
        $execute = $student->update($validasi);

        if ($execute) {
            session()->flash('message', 'Berhasil edit akun !');
            session()->flash('type-message', 'success');
        } else {
            session()->flash('message', 'Gagal edit akun !');
            session()->flash('type-message', 'error');
        }

        return $this->redirectRoute('student.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.student.form-edit');
    }
}
