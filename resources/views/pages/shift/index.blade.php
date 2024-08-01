<x-main-layout>
    @if (Session::has('success'))
        <div class="alert alert-success" style="margin-bottom: 20px;">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card" style="border-radius:10px;">
                                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom:20px;">
                                    <h5>
                                        <a href="/tambahshift" class="btn btn-success" style="margin-bottom: 1px; margin-left:1px">Tambah Shift</a>
                                    </h5>
                                    <h5 class="card-title" style="margin-right: 20px;">Data Table Shift</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table datatable table-hover table-striped" style="padding-top: 20px;">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No</th>
                                                <th>Id</th>
                                                <th>Shift</th>
                                                <th>Jam</th>
                                                <th>CheckIn Time</th>
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
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Actions
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                                                <li>
                                                                    <a href="/formupdate/{{ $item->id }}" style="font-weight: bold; font-size:16px;" class="dropdown-item">Update</a>
                                                                </li>
                                                                <li>
                                                                    <a href="/shift/delete/{{ $item->id }}" style="font-weight: bold; font-size:16px;" class="dropdown-item">Delete</a>
                                                                </li>
                                                            </ul>
                                                        </div>
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
