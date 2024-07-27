<x-main-layout>
    <div class="card">
        <div class="card-header">
            <h5>
                <a href="/pilihjamkerja" class="btn btn-success" style="margin-left: 7px; margin-bottom:1px;">Create</a>
            </h5>
        </div>
        <div class="card-body">
            <table class="table datatable">
                <thead class="table-primary">
                    <tr style="text-align: center;">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Shift</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    @foreach ($worksheadules as $x => $item)
                        <tr style="text-align: center;">
                            <td>{{ $x + 1 }}</td>
                            <td>{{ $item->uuid_emplyees }}</td>
                            <td>{{$item->shift_id}}</td>
                            <td>{{ $item->tanggal }}</td>
                            <td>{{ $item->id }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-main-layout>
