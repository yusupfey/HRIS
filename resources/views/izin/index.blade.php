<x-main-layout>


    <div class="card-body">
        <div style="text-align: right;">
            <a href="/newform" class="btn btn-primary" style="margin-top: 10px">Buat Izin</a>
        </div>
    </div>


    <div class="card-body">
        <table class="table datatable table-hover table-striped" style="margin-top: 20px;">
            <thead>
                <tr>
                    {{-- <th>UUID</th> --}}
                    <th>Name</th>
                    <th>Alasan</th>
                    <th>Created_at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($izinData as $izin)
                <tr>
                    {{-- <td>{{ $izin->uuid_karyawan }}</td> --}}
                    <td>{{ $izin->name }}</td> <!-- Assuming 'name' is a column in 'izin' -->
                    <td>{{ $izin->alasan }}</td>
                    <td>{{ $izin->created_at }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</x-main-layout>
