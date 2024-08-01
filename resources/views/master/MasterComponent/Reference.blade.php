<div class="d-flex justify-content-end">
    <a href="/master/form-input/reference" class="btn btn-primary"><div class="fas fa-plus"></div> Add Reference</a>
</div>
<div class="table-responsive">
    <div id="section" style="display: none;">{{Request::segment(2)}}</div>
    <table class="table table-striped table-border table-collapse" id="datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
                {{-- body  --}}
        </tbody>
    </table>
</div>

@section('jsMaster')
<script
src="https://code.jquery.com/jquery-3.7.1.min.js"
integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.min.js"></script>
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
            ]
        });
    } );
</script>
@endsection