<div class="d-flex justify-content-end">
    <a href="/master/form-input/menu" class="btn btn-primary"><div class="fas fa-plus"></div> Add Menu</a>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div id="section" style="display: none;">{{Request::segment(2)}}</div>
            <table class="table table-striped table-border table-collapse" id="datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Icon</th>
                        <th>Href</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                        {{-- body  --}}
                </tbody>
            </table>
        </div>
    </div>
</div>


@section('jsComponent')
<script>
    $(document).ready( function () {
        $('#datatable').DataTable({
            serverSide:true,
            destroy:true,
            ajax: {
                url:`/master/data/${$('#section').text()}`,
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'icon' },
                { data: 'href' },
                { data: 'Action' },
            ]
        });
    });

    function updateDetail(id){
        $('#modalUpdate').modal('toggle');
    }
</script>
@endsection