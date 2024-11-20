<div class="row mb-3">
    <label class="col-sm-2 col-form-label">Foto Ruangan</label>
    <div class="col-sm-10">
        <div class="row mt-2">
            <div class="col-sm-8 mb-3">
                <div class="custom-file">
                    <input type="file" name="foto[]" id="foto-0" required>
                </div>
            </div>
        </div>

        @foreach ($inputs as $index)
        <div class="row mt-2" wire:key="input-{{ $index }}">
            <div class="col-sm-8 mb-2">
                <div class="custom-file">
                    <input type="file" name="foto[]" id="foto-{{ $index + 1 }}">
                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <div class="d-flex justify-content-start align-items-start">
                    <button type="button" class="btn btn-danger btn-sm" wire:click="removeInput({{ $index }})">Hapus</button>
                </div>
            </div>
        </div>
        @endforeach

        <button type="button" class="btn btn-sm btn-outline-primary mt-1" wire:click="addInput">Tambah Foto</button>
    </div>
</div>