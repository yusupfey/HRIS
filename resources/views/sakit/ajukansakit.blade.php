<x-main-layout>
    <div class="py-12">
        <div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                    <h5 class="card-title">Data Tukar Shift</h5>
                                    <div class="col-md-4" style="text-align: right;">
                                        <button onclick="window.location='{{ route('sakit.index') }}'" class="btn btn-warning">Back</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('sakit.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3" hidden>
                                            <label for="uuid_karyawan" >Nama</label>
                                            <input type="text" class="form-control" id="uuid_karyawan" name="uuid_karyawan" 
                                                   value="{{ Auth::user()->uuid}}" readonly>
                                            @if ($errors->has('uuid_karyawan'))
                                                <div class="error text-danger">{{ $errors->first('uuid_karyawan') }}</div>
                                            @endif
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tanggal" class="form-label">Tanggal Awal</label>
                                                    <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="path" class="form-label">Upload File</label>
                                                    <input type="file" id="path" name="path" class="form-control" required>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="keterangan" class="form-label">Keterangan</label>
                                            <input class="form-control" id="keterangan" name="keterangan" required>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="days" class="form-label">Days</label>
                                                    <input class="form-control" id="days" name="days" placeholder="Total Hari" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                @foreach ($units as $item)
                                                    <div class="col-md-6">
                                                            <label for="">{{ $item->name }}</label>
                                                        <select name="persetujuan[]" class="form-control" aria-label="Pilih Unit">
                                                            <option value="{{ $item->kepala_unit }}">{{ $item->nama_karyawan }}</option>
                                                        </select>
                                                    </div>
                                                @endforeach
                                                {{-- @foreach ($units as $val)
                                                <div class="form-group">
                                                    <label for="persetujuan{{ $val->id }}">{{ $val->name }}</label>
                                                    <select name="persetujuan[]" id="persetujuan{{ $val->id }}" class="form-control" required>
                                                        @foreach ($units as $item)
                                                            @if ($val->id == $item->id_unit)
                                                                <option value="{{ $item->uuid_pj }}">{{ $item->nama_karyawan }}</option>
                                                            @endif
                                                         @endforeach
                                                    </select>
                                                </div>
                                                @endforeach --}}
                                            </div>
                                        </div>
                                            <button type="submit" class="btn btn-success" style="margin-top: 5px">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-main-layout>
