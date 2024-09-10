<x-main-layout>
    <div class="py-12">
        <div class="container-fluid">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body "style="display: flex; justify-content: space-between; align-items: center; margin-top:20px;">
                                <h5 class="card-title">Ajukan Cuti</h5>
                                <button onclick="window.history.back()" class="btn btn-warning">Back</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="p-3 bg-white border-bottom border-gray-200">
                <form id="cutiForm" action="{{ route('cuti.store') }}" method="POST">

                    @csrf
                    <div class="mb-3">
                        <label for="uuid_karyawan" >Nama</label>
                        <input type="text" class="form-control" id="uuid_karyawan" name="uuid_karyawan" 
                               value="{{ Auth::user()->uuid}}" readonly>
                        @if ($errors->has('uuid_karyawan'))
                            <div class="error text-danger">{{ $errors->first('uuid_karyawan') }}</div>
                        @endif
                    </div>
                    
            <div class="mb-3">
              <label for="jenis_cuti">jenis cuti</label>
              <select name="jenis_cuti" id="jenis_cuti" class="form-control">
                <option value=""disabled>Pilih Jenis Cuti</option>
                @foreach($reference as $rf)
                    <option value="{{ $rf->id }}">{{ $rf->reference }}</option>
                @endforeach
            </select>
            </div>
            <div class="mb-3">
                <label for="keterangan">keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                  @if ($errors->has('keterangan'))
                      <div class="error text-danger">{{ $errors->first('keterangan') }}</div>
                  @endif
              </div>
            <div class="mb-3">
                <label for="jumlah">jumlah Cuti</label>
                <input type="number" class="form-control" id="jumlah" placeholder="jumlah" name="jumlah" required>
                  @if ($errors->has('jumlah'))
                      <div class="error text-danger">{{ $errors->first('jumlah') }}</div>
                  @endif
            </div>
              <div class="row mb-3">
                  <div class="col-md-4">
                      <label for="">tanggal Cuti</label>
                      <input type="date" name="tanggal_cuti[]" class="form-control" aria-label="Pilih Unit">
                    </div>
                    <div class="col-md-4">
                        <label for="">tanggal Cuti</label>
                        <input type="date" name="tanggal_cuti[]" class="form-control" aria-label="Pilih Unit">
                    </div>
                      <div class="col-md-4">
                        <label for="">tanggal Cuti</label>
                        <input type="date" name="tanggal_cuti[]" class="form-control" aria-label="Pilih Unit">
                      </div>
              </div>
              
                <div class="mb-3">
                    <label for="tanggal">tanggal pengajuan</label>
                    <input type="date" class="form-control" id="tanggal" placeholder="tanggal" name="tanggal" required>
                    @if ($errors->has('tanggal'))
                      <div class="error text-danger">{{ $errors->first('tanggal') }}</div>
                    @endif
                </div>
            <div class="mb-3">
                    <label for="karyawan_pengganti">Pilih Karyawan Pengganti:</label>
                <select name="karyawan_pengganti" id="karyawan_pengganti" class="form-control">
                    <option value=""disabled>Pilih Karyawan Pengganti</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->uuid}}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>
            
            @foreach ($units as $item)
    <div class="col-md-6">
            <label for="">{{ $item->name }}</label>
        <select name="persetujuan[]" class="form-control" aria-label="Pilih Unit">
            <option value="{{ $item->kepala_unit }}">{{ $item->nama_karyawan }}</option>
        </select>
    </div>
@endforeach
 <button type="submit" name="submit" id="submit"  class="btn btn-success">submit</button>
                </form>
            </div>
            </div>
        </div>
    </div>
    
    
</x-main-layout>
<script>
    function submitForm() {

        // Submit
        document.getElementById('cutiForm').submit();
    }
</script>