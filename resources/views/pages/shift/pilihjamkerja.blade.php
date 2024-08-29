    <x-main-layout>
        <div class="py-12">
            <div class="container" >
                <form action="/jadwalkerja/proses/input"method="post" class="container">
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg"  >
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body" style="display: flex; justify-content: space-between; align-items: center; margin-top:20px;">
                                        <h5 class="card-title">Pilih Jam Kerja</h5>
                                        <div class="col-md-2 col-sm-2 ml-auto">
                                                <select class="form-control" name="month" onchange="CountDayInMonth(this)" id="month">
                                                    @for ($m = 1; $m <= 12; $m++)
                                                        <option value="{{str_pad($m, 2, '0', STR_PAD_LEFT) }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                                    @endfor
                                                </select>
                                            @if($errors->has('month'))
                                                <div class="error">{{ $errors->first('month') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-1">
                                            <select class="form-control" name="year" id="year">
                                                @for ($data = 0; $data;)
                                                <option value="{{$data}}">{{ old('year', $item->year) }}</option>
                                                @endfor
                                                </select>

                                                @if($errors->has('year'))
                                                <div class="error" {{$errors->first('year')}}></div>
                                                @endif
                                        </div>
                                        <button onclick="window.history.back()" class="btn btn-warning ml-3"><i class="bx bx-arrow-back"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @csrf
                   <input type="hidden" name="uuid" value="{{Request::segment(2)}}">
                    <div class="p-3 bg-white border-bottom border-gray-2000">
                        <div class="row" style="margin-top: 10px;">
                            <div class="row" id="targetForm"></div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-success btn-lg" name="submit" id="submit"style="margin-top: 20px;">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @push('css')
            <link rel="stylesheet" href="{{asset('plugin/datetimepicker/datepicker.css')}}">
        @endpush
        @section('js')
        <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
            <script src="{{asset('plugin/datetimepicker/bootstrap-datepicker.js')}}"></script>
            <script>
                let shift = JSON.stringify(`{!!$shift!!}`)
                shift = JSON.parse(shift);

                $(document).ready(function(){
                    const startYear = new Date().getFullYear();  // Tahun awal
                    const endYear = new Date().getFullYear() + 1;  // Tahun akhir, yaitu tahun depan
                    const select = $('#year');

                    for (let year = startYear; year <= endYear; year++) {
                        select.append(new Option(year, year));
                    }
                    // jalankan function countdayinmonth
                    setTimeout(() => {

                        CountDayInMonth()
                    }, 100);


                });
                function daysInMonth (month, year) { // Use 1 for January, 2 for February, etc.
                    return new Date(year, month, 0).getDate();
                }
                function CountDayInMonth(){
                    let month = $('#month').val()
                    let year = $('#year').val()
                    let days = daysInMonth (month, year)
                    // console.log(days);
                    date = 0;



                    let uuid=$('input[name="uuid"]').val()
                    let token=$('meta[name="csrf-token"]').attr('content');
                    
                    let data = {'uuid':uuid,'year':year,'month':month};
                    console.log();
                    $.ajax({
                            url:"/getjamkerja",
                            method:'post',
                            headers:{
                                'X-CSRF-TOKEN':token
                            },
                            data:data,
                            success:function(data){
                            let form = '';
                                if(data.length > 0){
                                    $.each(data, function(x, item){
                                        let Option=""
                                        $.each(JSON.parse(shift), function(x, value){
                                            Option += `<option value="${ value.id }" ${item.shift_id===value.id ? 'selected':''}>${value.name}</option>`;
                                        })
                                            form += `
                                                <div class="col-6" style="margin-bottom:10px;">
                                                    <input type="date"class="form-control form-control-lg" placeholder="Tanggal" name="tanggal[]" id="tanggal" value="${item.tanggal}"readonly>
                                                </div>
                                                <div class="col-6" style="margin-bottom:10px;">
                                                    <select class="form-control form-control-lg" name="shift[]" id="shift">
                                                        ${Option}
                                                    </select>
                                                </div>
                                            `;
                                    })
                                }else{
                                    for (let index = 0; index < days; index++) {
                                        date = index +1;
                                        form += `
                                            <div class="col-6" style="padding-bottom:10px;">
                                                <input type="date"class="form-control form-control-lg" placeholder="Tanggal" name="tanggal[]" id="tanggal" value="${date < 10 ? year+'-'+month+'-0'+date:year+'-'+month+'-'+date}" readonly>
                                                    @if($errors->has('tanggal'))
                                                        <div class="error">{{ $errors->first('tanggal') }}</div>
                                                    @endif
                                            </div>
                                            <div class="col-6">
                                                <select class="form-control form-control-lg" name="shift[]" id="shift">
                                                    @foreach ($shift as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('shift'))
                                                    <div class="error">{{ $errors->first('shift') }}</div>
                                                @endif
                                            </div>
                                        `;

                                    }
                                }
                                let html = `
                                    <div class="col-6">Tanggal</div>
                                        <div class="col-6">Shift</div>
                                    ${form}
                                `;
                    $('#targetForm').html(html);

                                console.log(data);
                            },
                            error:function(data){
                            }

                    });
                }
            </script>


        @endsection
    </x-main-layout>
