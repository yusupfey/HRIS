<div class="card">
    <div class="card-header font-weight-bold">
        Menu Header
    </div>
    <div class="card-body">
        <form id="formMenuHeader">
            @csrf
            <div class="row">
                <div class="row mb-3">
                    <input type="hidden" readonly name="mode" class="form-control" value="{{Request::segment(4) == null ? 'input' : 'update'}}">
                    <input type="hidden" readonly name="order" class="form-control" value="0">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Menu</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="basic-default-name" placeholder="Menu" value="{{Request::segment(4) == null ? '' : $data['header']->name}}" />
                        <span id="name"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Icon</label>
                    <div class="col-sm-10">
                        <input type="text" name="icon" class="form-control" id="basic-default-name" placeholder="icon" value="{{Request::segment(4) == null ? '' : $data['header']->icon}}" />
                        <span id="icon"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Href</label>
                    <div class="col-sm-10">
                        <input type="text" name="href" class="form-control" id="basic-default-name" placeholder="href" value="{{Request::segment(4) == null ? '' : $data['header']->href}}" />
                        <span id="href"></span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @if (Request::segment(2)=="form-update")
        <div class="card-header font-weight-bold">
            Menu Detail
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary" onclick="updateDetail()"><div class="bx bx-plus-circle"></div></button>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-border table-collapse">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Name</th>
                            <th>Href</th>
                            <th>Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($data['detail'])
                            @foreach ($data['detail'] as $item)
                                <tr>
                                    <td>
                                        <div>
                                            <button class="btn btn-warning" onclick="updateDetail({{$item->id}})"><i class="tf-icons bx bx-edit"></i></button>
                                            {{-- <button class="btn btn-info"><i class="fas fa-info"></i></button> --}}
                                            <button class="btn btn-danger"><i class="tf-icons bx bx-trash"></i></button>
                                        </div>
                                    </td>
                                    <td class="detail{{$item->id}}"><span class="valDetailName{{$item->id}}">{{$item->name}}</span></td>
                                    <td class="detail{{$item->id}}"><span class="valDetailHref{{$item->id}}">{{$item->href}}</span></td>
                                    <td class="detail{{$item->id}}"><span class="valDetailLevel{{$item->id}}">{{$item->order}}</span></td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    <div class="d-flex justify-content-end p-4">
        @if (Request::segment(2)!=="form-update")
            <div class="button-action  ml-4">
                <button type="submit" class="btn btn-primary" onclick="submitHeader()" >Submit</button>
            </div>
        @endif
        <div class="button-back  ml-4">
            <button type="Reset" class="btn btn-warning" >Kembali</button>
        </div>
    </div>
</div>

{{-- modal --}}
<div class="modal fade" id="modalUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Detail</h5>
            </div>
            <div class="modal-body">
                <form id="formMenu">
                    @csrf
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control" value="">
                        <span id="Name"></span>
                        <input type="hidden" name="mode" readonly class="form-control" value="{{Request::segment('2')}}">
                        <input type="hidden" name="id" readonly class="form-control" value="">
                        <input type="hidden" name="icon" readonly class="form-control" value="menu-link">
                        <input type="hidden" name="header_id" readonly class="form-control" value="{{Request::segment('4')}}">
                    </div>
                    <div class="form-group">
                        <label for="">Href</label>
                        <input type="text" name="href" class="form-control" value="">
                        <span id="href"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Level</label>
                        <select name="order" class="form-control">
                            {{-- <option id="opt0" value="" selected>-- Pilih Level</option> --}}
                            <option id="opt1" value="1">1</option>
                            {{-- <option id="opt2" value="2">2</option> --}}
                            {{-- <option value="3">3</option> --}}
                        </select>
                        <span id="order"></span>

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

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css">
@endsection
@section('jsMaster')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
{{-- <script src="{{asset('plugins/sweetalert/sweetalert.min.js')}}"></script> --}}
    <script>
        function updateDetail(id=null){
            $('#modalUpdate').modal('toggle');

            if(id!==null){
                $('select[name="level_detail"]').find('#opt0').attr('selected', false)
    
                var Name = $('.detail'+id).find('.valDetailName'+id).text();
                var Href = $('.detail'+id).find('.valDetailHref'+id).text();
                var Level = $('.detail'+id).find('.valDetailLevel'+id).text();
    
                $('input[name="id"]').val(id)
                $('input[name="mode"]').val('update')
                $('input[name="name"]').val(Name)
                $('input[name="href"]').val(Href);
                $('select[name="order"]').find('#opt'+Level).attr('selected', true)
            }else{
                $('select[name="order"]').find('option').attr('selected', false)
                $('select[name="order"]').find('#opt0').attr('selected', true)

                $('input[name="mode"]').val('input')

                $('input[name="id"]').val('')
                $('input[name="name"]').val('')
                $('input[name="href"]').val('');
            }
            
            

        }
        function submit() {
            let data = $('#formMenu').serializeArray();
            $.ajax({
                url: "/master/process/menu_d",
                method: 'post',
                data:data,
                success:function(res){
                    if(res.code == 200){
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Data berhasil disimpan.",
                        });
                        location.reload();
                    }else{
                        validateError(data,res.errors)
                    }
                },
                error:function(res){
                    // console.log(res)

                    validateError(data,res.responseJSON)
                }
            })

        }
        function validateError(data, response){
            // console.log(data,response)
            valdiateReset(data);
            $.each(data,function(x,v){
                console.log(v.name)
                $(`#${v.name}`).html();


                $.each(Object.keys(response),function(x,resval){
                    if(v.name === resval){
                        let result = response[resval];
                        $(`#${v.name}`).html('<i class="text-danger">'+result+'</i>');
                    }
                })

            })
        }
        function valdiateReset(data){
            $.each(data,function(x,v){
                $(`#${v.name}`).html('');
            })
        }

        function submitHeader() {
            let data = $('#formMenuHeader').serializeArray();
            $.ajax({
                url: "/master/process/menu",
                method: 'post',
                data:data,
                success:function(res){
                    console.log(res)
                    // valdiateReset(data);
                    if(res.code == 200){
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Data berhasil disimpan.",
                        });
                        window.location.href = '/master/menu';
                    }else{
                        validateError(data,res.errors)
                    }
                },
                error:function(res){
                    console.log(res)
                }
            });
        }
    </script>
@endsection