<h3 class="text-primary">{{$data['title']}}</h3>
<hr>
<div class="card">
    <div class="card-header bg-info text-white font-weight-bold">
        Data Product
    </div>
    <form id="product">
        <div class="card-body">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Nama Product</label>
                                </div>
                                <div class="col-md-7">
                                <input type="hidden" readonly name="mode" class="form-control" value="{{Request::segment(4) == null ? 'input' : 'update'}}">
                                    <input type="text" name="name" class="form-control" placeholder="Nama Product" value="">
                                    <span class="text-danger" id="name"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input type="file" name="pic" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <hr>
    <div class="button-action d-flex justify-content-between">
        <div class="button-action">
            <button type="button" class="btn btn-info" style="width: 200px;" onclick="submit()">Submit</button>
            <button type="Reset" class="btn btn-danger" style="width: 200px;">Reset</button>
        </div>
        <div class="button-back">
            <button type="Reset" class="btn btn-warning" style="width: 200px;">Kembali</button>

        </div>
    </div>
@section('jsComponent')
    <script>
        
        function submit() {
            let data = $('#product').serializeArray();
            console.log(data)
            $.ajax({
                url: "/master/process/product",
                method: 'post',
                data:data,
                success:function(res){
                    console.log(res)
                    window.location.href = '/master/product';
                    valdiateReset(data);
                },
                error:function(res){
                    // console.log(res)

                    validateError(data,res.responseJSON)
                }
            })

        }
        function validateError(data, response){
            // console.log(data,response.errors)
            valdiateReset(data);
            $.each(data,function(x,v){
                // console.log(v.name)
                $(`#${v.name}`).html();


                $.each(Object.keys(response.errors),function(x,resval){
                    if(v.name === resval){
                        let result = response.errors[resval];
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
                    valdiateReset(data);
                },
                error:function(res){
                    // console.log(res)

                    validateError(data,res.responseJSON)
                }
            });
        }
    </script>
@endsection