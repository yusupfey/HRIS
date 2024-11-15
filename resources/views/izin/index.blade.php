<x-main-layout>
    <div class="py-12">
        <div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                    <h5 class="card-title">Data Izin</h5>
                                    <div class="col-md-4" style="text-align: right;">
                                        <div style="text-align: right;">
                                            <a href="/ajukanizin" class="btn btn-success" style="margin-top: 10px">Ajukan Izin</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive" style="overflow-x: auto;">
                                    <table class="table table-striped table-border table-collapse" style="border:none" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>start time</th>
                                                <th>end time</th>
                                                <th>Alasan</th>
                                                <th>status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-light">
                                            @foreach ($izin as $izin)
                                            <tr>
                                                <td>{{ $izin->name }}</td>
                                                <td>{{ $izin->start_time }}</td>
                                                <td>{{ $izin->end_time }}</td>
                                                <td>{{ $izin->alasan }}</td>
                                                <td><span class=" badge {{ $izin->status == 1   ? "badge bg-success":"bg-danger"}}">
                                                    {{ $izin->status == 1   ? 'Disetujui':'Belum Disetujui'}}    
                                                </span></td>
                                                <td>
                                                    @if($izin->status == 0)
                                                    <a href="/updateizin/{{$izin->id}}" class="btn btn-warning"><i class="tf-icons bx bx-edit"></i></a>
                                                    <button onclick="modalApprove({{$izin->id}}, 'info')" class="btn btn-info"><i class="tf-icons bx bx-info-circle"></i></button>
                                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete({{ $izin->id}})"><i class="tf-icons bx bx-trash"></i></a>
                                                        <form id="delete-form-{{ $izin->id}}" action="/izin/delete/{{ $izin->id }}" method="GET" style="display: none;">
                                                        </form>
                                                        @else
                                                    <button onclick="modalApprove({{$izin->id}}, 'info')" class="btn btn-info"><i class="tf-icons bx bx-info-circle"></i></button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('/jquery-3.7.1.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
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

            modalApprove = function(id, mode = null) {
                dataizin(id, function(response) {
                    let izin = '';
                    $.each(response.izin, function(x, val) {
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
                                    <div style="font-size:13px;">Jam Keluar</div>
                                    <div style="font-size:13px; font-weight:bold">${val.start_time}</div>
                                </div>
                                <div class="col-6">
                                    <div style="font-size:13px;">Jam Kembali</div>
                                    <div style="font-size:13px; font-weight:bold">${val.end_time}</div>
                                </div>
                                <div class="col-6">
                                    <div style="font-size:13px; ">Alasan</div>
                                    <div style="font-size:13px;font-weight:bold">${val.alasan}</div>
                                </div>
                                <div class="col-6">
                                    <div style="font-size:13px; ">Notelp</div>
                                    <div style="font-size:13px;font-weight:bold">${val.notelpon}</div>
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
                        ${izin}
                        <hr/>
                        Persetujuan
                        <hr>
                        ${approve}
                    `);
                });

                $('#modalApprove').modal('show');
                if (mode === 'info') {
                    $('#modalApprove .modal-footer').css('display', 'none');
                } else {
                    $('#modalApprove .modal-footer').css('display', 'block');
                }
            }
            function dataizin(id, callback) {
    $.ajax({
        url: "/approve/data/izin",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'post',
        data: { 'id': id },
        success: function(res) {
            callback(res);
        },
    });
}
       
        });
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
                text: "Cancel Pengajuan Izin",
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
