<x-main-layout>
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h5 class="card-title">Data Work schedules</h5>
            
        </div>
        <div class="card-body">
            <div id="section" style="display: none;">{{Request::segment(2)}}</div>


            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table datatable table-hover table-striped" id="datatable"style="padding-top: 20px;">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Unit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
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
</x-main-layout>
