<x-main-layout>
    @if (Session::has('success'))
        <div class="alert alert-success" style="margin-bottom: 20px;">{{Session::get('success')}}</div>
    @endif

    <div class="card" style="border-radius:10px;">
        <div class="card-header">
            <h5>
                <a href="/tambahshift" class="btn btn-success" style="margin-bottom: 1px;">Tambah Shift</a>
            </h5>
        </div>
        <div class="card-body">
            <table class="table datatable">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Id</th>
                        <th>Shift</th>
                        <th>Jam</th>
                        <th>CheckIn Time </th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    @foreach ($shift as $x => $item)
                    <tr>
                        <td>{{ $x +1}}</td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->jam }}</td>
                        <td>{{$item->checkin_time}}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                    <li>
                                        <a href="/formupdate/{{ $item->id }}"style="margin-right: 5px;" class="dropdown-item">Edit</a>
                                    </li>
                                    <li>
                                        <a href="/shift/delete/{{ $item->id }}" class="dropdown-item">Hapus</a>
                                        
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
</x-main-layout>
