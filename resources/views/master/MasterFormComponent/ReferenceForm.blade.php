<h3 class="text-primary">{{$data['title']}}</h3>
<hr>
<form action="" method="post">
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
                                <select name="kategori" class="form-control">
                                    <option value="">-- Pilih Reference</option>
                                    @foreach ($data['satuan'] as $item)
                                        <option value="{{$item->id}}">{{$item->reference}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary"><i class="bi bi-cloud-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header font-weight-bold">
            Detail
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Reference Detail</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" placeholder="Reference" value="">
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
    </div>
    <br>
    <div class="button-action d-flex justify-content-between">
        <div class="button-action">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="Reset" class="btn btn-danger">Reset</button>
        </div>
        <div class="button-back">
            <button type="Reset" class="btn btn-warning">Kembali</button>

        </div>
    </div>
</form>