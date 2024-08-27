<x-main-layout>
    <div class="py-12">
        <div class="container-fluid">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body "style="display: flex; justify-content: space-between; align-items: center; margin-top:20px;">
                                <h5 class="card-title">Ajukan Cuti</h5>
                                <button onclick="window.history.back()" class="btn btn-warning"><i class="bx bx-arrow-back bx-sm"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="p-3 bg-white border-bottom border-gray-200">
                <form action="/ajukancuti/proses/input" method="post">
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
              <input type="text" class="form-control" id="jenis_cuti" placeholder="jenis_cuti" name="jenis_cuti" required>
                @if ($errors->has('jenis_cuti'))
                    <div class="error text-danger">{{ $errors->first('jenis_cuti') }}</div>
                @endif
            </div>
            <div class="mb-3">
                <label for="keterangan">keterangan</label>
                <input type="text" class="form-control" id="keterangan" placeholder="keterangan" name="keterangan" required>
                  @if ($errors->has('keterangan'))
                      <div class="error text-danger">{{ $errors->first('keterangan') }}</div>
                  @endif
              </div>
            <div class="mb-3">
                <label for="jumlah">jumlah</label>
                <input type="number" class="form-control" id="jumlah" placeholder="jumlah" name="jumlah" required>
                  @if ($errors->has('jumlah'))
                      <div class="error text-danger">{{ $errors->first('jumlah') }}</div>
                  @endif
              </div>
              <div class="mb-3">
                <label for="tanggal">tanggal pengajuan</label>
                <input type="date" class="form-control" id="tanggal" placeholder="tanggal" name="tanggal" required>
                  @if ($errors->has('tanggal'))
                      <div class="error text-danger">{{ $errors->first('tanggal') }}</div>
                  @endif
              </div>
            <div class="mb-3">
                <label for="karyawan_pengganti">Karyawan Pengganti</label>
                <select class="form-control custom-select" name="karyawan_pengganti" id="karyawan_pengganti">
                            @foreach($employees as $employee)                                           
                                    <option value="{{ $employee->name }}" data-unit="{{ $employee->id_unit }}">{{ $employee->name }}</option>
                            @endforeach
                </select>
            </div>  
                <button type="submit" name="submit" id="submit"  class="btn btn-success">tes tes</button>
                </form>
            </div>
            </div>
        </div>
    </div>
    
    {{-- @section('js')
    <script>
         document.getElementById('unit').addEventListener('change',function(){
            var unitId =this.value;
            var karyawanPenggantiWrapper = document.getElementById ('karyawan_pengganti_Wrapper')
            var karyawanPenggantiSelect= document.getElementById ('karyawan_pengganti')
            
                if('unitId'){
                    karyawanPenggantiWrapper = 'block';
                    karyawanPenggantiselect.value ='';
                    for(var i = 0;i < karyawanpenggantiselect.options.lenght; i++){
                        var option = karyawanpenggantiselect.options[i];
                        if(option.getAttribute('data-unit')=='unitId'){
                            option.style.display ='block';
                }else{ 
                      option.style.display ='none';
                }
            }
                }else{
                    karyawanpenggantiwrapper.style.display ='none' ;
                    karyawanpenggantiselect.value ='';
                }

         });
    </script>    
    @endsection --}}
    
    
    
</x-main-layout>