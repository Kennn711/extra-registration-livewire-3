<div class="col-md-12">
    <div class="card shadow">
        <div class="card-header">
            <div class="d-flex justify-content-between aling-items-center">
                <h4 class="card-title">Data Ekstra</h4>
                <button class="btn btn-md btn-success" wire:click="resetCreateForm" data-bs-toggle="modal" data-bs-target="#addExtra">Tambah</button>
            </div>
        </div>
        <div class="card-body">
            <div wire:ignore.self class="modal fade" id="addExtra" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-1">
                            <h5 class="modal-title">
                                <span class="fw-mediumbold">Tambah Ekstra Baru</span>
                            </h5>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row">
                                    @if (is_object($logo))
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ $logo->temporaryUrl() }}" class="img-fluid rounded-circle w-50">
                                        </div>
                                    @endif
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="fw-bold">Nama Ekstra</label>
                                            <input type="text" wire:model.live="name" class="form-control {{ $this->validationClass('name') }}" placeholder="Masukkan nama ekstra">
                                            @error('name')
                                                <span class="text-danger position-absolute">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fw-bold">Hari Ekstra</label>
                                            <select wire:model.live='extra_day' class="form-control {{ $this->validationClass('extra_day') }}">
                                                <option selected disabled>-- Pilih Hari Ekstra --</option>
                                                <option value="Monday">Senin</option>
                                                <option value="Tuesday">Selasa</option>
                                                <option value="Wednesday">Rabu</option>
                                                <option value="Thursday">Kamis</option>
                                                <option value="Friday">Jumat</option>
                                                <option value="Saturday">Sabtu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jam Ekstra</label>
                                            <input type="time" wire:model.live='time' class="form-control {{ $this->validationClass('time') }}">
                                            @error('time')
                                                <span class="text-danger position-absolute">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Deskripsi Extra</label>
                                            <textarea wire:model.live='description' cols="30" rows="5" class="form-control {{ $this->validationClass('description') }}"></textarea>
                                            @error('description')
                                                <span class="text-danger position-absolute">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Pilih Pembina Ekstra</label>
                                            <select wire:model.live="leader_id" class="form-control {{ $this->validationClass('leader_id') }}">
                                                @foreach ($chooseLeader as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Logo Ekstra</label>
                                            <input type="file" wire:model.live='logo' class="form-control">
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
                        <th>Nama Ekstra</th>
                        <th>Nama Pembimbing</th>
                        <th>Hari Extra</th>
                        <th>Jam Extra</th>
                        <th>Deskripsi</th>
                        <th>Logo</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Ekstra</th>
                        <th>Nama Pembimbing</th>
                        <th>Hari Extra</th>
                        <th>Jam Extra</th>
                        <th>Deskripsi</th>
                        <th>Logo</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($data as $see)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $see->name }}</td>
                            <td>{{ $see->leader->name }}</td>
                            <td>{{ $see->extra_day }}</td>
                            <td>{{ $see->time }}</td>
                            <td>{{ $see->description }}</td>
                            <td>
                                <img src="{{ Storage::url($see->logo) }}" alt="" class="img-fluid" width="100">
                            </td>
                            <td>
                                <button wire:click="destroy({{ $see->id }})" class="btn btn-md btn-danger">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    @livewireScripts
    <script>
        Livewire.on('extraStore', () => {
            $('#addExtra').modal('hide');
            $('#editExtra').modal('hide');
        });
    </script>
@endpush
