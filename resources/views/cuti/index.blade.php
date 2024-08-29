<x-main-layout>
    <div class="py-12">
        <div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                    <h5 class="card-title">Data Table Cuti</h5>
                                    <div class="col-md-4" style="text-align: right;">
                                        <a href="/ajukancuti" class="btn btn-success">Ajukan Cuti</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="section" style="display: none;">{{Request::segment(2)}}</div>
                                    <div style="overflow-x: auto; white-space: nowrap;">
                                        <table class="table datatable table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Uuid</th>
                                                    <th>Jenis Cuti</th>
                                                    <th>keterangan</th>
                                                    <th>Jumlah</th>
                                                    <th>Tanggal pengajuan</th>
                                                    <th>Karyawan Pengganti</th>
                                                    <th>approved</th>
                                                    <th>status</th>
                                                    <th>Action</th>
                                                
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cuti as $x => $item)
                                                <tr>
                                                    <td>{{ $x + 1 }}</td>
                                                    <td>{{ $item->uuid_karyawan }}</td>
                                                    <td>{{ $item->jenis_cuti }}</td>
                                                    <td>{{ $item->keterangan }}</td>
                                                    <td>{{ $item->jumlah }}</td>
                                                    <td>{{ $item->tanggal }}</td>
                                                    <td>{{ $item->karyawan_pengganti }}</td>
                                                    <td>{{ $item->approved_pengganti}}</td>
                                                    <td>{{ $item->status}}</td>
                                                    <td>
                                                        @if ($item->status ==0)    
                                                        <a href="/formupdatee/{{$item->id}}" class="btn btn-warning"><i class="tf-icons bx bx-edit"></i></a>
                                                        @endif 
                                                        <a href="" class="btn btn-info"><i class="tf-icons bx bx-info-circle"></i></a>
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
</x-main-layout>
