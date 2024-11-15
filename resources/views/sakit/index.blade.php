<x-main-layout>
   
    <div class="py-12">
        <div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title">Data Ajukan Sakit</h5>
                                    <div class="col-md-4 text-end">
                                        <a href="/ajukanSakit" class="btn btn-success">Ajukan Sakit</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="section" style="display: none;">{{ Request::segment(2) }}</div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-border" id="datatable">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Tanggal</th>
                                                    <th>Dokumen</th>
                                                    <th>Keterangan</th>
                                                    <th>Days</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-light">
                                                @foreach ($sakit as $x => $sk)
                                                    <tr>
                                                        <td>{{ $x + 1 }}</td>
                                                        <td>{{ $sk->karyawan_name }}</td>
                                                        <td>{{ $sk->tanggal }}</td>
                                                        <td>
                                                            <img src="{{ asset('storage/' . $sk->path) }}" style="max-width: 50px; cursor: pointer;" onclick="viewImage('{{ asset('storage/' . $sk->path) }}')">
                                                        </td>
                                                        <td>{{ $sk->keterangan }}</td>
                                                        <td>{{ $sk->days }}</td>
                                                        <td><span class=" badge {{ $sk->status == 1   ? "badge bg-success":"bg-danger"}}">
                                                            {{ $sk->status == 1   ? 'Disetujui':'Belum Disetujui'}}    
                                                        </span></td>
                                                        <td>
                                                            @if ($sk->status == 0)
                                                                <a href="/update/{{ $sk->id }}" class="btn btn-warning"><i class="tf-icons bx bx-edit"></i></a>
                                                                <button onclick="modalAprove({{ $sk->id }}, 'info')" class="btn btn-info"><i class="tf-icons bx bx-info-circle"></i></button>
                                                                <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete({{ $sk->id }})"><i class="tf-icons bx bx-trash"></i></a>
                                                                <form id="delete-form-{{ $sk->id }}" action="/sakit/delete/{{ $sk->id }}" method="GET" style="display: none;"></form>
                                                             @else 
                                                                <button onclick="modalAprove({{ $sk->id }}, 'info')" class="btn btn-info mt-2"><i class="tf-icons bx bx-info-circle"></i></button> 
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

    <!-- Modal for Approval -->
    <div class="modal fade" id="modalAprove" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
<!-- Modal photo -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">View Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body d-flex justify-content-center align-items-center" style="height: 500px;"> 
                <img id="modalImage" src="" alt="Image" class="img-fluid" style="width: 1000px; height: 500px;">
            </div>
        </div>
    </div>
</div>


    @section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                         next: "next", previous: "previously"
                    }
                } 
            });
        });;
         function viewImage(imageUrl) {

        document.getElementById('modalImage').src = imageUrl;

       
        $('#imageModal').modal('show');
    }
        
        function modalAprove(id, mode = null) {
            datasakit(id, function(response) {
                let sakitDetails = '';
                $.each(response.sakit, function(x, val) {
                    sakitDetails = `
                        <input type="hidden" readonly name="id_permohonan" value="${val.id}">
                        <input type="hidden" readonly name="jenis_permohonan" value="4">
                        <div class="row">
                            <div class="col-6">
                                <div style="font-size:13px;">name</div>
                                <div style="font-size:13px;font-weight:bold">${val.karyawan_name}</div>
                            </div>
                             <div class="col-6">
                                <div style="font-size:13px;">unit</div>
                                <div style="font-size:13px;font-weight:bold">${val.unit_name}</div>
                            </div>
                            <div class="col-6">
                                <div style="font-size:13px;">tanggal</div>
                                <div style="font-size:13px;font-weight:bold">${val.tanggal}</div>
                            </div>
                            <div class="col-6">
                                <div style="font-size:13px;">Dokumen:</div>
                                <img src="{{asset('storage/')}}/${val.path}" style="max-width: 50px; cursor: pointer;">
                            </div>
                            <div class="col-6">
                                <div style="font-size:13px;">Keterangan</div> 
                                <div style="font-size:13px;font-weight:bold">${val.keterangan}</div>
                            </div>
                            <div class="col-6">
                                <div style="font-size:13px;">Days</div> 
                                <div style="font-size:13px;font-weight:bold">${val.days}</div>
                            </div>
                        </div>
                    `;
                });

                let approveDetails = '<div class="row">';
                $.each(response.approve, function(x, val) {
                    approveDetails += `
                            <div class="col-4">
                                <div style="font-size:13px; font-weight:bold">${val.name}</div>
                                <div style="font-size:10px;font-weight:bold">${val.unit}</div>
                                <div style="font-size:13px;font-weight:bold">${val.approve_date === null ? 'Belum disetujui' : val.approve === 1 ? 'Telah disetujui ' + val.approve_date : '<div class="badge bg-danger">Tidak disetujui</div>'}</div>
                            </div>
                    `;
                });
                approveDetails += '</div>';

                $('#modalAprove .modal-body').html(sakitDetails + "<hr/> Persetujuan <hr>" + approveDetails);
                $('#modalAprove').modal('show');
                $('#modalAprove .modal-footer').toggle(mode !== 'info');
            });
        }

        // function viewImage(path) {
        //     Swal.fire({
        //         imageUrl: path,
        //         imageAlt: 'Dokumen',
        //         showCloseButton: true,
        //         showConfirmButton: false,
        //         width: 'auto',
        //         height:'auto'
               
        //     });
        // }

        function datasakit(id, callback) {
            $.ajax({
                url: "/approve/data/sakit",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { 'id': id },
                success: function(res) { callback(res); }
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
                confirmButtonText: 'Delete',
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
