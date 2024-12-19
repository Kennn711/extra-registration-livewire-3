<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h3 class="fw-bold">Edit Akun Siswa</h3>
                    <a href="{{ route('student.index') }}" wire:navigate class="btn btn-warning btn-md">Kembali</a>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <form wire:submit.prevent="update" method="POST">
                            <div class="form-group">
                                <label class="fw-bold h2">Name</label>
                                <input type="text" wire:model.live="name" class="form-control  {{ $this->validationClass('name') }}">
                                @error('name')
                                    <span class="text-danger position-absolute">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="row justify-content-between">
                                    <div class="col-md-6">
                                        <label class="fw-bold h2">Email</label>
                                        <input type="email" wire:model.live="email" class="form-control  {{ $this->validationClass('email') }}">
                                        @error('email')
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold h2">Password</label>
                                        <input type="password" wire:model.live="password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row justify-content-between">
                                    <div class="col-md-6">
                                        <label class="fw-bold h2">Foto Profil yang lama</label>
                                        <div class="d-flex justify-content-center mt-5">
                                            @if (!empty($oldAvatar))
                                                <img src="{{ Storage::url($oldAvatar) }}" width="200" class="img-fluid rounded-circle">
                                            @else
                                                <p>Tidak ada foto profil</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold h2">Masukkan foto profil yang baru</label>
                                        <input type="file" wire:model="avatar" class="form-control">
                                        @error('avatar')
                                            <span class="text-danger position-absolute">{{ $message }}</span>
                                        @enderror
                                        @if (is_object($avatar))
                                            <div class="d-flex justify-content-center mt-2">
                                                <img src="{{ $avatar->temporaryUrl() }}" class="img-fluid rounded-circle w-50">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <button class="btn btn-warning btn-md">Ubah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
