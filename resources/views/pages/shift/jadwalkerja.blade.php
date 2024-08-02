<x-main-layout>
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom:20px;">
            <h5 style="margin: 0;">
                <a href="/pilihjamkerja" class="btn btn-success" style="margin-left: 7px; margin-bottom: 1px;">Create</a>
            </h5>
            <h5 class="card-title" style="margin: 0; margin-right: 20px;">Data Work schedules</h5>
        </div>
        
        <div class="card-body">
            <table class="table datatable table-hover" style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        {{-- <th>Unit</th> --}}
                        <th>Tanggal</th>
                        <th>Shift</th>
                    </tr>
                </thead>
                <tbody >
                    @foreach ($worksheadules as $x => $item)
                        <tr>
                            <td>{{ $x + 1 }}</td>
                            <td>{{ $item->name}}</td>
                            {{-- <td>{{ $item->unit}}</td> --}}
                            <td>{{ $item->tanggal }}</td>
                            <td>{{ $item->shift }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-main-layout>