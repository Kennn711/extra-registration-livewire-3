<?php

namespace App\Livewire\Extra;

use App\Models\Extra;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class Data extends Component
{
    use WithFileUploads;
    #[Title('Registrasi Ekstra | Data Ekstra')]

    public $name;
    public $extra_day;
    public $time;
    public $description;
    public $logo;

    public $leader;
    public $leader_id;

    public $extra;

    public $isCreateForm = '';

    protected $rules = [
        'name' => 'required|min:3',
        'extra_day' => 'required',
        'time' => 'required',
        'description' => 'required',
        'logo' => 'mimes:jpg,png,jpeg,webp',
        'leader_id' => 'required',
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
        $this->extra_day = '';
        $this->time = '';
        $this->description = null;
        $this->isCreateForm = true;
    }

    public function store()
    {
        $validasi = $this->validate();

        if (!empty($validasi['logo'])) {
            $logoName = rand(1000, 9999) . date('ymdHis') . '.' . $this->logo->getClientOriginalExtension();
            $validasi['logo'] = $this->logo->storePubliclyAs('extra', $logoName, 'public');
        }

        $execute = Extra::create($validasi);
        $leader = User::find($validasi['leader_id']);
        $leader->extra_id = $execute->id;
        $leader->save();

        if ($execute) {
            session()->flash('message-success', 'Berhasil tambah ekstra ' . $validasi['name'] . ' !');
        } else {
            session()->flash('message-error', 'Gagal tambah ekstra baru !');
        }

        $this->dispatch('extraStore');

        $this->extra = Extra::with('leader')->latest()->get();
    }

    public function destroy(Extra $extra)
    {
        Storage::disk('public')->delete($extra->logo);
        $execute = $extra->delete();
        if ($execute) {
            session()->flash('message-success', 'Berhasil hapus ekstra !');
        } else {
            session()->flash('message-error', 'Gagal hapus ekstra !');
        }

        return $this->redirectRoute('extra.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.extra.data', [
            'data' => Extra::with('leader')->latest()->get(),
            'chooseLeader' => User::where('role', 'leader')->where('extra_id', NULL)->get()
        ]);
    }
}
