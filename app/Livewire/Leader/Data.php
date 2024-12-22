<?php

namespace App\Livewire\Leader;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Data extends Component
{
    use WithFileUploads;

    #[Title('Registrasi Ekstra | Data Pembina')]

    public $leader;

    public $leaderId;
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

    public function mount()
    {
        $this->leader = User::where('role', 'leader')->get();
    }

    public function store()
    {
        $validasi = $this->validate();

        if (!empty($validasi['avatar'])) {
            $avatarName = rand(1000, 9999) . date('ymdHis') . '.' . $this->avatar->getClientOriginalExtension();
            $validasi['avatar'] = $this->avatar->storePubliclyAs('leader', $avatarName, 'public');
        }

        $validasi['role'] = 'leader';

        $execute = User::create($validasi);

        if ($execute) {
            session()->flash('type-message', 'success');
            session()->flash('message', 'Berhasil tambah akun ' . $validasi['name'] . ' !');
        } else {
            session()->flash('type-message', 'error');
            session()->flash('message', 'Gagal tambah akun pembina ekstra !');
        }

        return $this->redirectRoute('leader.index', navigate: true);
    }

    public function destroy(User $leader)
    {
        $namaLeader = $leader->name;

        if ($leader) {
            if (empty($leader->avatar)) {
                $leader->delete();
                session()->flash('type-message', 'success');
                session()->flash('message', 'Berhasil hapus akun ' . $namaLeader . ' !');
            } else {
                Storage::disk('public')->delete($leader->avatar);
                $leader->delete();
                session()->flash('type-message', 'success');
                session()->flash('message', 'Berhasil hapus akun ' . $namaLeader . ' !');
            }
        }

        return $this->redirectRoute('leader.index', navigate: true);
    }

    public function edit($id)
    {
        $editleader = User::find($id);

        $this->leaderId = $editleader->id;
        $this->name = $editleader->name;
        $this->email = $editleader->email;
        $this->oldAvatar = $editleader->avatar;
    }

    public function render()
    {
        return view('livewire.leader.data');
    }
}
