<x-main-layout>
    {{-- @push('css')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

@endpush
    @if (Session::has('success'))
        <div class="alert alert-success" style="margin-bottom: 20px;">
            {{ Session::get('success') }}
        </div>
    @endif --}}
    {{-- <div class="py-12" > --}}
            {{-- <div class="card"> --}}
                <div class=" accordion accordion-flush " id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-controls="collapseOne" style="font-size: 16px; font-weight: bold; margin-left:5px;font-family:'Times New Roman', Times, serif">
                                Cuti
                            </button>
                        </h2>
                        
                      <div id="collapseOne" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div id="section table-responsive" style="display: none;">{{Request::segment(2)}}</div>
                            <div class="table-responsive" style="overflow-x: auto;">
                                <table id="cuti"class="table   table-bordered table-hover table-striped" id="datatable"style="padding-top: 20px;">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>id_permohonan</th>
                                            <th>Permohonan</th>
                                            <th>Nama</th>
                                            <th>Unit</th>

                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-light">
                                        @foreach ($data['cuti'] as $x => $item)
                                            <tr>
                                                <td>{{ $x + 1 }}</td>
                                                <td>{{$item->id_permohonan}}</td>
                                                <td>{{$item->val_name}}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->unit }}</td>

                                                <td> 
                                                    <button onclick="modalApprove({{$item->id_permohonan}},{{$item->jenis_permohonan}})" class="btn btn-primary"><i class="tf-icons bx bxs-calendar-check"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                            </table>
                        </div>
                        </div>
                      </div>
                      
                    </div>
                </div>
                  <div class="accordion accordion-flush"id="accordion" style="margin-top: 5px">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="font-size: 16px; font-weight: bold; margin-left:5px;font-family:'Times New Roman', Times, serif">
                            Izin
                          </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion">
                          <div class="accordion-body">
                              <div id="section table-responsive" style="display: none;">{{Request::segment(2)}}</div>
                              <div class="table-responsive" style="overflow-x: auto;">
                              <table id="izin" class="table  table-bordered table-hover table-striped" id="datatable"style="padding-top: 20px;">
                                  <thead class="table-primary">
                                      <tr>
                                          <th>No</th>
                                          <th>Id_permohonan</th>
                                          <th>Permohonan</th>
                                          <th>Nama</th>
                                          <th>Unit</th>

                                          <th>#</th>
                                      </tr>
                                  </thead>
                                  <tbody class="table-light">
                                      @foreach ($data['izin'] as $x => $item)
                                          <tr>
                                              <td>{{ $x + 1 }}</td>
                                              <td>{{$item->id_permohonan}}</td>
                                              <td>{{$item->val_name}}</td>
                                              <td>{{ $item->name }}</td>
                                              <td>{{ $item->unit }}</td>

                                              <td> 
                                                  <button onclick="modalApprove({{$item->id_permohonan}}, {{$item->jenis_permohonan}})" class="btn btn-primary"><i class="tf-icons bx bxs-calendar-check"></i></a>
                                              </td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                          </table>
                        </div>
                          </div>
                        </div>
                      </div>
                  </div>

                  <div class="accordion accordion-flush" id="cordion" style="padding-top: 5px;">

                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"  style="font-size: 16px; font-weight: bold; margin-left:5px;font-family:'Times New Roman', Times, serif">
                            Tukar Shift
                          </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#cordion">
                          <div class="accordion-body">
                              <div id="section table-responsive" style="display: none;">{{Request::segment(2)}}</div>
                              <div class="table-responsive" style="overflow-x: auto;">
                              <table id="ubahjadwal" class="table  table-bordered table-hover table-striped"style="padding-top: 20px;" id="datatable">
                                  <thead class="table-primary">
                                      <tr>
                                          <th>No</th>
                                          <th>id_permohonan</th>
                                          <th>Permohonan</th>
                                          <th>name</th>
                                          <th>Unit</th>
                                          <th>#</th>
                                      </tr>
                                  </thead>
                                  <tbody class="table-light">
                                      @foreach ($data['ubahjadwal'] as $x => $item)
                                          <tr>
                                              <td>{{ $x + 1 }}</td>
                                              <td>{{$item->id_permohonan}}</td>
                                              <td>{{$item->val_name}}</td>
                                              <td>{{$item->pemohon_name}}</td>
                                              <td>{{$item->unit}}</td>

      
                                              <td> 
                                                  <button onclick="modalApprove({{$item->id_permohonan}}, {{$item->jenis_permohonan}})" class="btn btn-primary"><i class="tf-icons bx bxs-calendar-check"></i></a>
                                              </td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                          </table>
                              </div>
                          </div>
                        </div>
                      </div>
                  </div>

                  <div class="accordion accordion-flush" id="acordions" style="padding-top: 5px;">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="sakit">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesakit" aria-expanded="false" aria-controls="collapsesakit" style="font-size: 16px; font-weight: bold; margin-left:5px;font-family:'Times New Roman', Times, serif">
                            Sakit
                          </button>
                        </h2>
                        <div id="collapsesakit" class="accordion-collapse collapse" aria-labelledby="sakit" data-bs-parent="#acordions">
                          <div class="accordion-body">
                            <div id="section table-responsive" style="display: none;">{{Request::segment(2)}}</div>
                            <div class="table-responsive" style="overflow-x: auto;">
                              <table id="sakit" class="table  table-bordered table-hover table-striped"style="padding-top: 20px;" id="datatable">
                                  <thead class="table-primary">
                                      <tr>
                                          <th>No</th>
                                          <th>id_permohonan</th>
                                          <th>Permohonan</th>
                                          <th>Nama</th>
                                          <th>Unit</th>
                                          <th>#</th>
                                      </tr>
                                  </thead>
                                  <tbody class="table-light">
                                      @foreach ($data['sakit'] as $x => $item)
                                          <tr>
                                              <td>{{ $x + 1 }}</td>
                                              <td>{{$item->id_permohonan}}</td>
                                              <td>{{$item->val_name}}</td>
                                              <td>{{$item->karyawan_name}}</td>
                                              <td>{{$item->unit}}</td>

                                              <td> 
                                                  <button onclick="modalApprove({{$item->id_permohonan}}, {{$item->jenis_permohonan}})" class="btn btn-primary"><i class="tf-icons bx bxs-calendar-check"></i></a>
                                              </td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                          </table>
                            </div>
                          </div>
                          </div>
                        </div>
                      </div>
                  </div>

            </div>
        </div>
        <div>
            
        </div>
        
    </div>
     <div class="card" style="border-radius:10px;margin-top:5px">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h5 class="card-title" style="margin-right: 16px;">History</h5>
        </div>
        <div class="card-body table-responsive">
            <div id="section" style="display: none;">{{Request::segment(2)}}</div>
            <div class="table-responsive" style="overflow-x: auto;">
            <table class="table table-hover table-striped" id="datatable"style="padding-top: 20px;">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>id_permohonan</th>
                        <th>Permohonan</th>
                        <th>Nama</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    @foreach ($data1['history'] as $x => $item)
                        <tr>
                            <td>{{ $x + 1 }}</td>
                            <td>{{$item->id_permohonan}}</td>
                            <td>{!! '<b>' . ($item->jenis_permohonan ?? '') . '</b>' !!}
                            </td>
                             
                            <td>{{ $item->karyawan_name ?? $item->cuti_karyawan_name ?? $item->ubahjadwal_karyawan_name ?? $item->izin_karyawan_name ?? $item->sakit_karyawan_name }}</td>
                            
                            <td> 
                                <button onclick="modalApprove({{$item->id_permohonan}}, {{$item->jenis_permohonan}}, 'info')" class="btn btn-info"><i class="tf-icons bx bxs-calendar-check"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div> 
           
    
<div class="modal fade" id="modalApprove" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Persetujuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only"></span>
                  </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="submit('approved')">Approve</button>
            <button type="button" class="btn btn-danger" onclick="submit('reject')">Reject</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Persetujuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only"></span>
                  </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="submit('approved')">Approve</button>
            <button type="button" class="btn btn-danger" onclick="submit('reject')">Reject</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">View Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body d-flex justify-content-center align-items-center" style="height: 500px;">
                <img id="modalImage" src="" alt="Image" class="img" style="width: 100%;height: 100%;">
            </div>
        </div>
    </div>
</div>
@section('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        {{-- <script src="{{asset('/jquery-3.7.1.min.js')}}"></script> --}}
        <script>
            $(document).ready(function() {
          $('#datatable').DataTable({
              pageLength: 10,
              language: {
                  search: "",
                  lengthMenu: "_MENU_",
                  info: "showing _START_ to _END_ of _TOTAL_ entries",
                  paginate: {
                      next: "Next",
                      previous: "Previous"
                  }
              }
          });
    
      });
            function viewImage(imageUrl) {
                document.getElementById('modalImage').src = imageUrl;
                $('#imageModal').modal('show');
            }
    // function viewImage(path) {
    //     Swal.fire({
    //         imageUrl: path,
    //         imageAlt: 'Dokumen',
    //         showCloseButton: true,
    //         showConfirmButton: false,
    //         width: 'auto'
    //     });
    // }



            function modalApprove(id, type, mode=null) {
               
                switch (type) {
                    case 1://cuti
                        data(id,'cuti', function(response){
                            let cuti = '';
                            $.each(response.cuti, function(x, val){
                            console.log(val);

                                cuti = `
                                    <input type="hidden" readonly name="id_permohonan" value="${val.id}">
                                    <input type="hidden" readonly name="jenis_permohonan" value="1">
                                    <div class="row">
                                        <div class="col-6">
                                            <div style="font-size:13px; ">Name</div>
                                            <div style="font-size:13px;font-weight:bold">${val.name}</div>
                                        </div>
                                         <div class="col-6">
                                            <div style="font-size:13px;">Unit</div>
                                            <div style="font-size:13px;  font-weight:bold">${val.unit}</div>
                                        </div>
                                        <div class="col-6">
                                            <div style="font-size:13px; ">Jenis Cuti</div>
                                            <div style="font-size:13px;font-weight:bold">${val.val_name}</div>
                                        </div>
                                        
                                        <div class="col-6">
                                            <div style="font-size:13px; ">Jumlah Cuti</div>
                                            <div style="font-size:13px;font-weight:bold">${val.jumlah}</div>
                                        </div>
                                        
                                       <div class="col-6">
                                            <div style="font-size:13px;">Pengganti</div>
                                            <div style="font-size:13px; font-weight:bold">
                                                ${val.pengganti_name ?? 'Tanpa Pengganti'}
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div style="font-size:13px; ">Keterangan</div>
                                            <div style="font-size:13px;font-weight:bold">${val.keterangan}</div>
                                        </div>
                                        <div class="col-6">
                                            <div style="font-size:13px; ">Approve Pengganti</div>
                                            <div style="font-size:13px;font-weight:bold">${val.approve_pengganti === undefined ? 'Belum disetujui': 'Telah disetujui'+val.approve_pengganti}</div>
                                        </div>
                                    </div>
                                `;
                            })
                            let approve='<div class="row">';
                            $.each(response.approve, function(x, val){

                                approve += `
                                        <div class="col-4">
                                            <div style="font-size:13px; font-weight:bold">${val.name}</div>
                                            <div style="font-size:13px;font-weight:bold">${val.unit}</div>
                                             <div style="font-size:13px;font-weight:bold">${val.approve_date === null ? 'Belum disetujui' : val.approve === 1 ? 'Telah disetujui ' + val.approve_date : '<div class="badge bg-danger">Tidak disetujui</div>'}</div>
                                        </div>
                                    
                                `;
                            })
                            approve +='</div>';
                            $('#modalApprove .modal-body').html(`
                                ${cuti}
                                <hr/>
                                Persetujuan
                                <hr>
                                ${approve}
                            `)
                        })
                        break;
                        case 3:
                            data(id, 'izin', function(res){
                                let izin = '';
                                    $.each(res.izin, function(x, val){
                                        izin = `
                                            <input type="hidden" readonly name="id_permohonan" value="${val.id}">
                                            <input type="hidden" readonly name="jenis_permohonan" value="3">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div style="font-size:13px; ">Name</div>
                                                    <div style="font-size:13px;font-weight:bold">${val.name}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div style="font-size:13px; ">Unit</div>
                                                    <div style="font-size:13px;font-weight:bold">${val.unit}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div style="font-size:13px;">Dari</div>
                                                    <div style="font-size:13px;font-weight:bold">${val.start_time}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div style="font-size:13px; ">Sampai</div>
                                                    <div style="font-size:13px;font-weight:bold">${val.end_time}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div style="font-size:13px;">Alasan</div>
                                                    <div style="font-size:13px; font-weight:bold">${val.alasan}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div style="font-size:13px;">NoTelp</div>
                                                    <div style="font-size:13px;font-weight:bold;" >${val.notelpon}</div>
                                                </div>
                                                
                                            </div>
                                        `;
                                    })
                                    let approve='<div class="row">';
                                    $.each(res.approve, function(x, val){
                                        approve += `
                                                <div class="col-4">
                                                    <div style="font-size:13px; font-weight:bold">${val.name}</div>
                                                    <div style="font-size:10px;font-weight:bold">${val.unit}</div>
                                                     <div style="font-size:13px;font-weight:bold">${val.approve_date === null ? 'Belum disetujui' : val.approve === 1 ? 'Telah disetujui ' + val.approve_date : '<div class="badge bg-danger">Tidak disetujui</div>'}</div>
                                                </div>
                                            
                                        `;
                                    })
                                    approve +='</div>';
                                    $('#modalApprove .modal-body').html(`
                                        ${izin}
                                        <hr/>
                                        Persetujuan
                                        <hr>
                                        ${approve}
                                    `)
                            })
                        break;
                        case 2:
                            data(id, 'ubahjadwal', function(response){
                                let ubahjadwal = '';
                                $.each(response.ubahjadwal, function(x, val){
                                    console.log(val);

                                    ubahjadwal = `
                                        <input type="hidden" readonly name="id_permohonan" value="${val.id}">
                                        <input type="hidden" readonly name="jenis_permohonan" value="2">
                                        <div class="row">
                                            <div class="col-6">
                                                <div style="font-size:13px;">Nama Pemohon</div>
                                                <div style="font-size:13px;font-weight:bold">${val.name}</div>
                                            </div>
                                            <div class="col-6">
                                                <div style="font-size:13px;">Unit</div>
                                                <div style="font-size:13px;font-weight:bold">${val.unit}</div>
                                            </div>
                                             <div class="col-6">
                                                <div style="font-size:13px;">Shift Awal</div>
                                                <div style="font-size:13px;font-weight:bold">${val.shift_name}</div>
                                            </div>
                                            <div class="col-6">
                                                <div style="font-size:13px;">Shift Pengganti</div>
                                                <div style="font-size:13px;font-weight:bold">${val.shift_names}</div>
                                            </div>
                                            <div class="col-6">
                                                <div style="font-size:13px;">Tanggal Perubahan</div>
                                                <div style="font-size:13px;font-weight:bold">${val.tanggal_perubahan}</div>
                                            </div>
                                            <div class="col-6">
                                                <div style="font-size:13px; ">Pengganti</div>
                                                <div style="font-size:13px;font-weight:bold">${val.pengganti}</div>
                                            </div>
                                            <div class="col-6">
                                                <div style="font-size:13px; ">Status Persetujuan</div>
                                                <div style="font-size:13px;font-weight:bold">${val.approved_pengganti === undefined ? 'Belum disetujui' : 'Telah disetujui ' + val.approve_status}</div>
                                            </div>
                                        </div>
                                    `;
                                });
                                
                                let approve = '<div class="row">';
                                $.each(response.approve, function(x, val){
                                    approve += `
                                        <div class="col-4">
                                            <div style="font-size:13px; font-weight:bold">${val.name}</div>
                                            <div style="font-size:10px;font-weight:bold">${val.unit}</div>
                                             <div style="font-size:13px;font-weight:bold">${val.approve_date === null ? 'Belum disetujui' : val.approve === 1 ? 'Telah disetujui ' + val.approve_date : '<div class="badge bg-danger">Tidak disetujui</div>'}</div>
                                        </div>
                                    `;
                                });
                                approve += '</div>';

                                $('#modalApprove .modal-body').html(`
                                    ${ubahjadwal}
                                    <hr/>
                                    Persetujuan
                                    <hr>
                                    ${approve}
                                `);
                            });
                            break;
                            case 4:
                            data(id, 'sakit', function(response){
                                let sakit = '';
                                $.each(response.sakit, function(x, val){
                                    console.log(val);

                                    sakit = `
                                        <input type="hidden" readonly name="id_permohonan" value="${val.id}">
                                        <input type="hidden" readonly name="jenis_permohonan" value="4">
                                        <div class="row">
                                             <div class="col-6">
                                                <div style="font-size:13px;">Nama</div>
                                                <div style="font-size:13px;font-weight:bold">${val.karyawan_name}</div>
                                            </div>
                                             <div class="col-6">
                                                <div style="font-size:13px;">Unit</div>
                                                <div style="font-size:13px;font-weight:bold">${val.unit_name}</div>
                                            </div>
                                           
                                            <div class="col-6">
                                                <div style="font-size:13px;">tanggal</div>
                                                <div style="font-size:13px;font-weight:bold">${val.tanggal}</div>
                                            </div>
                                           
                                            <div class="col-6">
                                                <div style="font-size:13px;">keterangan</div>
                                                <div style="font-size:13px;font-weight:bold">${val.keterangan}</div>
                                            </div>
                                            <div class="col-6">
                                                <div style="font-size:13px; ">Hari</div>
                                                <div style="font-size:13px;font-weight:bold">${val.days}</div>
                                            </div>
                                             <div class="col-6">
                                                <div style="font-size:13px;">Dokument:</div>
                                                <img src="{{ asset('storage') }}/${val.path}" style="max-width: 80px; cursor: pointer;" onclick="viewImage('{{ asset('storage') }}/${val.path}')">
                                            </div>
                                        </div>
                                    `;
                                });
                                
                                let approve = '<div class="row">';
                                $.each(response.approve, function(x, val){
                                    approve += `
                                        <div class="col-4">
                                            <div style="font-size:13px; font-weight:bold">${val.name}</div>
                                            <div style="font-size:10px;font-weight:bold">${val.unit}</div>
                                             <div style="font-size:13px;font-weight:bold">${val.approve_date === null ? 'Belum disetujui' : val.approve === 1 ? 'Telah disetujui ' + val.approve_date : '<div class="badge bg-danger">Tidak disetujui</div>'}</div>
                                        </div>
                                    `;
                                });
                                approve += '</div>';

                                $('#modalApprove .modal-body').html(`
                                    ${sakit}
                                    <hr/>
                                    Persetujuan
                                    <hr>
                                    ${approve}
                                `);
                            });
                            break;

                    default:
                        break;
                }
                $('#modalApprove').modal('show')
                if(mode==='info'){
                    $('#modalApprove .modal-footer').css('display', 'none')

                }else{
                    $('#modalApprove .modal-footer').css('display', 'block')

                }
                function viewImage(path) {
            Swal.fire({
                imageUrl: path,
                imageAlt: 'Dokumen',
                showCloseButton: true,
                showConfirmButton: false,
                width: '100%',
                height:'100%'
                
            });
            @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    @endif
        }

            }
            function data(id,type, callback){
                $.ajax({
                    url: "/approve/data/"+type,
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    
                    },
                    method: 'post',
                    data:{'id':id},
                    success:function(res){
                        console.log(res);
                        callback(res)
                    },
                })
            }
            function submit(answer) {
                $.ajax({
                    url: "/approve/store/"+answer,
                    method: 'post',
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    
                    },
                    data:{
                        id_permohonan:$('input[name="id_permohonan"]').val(),
                        jenis_permohonan:$('input[name="jenis_permohonan"]').val(),
                    },
                    success:function(res){
                        console.log(res)
                        if(res.metadata.code==200){
                            window.location.href = '/approve';
                        }
                        // valdiateReset(data);
                    },
                    error:function(res){
                        console.log(res)

                        validateError(data,res.responseJSON)
                    }
                })

            }
            function valdiateReset(data){
                $.each(data,function(x,v){
                    $(`#${v.name}`).html('');
                })
            }
            function validateError(data, response){
                console.log(data,response.errors)
                valdiateReset(data);
                $.each(data,function(x,v){
                    console.log(v.name)
                    $(`#${v.name}`).html();


                    $.each(Object.keys(response.errors),function(x,resval){
                        if(v.name === resval){
                            let result = response.errors[resval];
                            $(`#${v.name}`).html('<i class="text-danger">'+result+'</i>');
                        }
                    })

                })

            
            }

            
        </script>
    @endsection
</x-main-layout>
