<x-main-layout>
    @push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.min.css">
@endpush
    @if (Session::has('success'))
        <div class="alert alert-success" style="margin-bottom: 20px;">
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="py-12" >
        <div >
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
                                    <div id="section" style="display: none;">{{Request::segment(2)}}</div>
                                    <table class="table datatable table-hover table-striped" id="datatable"style="padding-top: 20px;">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No</th>
                                                <th>Id</th>
                                                <th>Shift</th>
                                                <th>Jam</th>
                                                <th>CheckIn Time</th>
                                                <th>ChekOut Time</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-light">
                                            @foreach ($shift as $x => $item)
                                                <tr>
                                                    <td>{{ $x + 1 }}</td>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->jam }}</td>
                                                    <td>{{ $item->checkin_time }}</td>
                                                    <td>{{$item->checkout_time}}</td>
                                                    <td> 
                                                        <a href="/formupdate/{{ $item->id }}"class="btn btn-warning"><i class="tf-icons bx bx-edit"></i></a>
                                                        <a href="/shift/delete/{{ $item->id }}"class="btn btn-danger"><i class="tf-icons bx bx-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    
</x-main-layout>
