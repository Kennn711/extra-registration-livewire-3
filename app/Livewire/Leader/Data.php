<?php

namespace App\Livewire\Leader;

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

    #[Title('Registrasi Ekstra | Data Pembina')]

    public $leader;

    public $leaderId;
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
            $validasi['avatar'] = $this->avatar->storePubliclyAs('leader', $avatarName, 'public');
        }

        $validasi['password'] = Hash::make($this->password);

        $validasi['role'] = 'leader';

        $execute = User::create($validasi);

        if ($execute) {
            session()->flash('message-success', 'Berhasil tambah akun ' . $validasi['name'] . ' !');
        } else {
            session()->flash('message-error', 'Gagal tambah akun siswa !');
        }

        $this->dispatch('leaderStore');

        $this->leader = User::where('role', 'leader')->latest()->get();
    }

    public function edit($id)
    {
        $editLeader = User::find($id);

        $this->rules['password'] = 'nullable';

        $this->leaderId = $editLeader->id;
        $this->name = $editLeader->name;
        $this->email = $editLeader->email;
        $this->oldAvatar = $editLeader->avatar;
        $this->password = '';
        $this->isCreateForm = false;
    }

    public function update()
    {
        // Find ID (didadekno variabel ben sintaks e kyk laravel biasa wkwk)
        $leader = User::where('id', $this->leaderId);

        $validasi = $this->validate();

        $oldAvatar = $this->oldAvatar;

        if (!empty($this->avatar)) {
            if (!empty($oldAvatar)) {
                Storage::disk('public')->delete($oldAvatar);
            }
            $avatarName = rand(1000, 9999) . date('ymdHis') . '.' . $this->avatar->getClientOriginalExtension();
            $validasi['avatar'] = $this->avatar->storePubliclyAs('leader', $avatarName, 'public');
        } else {
            $validasi['avatar'] = $oldAvatar;
        }


        if (!empty($validasi['password'])) {
            $validasi['password'] = Hash::make($this->password);
        }

        $leader->update($validasi);

        session()->flash('message-success', 'Berhasil update akun ' . $validasi['name'] . ' !');

        $this->dispatch('leaderStore');
    }

    public function destroy(User $leader)
    {
        if ($leader) {
            if (empty($leader->avatar)) {
                $leader->delete();
                session()->flash('message-success', 'Berhasil hapus akun ' . $leader->name . ' !');
            } else {
                Storage::disk('public')->delete($leader->avatar);
                $leader->delete();
                session()->flash('message-error', 'Berhasil hapus akun ' . $leader->name . ' !');
            }
        }

        return $this->redirectRoute('leader.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.leader.data', [
            'data' => User::where('role', 'leader')->latest()->paginate(3)
        ]);
    }
}
