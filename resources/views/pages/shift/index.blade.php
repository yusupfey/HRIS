<x-main-layout>
    <div class="py-12">
        <div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <section class="section" style="margin-top: 1px;">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card" style="border-radius:10px;">
                                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                    <h5 class="card-title" style="margin-right: 20px;">Data Table Shift</h5>
                                    <div class="col-md-4" style="text-align: right;">
                                        <a href="/tambahshift" class="btn btn-success"><i class="bx bx-plus-circle bx-sm"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="section" style="display: none;">{{ Request::segment(2) }}</div>
                                    <div class="table-responsive" style="overflow-x: auto;">
                                        <table class="table table-striped table-border table-collapse" id="datatable" style="border:none">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Shift</th>
                                                    <th>CheckIn Time</th>
                                                    <th>CheckOut Time</th>
                                                    <th>Units</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-light">
                                                @foreach ($shifts as $x => $item)
                                                    <tr>
                                                        <td>{{ $x + 1 }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->checkin_time }}</td>
                                                        <td>{{ $item->checkout_time }}</td>
                                                        <td>{{ $item->unit ? $item->unit->name : 'N/A' }}</td>
                                                        <td>
                                                            <a href="/formupdate/{{ $item->id }}" class="btn btn-warning"><i class="tf-icons bx bx-edit"></i></a>
                                                            <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete({{ $item->id }})"><i class="tf-icons bx bx-trash"></i></a>
                                                            <form id="delete-form-{{ $item->id }}" action="/shift/delete/{{ $item->id }}" method="GET" style="display: none;">
                                                            </form>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />
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

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
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
