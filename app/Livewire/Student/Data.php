<?php

namespace App\Livewire\Student;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
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

    public $studentId;
    public $isCreateForm = true;

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

    public $oldAvatar;

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
        if ($this->isCreateForm && empty($this->$field)) {
            return '';
        }

        if ($this->getErrorBag()->has($field)) {
            return 'is-invalid';
        }

        return isset($this->$field) ? 'is-valid' : '';
    }

    public function resetCreateForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->avatar = null;
        $this->isCreateForm = true;
    }

    public function store()
    {
        $validasi = $this->validate();

        if (!empty($validasi['avatar'])) {
            $avatarName = rand(1000, 9999) . date('ymdHis') . '.' . $this->avatar->getClientOriginalExtension();
            $validasi['avatar'] = $this->avatar->storePubliclyAs('student', $avatarName, 'public');
        }

        $validasi['password'] = Hash::make($this->password);

        $validasi['role'] = 'student';

        $execute = User::create($validasi);

        if ($execute) {
            session()->flash('message', 'Berhasil tambah akun ' . $validasi['name'] . ' !');
            session()->flash('type-message', 'success');
        } else {
            session()->flash('message', 'Gagal tambah akun siswa !');
            session()->flash('type-message', 'error');
        }

        $this->reset(['name', 'email', 'password', 'avatar']);

        $this->redirectRoute('student.index', navigate: true);
    }

    public function mount()
    {
        $this->student = User::where('role', 'student')->get();
    }

    public function edit($id)
    {
        $editStudent = User::find($id);

        $this->studentId = $editStudent->id;
        $this->name = $editStudent->name;
        $this->email = $editStudent->email;
        $this->oldAvatar = $editStudent->avatar;
        $this->isCreateForm = false;
    }

    public function update()
    {
        // Find ID (didadekno variabel ben sintaks e kyk laravel biasa ne wkwk)
        $student = User::where('id', $this->studentId);

        $validasi = $this->validate();

        $oldAvatar = $this->oldAvatar;

        if (!empty($validasi['avatar'])) {
            if (!empty($oldAvatar)) {
                Storage::disk('public')->delete($oldAvatar);
                $avatarName = rand(1000, 9999) . date('ymdHis') . '.' . $this->avatar->getClientOriginalExtension();
                $validasi['avatar'] = $this->avatar->storePubliclyAs('student', $avatarName, 'public');
            } else {
                $avatarName = rand(1000, 9999) . date('ymdHis') . '.' . $this->avatar->getClientOriginalExtension();
                $validasi['avatar'] = $this->avatar->storePubliclyAs('student', $avatarName, 'public');
            }
        }

        if (!empty($validasi['password'])) {
            $validasi['password'] = Hash::make($this->password);
        }

        $student->update($validasi);

        return $this->redirectRoute('student.index', navigate: true);
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
