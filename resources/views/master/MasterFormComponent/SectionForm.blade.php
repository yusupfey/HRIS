<h3 class="text-primary">{{$data['title']}}</h3>
<hr>
<div class="alert alert-primary">Section</div>
<div class="card">
    <form id="template">
        <div class="card-body">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" readonly name="mode" class="form-control" value="{{Request::segment(4) == null ? 'input' : 'update'}}">
                            <input type="hidden" name="id" class="form-control" value="">
                            
                            <label for="">Title</label>
                            <input type="text" name="title" class="form-control" value="">
                            <span class="text-danger" id="title"></span>
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea  name="description" class="form-control"></textarea>
                            <span class="text-danger" id="description"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="button-action d-flex justify-content-between mt-5" id="footer-button">
        <div class="button-component">
            <button type="button" class="btn btn-info" style="width: 200px;" onclick="submit()">Submit</button>
            <button type="Reset" class="btn btn-danger" style="width: 200px;">Reset</button>
        </div>
        <div class="button-back">
            <button type="button" class="btn btn-warning" style="width: 200px;">Kembali</button>

        </div>
    </div>
</div>
@section('jsComponent')
    <script>
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        $(document).ready(function(){
            $(".select2").select2();
        })
        function submit() {
            let data = $('#template').serializeArray();
            // set loading
            $('#modal_bahan').find('#footer-button').html(`
            <div class="spinner-border spinner-border-sm text-info" role="status">
            </div>`)
            console.log(data)
            $.ajax({
                url: "/master/process/section",
                method: 'post',
                data:data,
                success:function(res){
                    console.log(res)
                    window.location.href = '/master/section';
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

        $('select[name="ItemCode"]').on('change',function(){
            let val = $('select[name="ItemCode"]').val();
            $.ajax({
                url: "/master/check/item",
                method: 'post',
                headers:{
                    'X-CSRF-TOKEN':token
                },
                data:{code:val},
                success:function(res){
                    let data = res.result;
                    console.log(data)
                    if(res.result){
                        $('input[name="HNA"]').val(data.HNA);
                        $('input[name="HJA"]').val(data.HJA);
                        
                        // disable form
                        $('input').attr('disabled', true);
                        $('.button-component').css('display','none')
                    }else{
                        $('input').attr('disabled', false);
                        $('input[name="HNA"]').val('');
                        $('input[name="HJA"]').val('');
                        $('.button-component').css('display','block')

                    }
                },
                error:function(err){
                    console.log(err)
                }
            });
        }) 
        // check_item() {
        //     let data = $('#formMenuHeader').serializeArray();
        //     $.ajax({
        //         url: "/master/process/menu",
        //         method: 'post',
        //         data:data,
        //         success:function(res){
        //             console.log(res)
        //             valdiateReset(data);
        //         },
        //         error:function(res){
        //             // console.log(res)

        //             validateError(data,res.responseJSON)
        //         }
        //     });
        // }
    </script>
@endsection