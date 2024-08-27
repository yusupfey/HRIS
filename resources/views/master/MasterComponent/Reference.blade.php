<div class="d-flex justify-content-end p-2">
    <button onclick="modalReference('input')"  class="btn btn-primary"><i class="bx bxs-plus-circle"></i> Reference</button>
</div>
<div class="table-responsive">
    <div id="section" style="display: none;">{{Request::segment(2)}}</div>
    <table class="table table-striped table-border table-collapse" id="datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
                {{-- body  --}}
        </tbody>
    </table>
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
                        <label for="">Reference</label>
                        <input type="hidden" name="mode" class="form-control">
                        <input type="text" name="reference" class="form-control">
                        <span style="font-size:10px;" id="reference"></span>
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

@section('jsMaster')
<script
src="https://code.jquery.com/jquery-3.7.1.min.js"
integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.min.js"></script>
<script>
    function modalReference(mode, data=null) {
        console.log(data);
        if(data !==null){
            $('#form_Reference .form-group').append(`<input type="hidden" name="id" value="${data.id}">`)
            $('input[name="mode"]').val(mode)
            $('input[name="reference"]').val(data.reference)
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
                url: "/master/process/reference",
                method: 'post',
                data:data,
                success:function(res){
                    console.log(res)
                    window.location.href = '/master/reference';
                    valdiateReset(data);
                },
                error:function(res){
                    // console.log(res)

                    validateError(data,res.responseJSON)
                }
            })

        }
    $(document).ready( function () {
        $('#datatable').DataTable({
            serverSide:true,
            destroy:true,
            ajax: {
                url:`/master/data/${$('#section').text()}`,
            },
            columns: [
                { data: 'id' },
                { data: 'reference' },
                { data: 'Action' },
            ]
        });
    } );
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