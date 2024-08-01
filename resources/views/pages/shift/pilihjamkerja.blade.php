    <x-main-layout>
        <div class="py-12">
            <div class="container">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg"  >
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body"> 
                                    <h5 class="card-title" style="margin-top: 5px; margin-bottom: 5px;">Pilih Jam Kerja</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 bg-white border-bottom border-gray-200">
                    <form action="/jamkerja/proses/input"method="post" class="container" style="max-width: 90%; padding: 16px; ">
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-6">Tanggal</div>
                            <div class="col-6">Shift</div>
                            @for ($i = 0; $i < $calculate_date; $i++)
                            <?php $date = $i+1;?>
                            <div class="col-6">
                                <input type="date" style="margin-top:5px"class="form-control form-control-lg" placeholder="Tanggal" name="tanggal[]" id="tanggal" value="<?=$date > 9 ? date("Y-m-$date"):date("Y-m-0$date");?>" style="border-width: 3px;">
                                    @if($errors->has('tanggal'))
                                        <div class="error">{{ $errors->first('tanggal') }}</div>
                                    @endif
                            </div>
                            <div class="col-6">
                                <select class="form-control form-control-lg" name="shift[]" id="shift" style="border-width: 3px; margin-top:5px ">
                                    @foreach ($shift as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('shift'))
                                    <div class="error">{{ $errors->first('shift') }}</div>
                                @endif
                            </div>
                            @endfor
                            <div class="col-12">
                                <button type="submit" class="btn btn-success btn-lg" name="submit"style="margin-top: 20px;">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-main-layout>