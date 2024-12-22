<div>
    <div wire:ignore.self class="modal fade" id="editStudent" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-1">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">Edit Akun Siswa</span>
                    </h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                @if (empty($oldAvatar))
                                    <p class="text-danger">Tidak ada foto profil</p>
                                @else
                                    <img src="{{ Storage::url($oldAvatar) }}" alt="" class="img-fluid rounded-circle w-50 mb-2">
                                @endif
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="fw-bold">Nama Lengkap</label>
                                    <input type="text" wire:model.live="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama lengkap">
                                    @error('name')
                                        <span class="text-danger position-absolute">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 pe-0">
                                <div class="form-group">
                                    <label class="fw-bold">Email</label>
                                    <input type="email" wire:model.live="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email">
                                    @error('email')
                                        <span class="text-danger position-absolute">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold">Password</label>
                                    <input type="password" wire:model.live="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password">
                                    @error('password')
                                        <span class="text-danger position-absolute">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="fw-bold">Masukkan Foto Profil yang baru</label>
                                    <input type="file" wire:model.live="avatar" class="form-control @error('avatar') is-invalid @enderror">
                                    @error('avatar')
                                        <span class="text-danger position-absolute">{{ $message }}</span>
                                    @enderror

                                    @if (is_object($avatar))
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ $avatar->temporaryUrl() }}" alt="" class="img-fluid w-50 rounded-circle mt-2">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button wire:click.prevent="update" class="btn btn-warning">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</div>
