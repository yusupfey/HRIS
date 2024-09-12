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
            <section class="section" style="margin-top: 1px;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" style="border-radius:10px;">
                            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                <h5 class="card-title" style="margin-right: 20px;">Approved</h5>
                            </div>
                            <div class="card-body">
                                <div id="section" style="display: none;">{{Request::segment(2)}}</div>
                                <div class="table-responsive">
                                    <table class="table datatable table-hover table-striped" id="datatable"style="padding-top: 20px;">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No</th>
                                                <th>ID_Permohonan</th>
                                                <th>Jenis_Permohonan</th>
                                                <th>Nama</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-light">
                                            @foreach ($data['data'] as $x => $item)
                                                <tr>
                                                    <td>{{ $x + 1 }}</td>
                                                    <td>{{ $item->id_permohonan }}</td>
                                                    <td>
                                                        @switch($item->jenis_permohonan)
                                                            @case(1)
                                                                <b>Cuti</b>
                                                                @break
                                                            @case(2)
                                                                <b>Izin</b>
                                                                @break
                                                            @default

                                                        @endswitch
                                                    </td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>
                                                        <button onclick="modalApprove({{$item->id_permohonan}}, {{$item->jenis_permohonan}})" class="btn btn-primary"><i class="tf-icons bx bxs-calendar-check"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card" style="border-radius:10px;">
                            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                <h5 class="card-title" style="margin-right: 20px;">History</h5>
                            </div>
                            <div class="card-body">
                                <div id="section" style="display: none;">{{Request::segment(2)}}</div>
                                <div class="table-responsive">
                                    <table class="table datatable table-hover table-striped" id="datatable"style="padding-top: 20px;">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No</th>
                                                <th>ID_Permohonan</th>
                                                <th>Jenis_Permohonan</th>
                                                <th>Nama</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-light">
                                            @foreach ($data['history'] as $x => $item)
                                                <tr>
                                                    <td>{{ $x + 1 }}</td>
                                                    <td>{{ $item->id_permohonan }}</td>
                                                    <td>
                                                        @switch($item->jenis_permohonan)
                                                            @case(1)
                                                                <b>Cuti</b>
                                                                @break
                                                            @case(2)
                                                                <b>Izin</b>
                                                                @break
                                                            @default

                                                        @endswitch
                                                    </td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>
                                                        <button onclick="modalApprove({{$item->id_permohonan}}, {{$item->jenis_permohonan}}, 'info')" class="btn btn-info"><i class="tf-icons bx bxs-calendar-check"></i></a>
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
        <script
        src="{{asset('/jquery-3.7.1.min.js')}}"></script>

        <script>
            function modalApprove(id, type, mode=null) {
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
                switch (type) {
                    case 1://cuti
                        data(id,'cuti', function(response){

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
                        break;
                        case 2:
                            data(id, 'izin', function(res){
                                let izin = '';
                                    $.each(res.izin, function(x, val){
                                        izin = `
                                            <input type="hidden" readonly name="id_permohonan" value="${val.id}">
                                            <input type="hidden" readonly name="jenis_permohonan" value="2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div style="font-size:12px; font-weight:bold">Name</div>
                                                    <div style="font-size:14px;">${val.name}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div style="font-size:12px; font-weight:bold">Unit</div>
                                                    <div style="font-size:14px;">${val.unit}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div style="font-size:12px; font-weight:bold">Dari</div>
                                                    <div style="font-size:14px;">${val.start_time}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div style="font-size:12px; font-weight:bold">Sampai</div>
                                                    <div style="font-size:14px;">${val.end_time}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div style="font-size:12px; font-weight:bold">Alasan</div>
                                                    <div style="font-size:14px;">${val.alasan}</div>
                                                </div>
                                                <hr>
                                                <div class="col-6">
                                                    <div style="font-size:12px; font-weight:bold">No</div>
                                                    <div style="font-size:14px;">${val.notelpon}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div style="font-size:12px; font-weight:bold">Alamat</div>
                                                    <div style="font-size:14px;">${val.alamat}</div>
                                                </div>
                                            </div>
                                        `;
                                    })
                                    let approve='<div class="row">';
                                    $.each(res.approve, function(x, val){
                                        approve += `
                                                <div class="col-4">
                                                    <div style="font-size:12px; font-weight:bold">${val.name}</div>
                                                    <div style="font-size:10px;">${val.unit}</div>
                                                    <div style="font-size:10px;">${val.approve_date === null ? 'Belum disetujui': val.approve == '1' ? 'Telah disetujui '+val.approve_date:'Tidak disetujui '+val.approve_date}</div>

                                                </div>

                                        `;
                                    })
                                    approve +='</div>';
                                    $('#modalApprove .modal-body').html(`
                                        ${izin}
                                        <hr/>
                                        Persetujuan
                                        <hr>
                                        ${approve}
                                    `)
                            })
                        break;
                    default:
                        break;
                }
                $('#modalApprove').modal('show')
                if(mode==='info'){
                    $('#modalApprove .modal-footer').css('display', 'none')

                }else{
                    $('#modalApprove .modal-footer').css('display', 'block')

                }

            }
            function data(id,type, callback){
                $.ajax({
                    url: "/approve/data/"+type,
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
            function submit(answer) {
                $.ajax({
                    url: "/approve/store/"+answer,
                    method: 'post',
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')

                    },
                    data:{
                        id_permohonan:$('input[name="id_permohonan"]').val(),
                        jenis_permohonan:$('input[name="jenis_permohonan"]').val(),
                    },
                    success:function(res){
                        console.log(res)
                        if(res.metadata.code==200){
                            window.location.href = '/approve';
                        }
                        // valdiateReset(data);
                    },
                    error:function(res){
                        // console.log(res)

                        validateError(data,res.responseJSON)
                    }
                })

            }
            function valdiateReset(data){
                $.each(data,function(x,v){
                    $(`#${v.name}`).html('');
                })
            }
            function validateError(data, response){
                console.log(data,response.errors)
                valdiateReset(data);
                $.each(data,function(x,v){
                    console.log(v.name)
                    $(`#${v.name}`).html();


                    $.each(Object.keys(response.errors),function(x,resval){
                        if(v.name === resval){
                            let result = response.errors[resval];
                            $(`#${v.name}`).html('<i class="text-danger">'+result+'</i>');
                        }
                    })

                })


            }


        </script>
    @endsection
</x-main-layout>
