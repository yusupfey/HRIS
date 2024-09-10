<x-main-layout>
    {{-- <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom:20px;">
        <h5 class="card-title" style="margin-right: 20px;">Data Table Karyawan</h5>
        
    </div> --}}
    <div class="card shadow-sm p-4">
        <h3 class="mb-4">Buat Izin Baru</h3>
        @error('error')
        <div class="alert alert-danger">{{ $message }}</div>

        @enderror
        <form id="izinForm" action="{{ route('izin.form') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="starttime" class="form-label">Mulai Jam</label>
                        <input type="time" id="starttime" name="starttime" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="endtime" class="form-label">Sampai Jam</label>
                        <input type="time" id="endtime" name="endtime" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="uuid" class="form-label">UUID</label>
                <input type="text" class="form-control" id="uuid" name="uuid" disabled
                       @if(isset($employee)) value="{{ $employee->uuid }}" @endif>
            </div>

            <div class="mb-3">
                <label for="alasan" class="form-label">Alasan</label>
                <textarea class="form-control" id="alasan" name="alasan" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3">@if(isset($employee)){{ $employee->alamat }}@endif</textarea>
            </div>

            <div class="mb-3">
                <label for="notelp" class="form-label">No Telp</label>
                <input type="text" class="form-control" id="notelp" name="notelp"
                       @if(isset($employee)) value="{{ $employee->no_telp }}" @endif>
            </div>

            <div class="row mb-4">
                {{-- <div id="units-container" class="col-md-6 ">
                    <label for="units" class="form-label">Units</label>
                    <select name="units[]" id="units" class="form-select form-select-sm" multiple aria-label="Pilih Unit">
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->id }}</option>
                        @endforeach
                    </select>
                </div> --}}
                {{-- <div class="col-md-6">
                    <label for="" class="form-label">Unit Names</label>
                    <select name="" id="" class="form-select form-select-sm" multiple aria-label="Pilih Unit" disabled>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label">Kepala Unit</label>
                    <select name="" id="" class="form-select form-select-sm" multiple aria-label="Pilih Unit" disabled>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->kepala_unit }}</option>
                        @endforeach
                    </select>
                </div> --}}
                @foreach ($units as $item)
                <div class="col-md-6">
                    <label for="">{{$item->name}}</label>
                    <select name="persetujuan[]" id="" class="form-control" aria-label="Pilih Unit" >
                            <option value="{{ $item->kepala_unit }}">{{ $item->nama_karyawan }}</option>
                    </select>
                 </div>
                @endforeach

            </div>
            <div class="text-right">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">
                    Buat Izin
                </button>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Buat Izin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin membuat izin dengan data yang telah diisi?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Buat Izin</button>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>

<script>
    function submitForm() {

        // Submit
        document.getElementById('izinForm').submit();
    }
</script>
