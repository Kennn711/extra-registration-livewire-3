<div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Data Pembina Ekstra</h4>
                    <button class="btn btn-success" wire:click="resetCreateForm" data-bs-toggle="modal" data-bs-target="#addLeader">
                        <i class="bi bi-plus-square h3"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div wire:ignore.self class="modal fade" id="addLeader" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header border-1">
                                <h5 class="modal-title">
                                    <span class="fw-mediumbold">Tambah Akun Pembina</span>
                                </h5>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row">
                                        @if (is_object($avatar))
                                            <div class="d-flex justify-content-center">
                                                <img src="{{ $avatar->temporaryUrl() }}" alt="" class="img-fluid w-50 rounded-circle">
                                            </div>
                                        @endif
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="fw-bold">Nama Lengkap</label>
                                                <input type="text" wire:model.live="name" class="form-control {{ $this->validationClass('name') }}" placeholder="Masukkan nama lengkap">
                                                @error('name')
                                                    <span class="text-danger position-absolute">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 pe-0">
                                            <div class="form-group">
                                                <label class="fw-bold">Email</label>
                                                <input type="email" wire:model.live="email" class="form-control {{ $this->validationClass('email') }}" placeholder="Masukkan email">
                                                @error('email')
                                                    <span class="text-danger position-absolute">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="fw-bold">Password</label>
                                                <input type="password" wire:model.live="password" class="form-control {{ $this->validationClass('password') }}" placeholder="Masukkan password">
                                                @error('password')
                                                    <span class="text-danger position-absolute">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="fw-bold">Masukkan Foto Profil</label>
                                                <input type="file" wire:model.live="avatar" class="form-control {{ $this->validationClass('avatar') }}">
                                                @error('avatar')
                                                    <span class="text-danger position-absolute">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer border-0 justify-content-center">
                                <button wire:click.prevent="store" class="btn btn-success">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
                @include('livewire.leader.form-edit')
                <table class="table table-striped table-hover">
                    <div class="d-flex justify-content-end align-items-center">
                        <form>
                            <p class="fw-bold">Search :
                                <input type="text">
                            </p>
                        </form>
                    </div>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($data as $see)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="avatar">
                                        @if (empty($see->avatar))
                                            <img src="{{ asset('uploads/empty-avatar.webp') }}" class="avatar-img rounded-circle">
                                        @else
                                            <img src="{{ Storage::url($see->avatar) }}" class="avatar-img rounded-circle">
                                        @endif
                                    </div>
                                    {{ $see->name }}
                                </td>
                                <td>{{ $see->email }}</td>
                                <td>
                                    <button data-bs-toggle="modal" wire:click="edit({{ $see->id }})" data-bs-target="#editLeader" class="btn" tabindex="-1" style="outline: none; box-shadow: none; border: none;">
                                        <i class="bi bi-pencil-square text-warning h1"style="outline: none;"></i>
                                    </button>
                                    <button wire:click="destroy({{ $see->id }})" class="btn" tabindex="-1" style="outline: none; box-shadow: none; border: none;">
                                        <i class="bi bi-trash-fill text-danger h1"style="outline: none;"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @livewireScripts
    <script>
        Livewire.on('leaderStore', () => {
            $('#addLeader').modal('hide');
            $('#editLeader').modal('hide');
        });
    </script>
@endpush
