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
                                        <a href="/newformm" class="btn btn-success">Ajukan Cuti</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="section" style="display: none;">{{Request::segment(2)}}</div>
                                    <div class="table-responsive" style="overflow-x: auto;">
                                        <table class="table datatable table-hover table-striped">
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
                                                        <button onclick="modalApprove({{$item->id}}, 'info')"  class="btn btn-info"><i class="tf-icons bx bx-info-circle"></i></button>
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
    <div class="modal fade" id="modalApprove" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Persetujuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    
                </div>
                <div class="modal-body">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only"></span>
                      </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="submit('approved')">Approve</button>
                <button type="button" class="btn btn-danger" onclick="submit('reject')">Reject</button>
                </div>
            </div>
        </div>
    </div>
    @section('js')
    <script src="{{asset('/jquery-3.7.1.min.js')}}"></script>
    <script>
         function modalApprove(id, mode=null) {
                    // if(data !==null){
                    //     $('#form_Reference .form-group').append(`<input type="hidden" name="id" value="${data.id}">`)
                    //     $('input[name="mode"]').val(mode)
                    //     $('input[name="val_name"]').val(data.val_name)
                    //     $('input[name="val"]').val(data.val)
                    //     $('#modaReference').modal('show')
                    // }else{
                    //     $('input[name="mode"]').val(mode)
                    //     $('#modaReference').modal('show')
                    // }
    
                            dataCuti(id, function(response){
    
                                let cuti = '';
                                $.each(response.cuti, function(x, val){
                                    cuti = `
                                        <input type="hidden" readonly name="id_permohonan" value="${val.id}">
                                        <input type="hidden" readonly name="jenis_permohonan" value="1">
                                        <div class="row">
                                            <div class="col-6">
                                                <div style="font-size:12px; font-weight:bold">Name</div>
                                                <div style="font-size:10px;">${val.name}</div>
                                            </div>
                                             <div class="col-6">
                                                <div style="font-size:12px; font-weight:bold">Unit</div>
                                                <div style="font-size:10px;">${val.unit}</div>
                                            </div>
                                            <div class="col-6">
                                                <div style="font-size:12px; font-weight:bold">Jenis Cuti</div>
                                                <div style="font-size:10px;">${val.val_name}</div>
                                            </div>
                                            <div class="col-6">
                                                <div style="font-size:12px; font-weight:bold">Jumlah Cuti</div>
                                                <div style="font-size:10px;">${val.jumlah}</div>
                                            </div>
                                            <div class="col-6">
                                                <div style="font-size:12px; font-weight:bold">Pengganti</div>
                                                <div style="font-size:10px;">${val.pengganti_name}</div>
                                            </div>
                                            <div class="col-6">
                                                <div style="font-size:12px; font-weight:bold">Approve_Pengganti</div>
                                                <div style="font-size:10px;">${val.approve_pengganti === undefined ? 'Belum disetujui': 'Telah disetujui'+val.approve_pengganti}</div>
                                            </div>
                                        </div>
                                    `;
                                })
                                let approve='<div class="row">';
                                $.each(response.approve, function(x, val){
                                    approve += `
                                            <div class="col-4">
                                                <div style="font-size:12px; font-weight:bold">${val.name}</div>
                                                <div style="font-size:10px;">${val.unit}</div>
                                                <div style="font-size:10px;">${val.approve_date === null ? 'Belum disetujui': 'Telah disetujui '+val.approve_date}</div>
    
                                            </div>
                                        
                                    `;
                                })
                                approve +='</div>';
                                $('#modalApprove .modal-body').html(`
                                    ${cuti}
                                    <hr/>
                                    Persetujuan
                                    <hr>
                                    ${approve}
                                `)
                            })
                    $('#modalApprove').modal('show')
                    if(mode==='info'){
                        $('#modalApprove .modal-footer').css('display', 'none')
    
                    }else{
                        $('#modalApprove .modal-footer').css('display', 'block')
    
                    }
    
                }
                function dataCuti(id, callback){
                    $.ajax({
                        url: "/approve/data/cuti",
                        headers:{
                            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                        
                        },
                        method: 'post',
                        data:{'id':id},
                        success:function(res){
                            callback(res)
                        },
                    })
                }
    </script>
    @endsection
</x-main-layout>
