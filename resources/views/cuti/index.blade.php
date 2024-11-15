<x-main-layout>
    <div class="py-12">
        <div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                    <h5 class="card-title">Table Cuti</h5>
                                    <div class="col-md-4" style="text-align: right;">
                                        <a href="/ajukancuti" class="btn btn-success">Ajukan Cuti</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="section" style="display: none;">{{Request::segment(2)}}</div>
                                    <div class="table-responsive" style="overflow-x: auto;">
                                        <table class="table table-striped table-border table-collapse"id="datatable"style="border:none">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Jenis Cuti</th>
                                                    <th>keterangan</th>
                                                    <th>Jumlah</th>
                                                    <th>Tanggal pengajuan</th>
                                                    <th>Karyawan Pengganti</th>
                                                    <th>approved</th>
                                                    <th>status</th>
                                                    <th>Action</th>
                                                
                                                </tr>
                                            </thead>
                                            <tbody class="table-light">
                                                @foreach ($cuti as $x => $item)
                                                <tr>
                                                    <td>{{ $x + 1 }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->cuti }}</td>
                                                    <td>{{ $item->keterangan }}</td>
                                                    <td>{{ $item->jumlah }}</td>
                                                    <td>{{ $item->tanggal }}</td>
                                                    <td>{{ $item->pengganti_name }}</td>
                                                    <td>{{ $item->approved_pengganti}}</td>
                                                    <td><span class=" badge {{ $item->status == 1   ? "badge bg-success":"bg-danger"}}">
                                                        {{ $item->status == 1   ? 'Disetujui':'belum Disetujui'}}    
                                                    </span></td>
                                                    <td>
                                                        @if ($item->status ==0)    
                                                        <a href="/formupdatee/{{$item->id}}" class="btn btn-warning"><i class="tf-icons bx bx-edit"></i></a>
                                                        <button onclick="modalApprove({{$item->id}}, 'info')"  class="btn btn-info"><i class="tf-icons bx bx-info-circle"></i></button>
                                                        <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete({{ $item->id}})"><i class="tf-icons bx bx-trash"></i></a>
                                                        <form id="delete-form-{{ $item->id}}" action="/cuti/delete/{{ $item->id }}" method="GET" style="display: none;">
                                                        </form>
                                                        @else
                                                        <button onclick="modalApprove({{$item->id}}, 'info')"  class="btn btn-info"><i class="tf-icons bx bx-info-circle"></i></button>
                                                        @endif 
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
                </section>
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
    @section('js')
   <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                pageLength: 10,
                language: {
                    search: "",
                    lengthMenu: "_MENU_",
                    info: "showing _START_ To _END_ Of _TOTAL_ entries",
                    paginate: {
                        next: "next", previous: "previous"
                    }
                }
            });
        });
        
        function modalApprove(id, mode = null) {
            datacuti(id, function(response) {
        let cuti = '';
        $.each(response.cuti, function(x, val) {
            cuti = `
                <input type="hidden" readonly name="id_permohonan" value="${val.id}">
                <input type="hidden" readonly name="jenis_permohonan" value="1">
                <div class="row">
                    <div class="col-6">
                        <div style="font-size:13px;">Name</div>
                        <div style="font-size:13px;font-weight:bold">${val.name}</div>
                    </div>
                    <div class="col-6">
                        <div style="font-size:13px;">Unit</div>
                        <div style="font-size:13px;font-weight:bold">${val.unit}</div>
                    </div>
                    <div class="col-6">
                        <div style="font-size:13px;">Jenis Cuti</div>
                        <div style="font-size:13px;font-weight:bold">${val.val_name}</div>
                    </div>
                    <div class="col-6">
                        <div style="font-size:13px;">Jumlah Cuti</div>
                        <div style="font-size:13px;font-weight:bold">${val.jumlah}</div>
                    </div>
                   <div class="col-6">
                        <div style="font-size:13px;">Pengganti</div>
                        <div style="font-size:13px; font-weight:bold">${val.pengganti_name ?? 'Tanpa Pengganti'}</div>
                    </div>
                    <div class="col-6">
                        <div style="font-size:13px;">keterangan</div>
                        <div style="font-size:13px;font-weight:bold">${val.keterangan}</div>
                    </div>
                    <div class="col-6">
                        <div style="font-size:13px; ">Approve Pengganti</div>
                        <div style="font-size:13px;font-weight:bold">${val.approve_pengganti === undefined ? 'Belum disetujui' : 'Telah disetujui ' + val.approve_pengganti}</div>
                    </div>
                </div>
            `;
        });

        let approve = '<div class="row">';
        $.each(response.approve, function(x, val) {
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
            ${cuti}
            <hr/>
            Persetujuan
            <hr/>
            ${approve}
        `);

        $('#modalApprove').modal('show');

        if (mode === 'info') {
            $('#modalApprove .modal-footer').css('display', 'none');
        } else {
            $('#modalApprove .modal-footer').css('display', 'block');
        }
    });
}

function datacuti(id, callback){
    $.ajax({
        url: "/approve/data/cuti",
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        },
        method: 'post',
        data:{'id':id},
        success:function(res){
            callback(res);
        },
    });
}
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    @endif
    function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Cancel Pengajuan Tukar Shift",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Cancel',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
               
            });
        }
    </script>
    @endsection
</x-main-layout>
