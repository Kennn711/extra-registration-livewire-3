<?php

namespace App\Livewire\Student;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Component;
use Livewire\WithFileUploads;

class Data extends Component
{
    use WithFileUploads;
    use WithPagination, WithoutUrlPagination;

    #[Title('Registrasi Ekstra | Data Siswa')]

    public $student;

    public $studentId;
    public $isCreateForm = true;

    public $name;
    public $email;
    public $password;
    public $avatar;

    public $oldAvatar;

    protected $rules = [
        'name'     => 'required|min:3',
        'email'    => 'required',
        'password' => 'required',
        'avatar'   => 'nullable|mimes:jpg,png,jpeg,webp',
    ];

    protected $paginationTheme = 'bootstrap';

    public function boot()
    {
        $this->resetErrorBag();
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
            session()->flash('message-success', 'Berhasil tambah akun ' . $validasi['name'] . ' !');
        } else {
            session()->flash('message-error', 'Gagal tambah akun siswa !');
        }

        $this->dispatch('studentStore');

        $this->student = User::where('role', 'student')->latest()->get();
    }

    public function edit($id)
    {
        $editStudent = User::find($id);

        $this->rules['password'] = 'nullable';

        $this->studentId = $editStudent->id;
        $this->name = $editStudent->name;
        $this->email = $editStudent->email;
        $this->oldAvatar = $editStudent->avatar;
        $this->password = '';
        $this->isCreateForm = false;
    }

    public function update()
    {
        // Find ID (didadekno variabel ben sintaks e kyk laravel biasa wkwk)
        $student = User::where('id', $this->studentId);

        $validasi = $this->validate();

        $oldAvatar = $this->oldAvatar;

        if (!empty($this->avatar)) {
            if (!empty($oldAvatar)) {
                Storage::disk('public')->delete($oldAvatar);
            }
            $avatarName = rand(1000, 9999) . date('ymdHis') . '.' . $this->avatar->getClientOriginalExtension();
            $validasi['avatar'] = $this->avatar->storePubliclyAs('student', $avatarName, 'public');
        } else {
            $validasi['avatar'] = $oldAvatar;
        }


        if (!empty($validasi['password'])) {
            $validasi['password'] = Hash::make($this->password);
        }

        $student->update($validasi);

        session()->flash('message-success', 'Berhasil update akun ' . $validasi['name'] . ' !');

        $this->dispatch('studentStore');
    }

    public function destroy(User $student)
    {
        if ($student) {
            if (empty($student->avatar)) {
                $student->delete();
                session()->flash('message-success', 'Berhasil hapus akun ' . $student->name . ' !');
            } else {
                Storage::disk('public')->delete($student->avatar);
                $student->delete();
                session()->flash('message-error', 'Berhasil hapus akun ' . $student->name . ' !');
            }
        }

        return $this->redirectRoute('student.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.student.data', [
            'data' => User::where('role', 'student')->latest()->paginate(3)
        ]);
    }
}
