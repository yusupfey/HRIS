<x-main-layout>
    @push('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap5.min.css">
        {{-- <link rel="stylesheet" href="{{asset('plugins/datatables/datatables.min.css')}}"> --}}
    @endpush
    <div class="py-12">
        <h3 class="text-primary">{{$data['title']}}</h3>
        <div class="card">
            <div class="card-header font-weight-bold">
                Header
            </div>
            <div class="card-body">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Reference</label>
                            <div class="row">
                                <div class="col-md-7">
                                    <input type="text" value="{{$data['reference']->reference}}" disabled class="form-control">
                                </div>
                                {{-- <div class="col-md-4">
                                    <button class="btn btn-primary"><i class="bi bi-cloud-plus"></i></button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between">
                <div>Detail</div>
                <button onclick="modalReference('input')"  class="btn btn-primary"><i class="bx bxs-plus-circle"></i></button>
            </div>
            <div class="card-body pt-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <div id="ref_id" style="display: none;">{{Request::segment(2)}}</div>
                            <table class="table table-striped table-border table-collapse datatable">
                                <thead>
                                    <tr>
                                        <th>Reference_D_ID</th>
                                        <th>Reference_ID</th>
                                        <th>Val_Name</th>
                                        <th>Val</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach ($data['reference_d'] as $item)
                                            <tr>
                                                <td>{{$item->id}}</td>
                                                <td>{{$item->reference_id}}</td>
                                                <td>{{$item->val_name}}</td>
                                                <td>{{$item->val}}</td>
                                                <td>
                                                    <div>
                                                        <button onclick="modalReference(`update`, {'id':{{$item->id}}, val_name:'{{$item->val_name}}', val:{{$item->val}}})" class="btn btn-warning"><i class="tf-icons bx bx-edit"></i></button>
                                                        <a href="#" class="btn btn-danger"><i class="tf-icons bx bx-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Reference Detail</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" name="reference" class="form-control" placeholder="Reference" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Val</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" placeholder="value" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="button-action d-flex justify-content-end">
                </div>
                <a href="/master/reference" class="btn btn-warning">Kembali</a>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modaReference" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Reference</h5>
                </div>
                <div class="modal-body">
                    <form id="form_Reference">
                        @csrf
                        <div class="form-group">
                            <label for="">Val Name</label>
                            <input type="hidden" name="mode" class="form-control">
                            <input type="hidden" name="reference_id" value="{{Request::segment(2)}}" class="form-control">
                            <input type="text" name="val_name" class="form-control">
                            <span style="font-size:10px;" id="val_name"></span>
                        </div>
                        <div class="form-group">
                            <label for="">
                                Val
                            </label>
                            <input type="text" name="val" class="form-control">
                            <span style="font-size:10px;" id="val"></span>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submit()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    @section('js')
        <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>

        <script>
            function modalReference(mode, data=null) {
                console.log(data);
                if(data !==null){
                    $('#form_Reference .form-group').append(`<input type="hidden" name="id" value="${data.id}">`)
                    $('input[name="mode"]').val(mode)
                    $('input[name="val_name"]').val(data.val_name)
                    $('input[name="val"]').val(data.val)
                    $('#modaReference').modal('show')
                }else{
                    $('input[name="mode"]').val(mode)
                    $('#modaReference').modal('show')
                }
            }
            function submit() {
                let data = $('#form_Reference').serializeArray();
                console.log(data)
                $.ajax({
                    url: "/master/process/reference_d",
                    method: 'post',
                    data:data,
                    success:function(res){
                        console.log(res)
                        window.location.href = '/reference/{{Request::segment(2)}}';
                        valdiateReset(data);
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
