<x-main-layout>
    <div class="py-12" >
        <div >
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <section class="section" style="margin-top: 1px;">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card" style="border-radius:10px;">
                                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                    <h5 class="card-title" style="margin-right: 20px;">Jadwal karyawan</h5>
                                    
                                </div>
                                <div class="card-body">
                                    <div id="section" style="display: none;">{{Request::segment(2)}}</div>
                                     <div class="table-responsive" style="overflow-x: auto;">
                                         <table class="table table-striped table-border table-collapse " id="datatable" style="border:none;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Unit</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-light">
                                                @foreach ($worksheadules as $x => $item)
                                                    <tr>
                                                        <td>{{ $x + 1 }}</td>
                                                        <td>{{ $item->name}}</td>
                                                        <td>{{ $item->Unit}}</td>
                                                        <td>
                                                            <a href="/pilihjamkerja/{{$item->uuid}}" class="btn btn-success"><i class="bx bx-plus-circle"></i></a>
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
    @section('js')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
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
                         next: "next", previous: "previously"
                    }
                }
        //         initComplete: function() {
        //     $('#datatable_length').addClass('d-inline-block').css({
        //         float: 'left',
        //         'margin-right':'790px'
        //     });
        //     $('#datatable_filter').addClass('d-inline-block').css({
        //         float: 'left'
        //     });
        // }
                
            });
            @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
        @endif
        });
    </script>
    @endsection
</x-main-layout>
