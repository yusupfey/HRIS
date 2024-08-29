<x-main-layout>
    <div class="py-12">
        <div class="container-fluid">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body" style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                                <h5 class="card-title">Update Cuti</h5>
                                <button onclick="window.history.back()" class="btn btn-warning"><i class="bx bx-arrow-back bx-sm"></i></button>
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
                               value="{{ Auth::user()->uuid }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="jenis_cuti">Jenis Cuti</label>
                        <input type="text" class="form-control" id="jenis_cuti" name="jenis_cuti" value="{{ $cuti->jenis_cuti }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $cuti->keterangan }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $cuti->jumlah }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal">Tanggal </label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $cuti->tanggal }}" required>

                    </div>

                    <div class="mb-3">
                        <label for="karyawan_pengganti">Karyawan Pengganti</label>
                        <select class="form-control custom-select" name="karyawan_pengganti" id="karyawan_pengganti">
                            @foreach($employees as $employee)
                                <option value="{{ $employee->name }}" data-unit="{{ $employee->id_unit }}" 
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
