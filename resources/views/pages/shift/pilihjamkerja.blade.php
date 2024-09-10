<x-main-layout>
    <div class="py-12">
        <div class="container-fluid">
            <form action="/jadwalkerja/proses/input" method="post" style="max-width: 100%;">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body" style="display: flex; justify-content: space-between; align-items: center; margin-top:20px;">
                                    <h5 class="card-title">Pilih Jam Kerja</h5>
                                    <div class="col-md-2 col-sm-2 ml-auto">
                                        <select class="form-control-sm"name="month" onchange="CountDayInMonth()" id="month">
                                            @for ($m = 1; $m <= 12; $m++)
                                                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" 
                                                    {{ $m == date('m') ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                                </option>
                                            @endfor
                                        </select>
                                        @if($errors->has('month'))
                                            <div class="error">{{ $errors->first('month') }}</div>
                                        @endif
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <select class="form-control-sm" name="year" id="year">
                                            <!-- Options will be populated by JavaScript -->
                                        </select>
                                        @if($errors->has('year'))
                                            <div class="error">{{ $errors->first('year') }}</div>
                                        @endif
                                    </div>
                                    {{-- <button onclick="window.history.back()" class="btn btn-warning sm">Back</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @csrf
                <input type="hidden" name="uuid" value="{{ Request::segment(2) }}">
                <div class="p-3 bg-white border-bottom border-gray-2000">
                    <div class="row" style="margin-top: 10px;">
                        <div class="row" id="targetForm"></div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-success btn-lg" name="submit" id="submit" style="margin-top: 20px;">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('css')
        <link rel="stylesheet" href="{{ asset('plugin/datetimepicker/datepicker.css') }}">
    @endpush

    @section('js')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="{{ asset('plugin/datetimepicker/bootstrap-datepicker.js') }}"></script>
        <script>
            let shift = JSON.parse(`{!! $shift !!}`);

            $(document).ready(function() {
                const startYear = new Date().getFullYear();
                const endYear = startYear + 1;
                const selectYear = $('#year');

                for (let year = startYear; year <= endYear; year++) {
                    selectYear.append(new Option(year, year));
                }

                // Run CountDayInMonth on page load
                setTimeout(CountDayInMonth, 99);
            });

            function daysInMonth(month, year) {
                return new Date(year, month, 0).getDate();
            }

            function CountDayInMonth() {
                let month = $('#month').val();
                let year = $('#year').val();
                let days = daysInMonth(month, year);

                let uuid = $('input[name="uuid"]').val();
                let token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: "/getjamkerja",
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data: { uuid: uuid, year: year, month: month },
                    success: function(data) {
                        let form = '';

                        if (data.length > 0) {
                            $.each(data, function(x, item) {
                                let options = '';
                                $.each(shift, function(x, value) {
                                    options += `<option value="${value.id}" ${item.shift_id === value.id ? 'selected' : ''}>${value.name}</option>`;
                                });

                                form += `
                                    <div class="col-6" style="margin-bottom:10px;padding-left:5px;">
                                        <input type="date" class="form-control form-control" name="tanggal[]" value="${item.tanggal}" readonly>
                                    </div>
                                    <div class="col-6" style="margin-bottom:10px;padding-right:1px;">
                                        <select class="form-control form-control" name="shift[]">
                                            ${options}
                                        </select>
                                    </div>
                                `;
                            });
                        } else {
                            for (let index = 0; index < days; index++) {
                                let date = index + 1;
                                form += `
                                    <div class="col-6">
                                        <input type="date"class="form-control" name="tanggal[]" value="${year}-${month}-${date < 10 ? '0' + date : date}" readonly>
                                        @if($errors->has('tanggal'))
                                            <div class="error">{{ $errors->first('tanggal') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <select class="form-control form-control" name="shift[]">
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

                        $('#targetForm').html(`
                            <div class="col-6"style="padding-left:10px;">Tanggal</div>
                            <div class="col-6">Shift</div>
                            ${form}
                        `);
                    },
                    error: function(xhr) {
                        console.error("An error occurred:", xhr.responseText);
                    }
                });
            }
        </script>
    @endsection
</x-main-layout>
