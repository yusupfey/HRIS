<x-main-layout>
    <div class="py-12">
        <div class="container-fluid">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body" style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                                <h5 class="card-title">Update Cuti</h5>
                                <button onclick="window.history.back()" class="btn btn-warning">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 bg-white border-bottom border-gray-200">
                <form action="{{ route('cuti.update', ['id' => $cuti->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="uuid_karyawan">Nama</label>
                        <input type="text" class="form-control" id="uuid_karyawan" name="uuid_karyawan" 
                        value="{{ Auth::user()->name}}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="jenis_cuti">Jenis Cuti</label>
                        <select name="jenis_cuti" id="jenis_cuti" class="form-control" required>
                            <option value="" disabled>Pilih Jenis Cuti</option>
                            @foreach($reference as $rf)
                                <option value="{{ $rf->val }}" 
                                    {{ $cuti->jenis_cuti == $rf->val ? 'selected' : '' }}>
                                    {{ $rf->val_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $cuti->jumlah }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $cuti->keterangan }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal">Tanggal pengajuan </label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $cuti->tanggal }}" required>

                    </div>
                  
                    <div class="row mb-3">
                        @foreach($d_cuti as $index => $cuti_detail)
                            <div class="col-md-4">
                                <label for="tanggal_cuti{{ $index }}">Tanggal Cuti:</label>
                                <input type="date" id="tanggal_cuti" name="tanggal_cuti[{{ $cuti_detail->id }}]" value="{{ old('tanggal_cuti.'.$index, $cuti_detail->tanggal_cuti) }}" class="form-control" aria-label="Pilih Tanggal Cuti">
                            </div>
                        @endforeach
                        @if(count($d_cuti) < 3)
                            @for($i = count($d_cuti); $i < 3; $i++)
                            <div class="col-md-4">
                                <label for="tanggal_cuti{{ $i }}">Tanggal Cuti</label>
                                <input type="date" name="tanggal_cuti[]" class="form-control" aria-label="Pilih Tanggal Cuti">
                    </div>
                            @endfor
                        @endif
                    </div>

                    

                    <div class="mb-3">
                        <label for="karyawan_pengganti">Karyawan Pengganti</label>
                        <select class="form-control custom-select" name="karyawan_pengganti" id="karyawan_pengganti">
                            @foreach($employees as $employee)
                                <option value="{{ $employee->uuid }}" data-unit="{{ $employee->id_unit }}" 
                                    {{ $employee->name == $cuti->karyawan_pengganti ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-main-layout>
