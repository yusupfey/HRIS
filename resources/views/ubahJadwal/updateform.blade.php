<x-main-layout>
    <div class="py-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <section class="section">
                <form action="{{ route('ubhjdwal.update', ['id' => $ubahjadwal->id]) }}" method="post">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                <h5 class="card-title">Update Pengajuan</h5>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                            <h5 class="card-title">Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="uuid_pemohon">Nama</label>
                                                <input type="text" class="form-control" id="uuid_pemohon" name="uuid_pemohon" value="{{$employee->uuid}}" readonly>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="tanggal_perubahan" class="form-label">Tanggal Pertukaran </label>
                                                    <select class="form-select" id="tanggal_perubahan" name="tanggal_perubahan" required>
                                                        <option value="" disabled selected>Pilih Tanggal</option>
                                                        @foreach($workschedules as $workschedule)
                                                            <option value="{{ $workschedule->tanggal }}" 
                                                                    data-shift-id="{{ $workschedule->shift_id }}" 
                                                                    data-shift-name="{{ optional($workschedule->shift)->name }}">
                                                                {{ $workschedule->tanggal }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="shift_awal" class="form-label">Shift Awal</label>
                                                    <div id="shiftDisplay" class="form-control">Pilih tanggal</div>
                                                    <input type="hidden" id="shift_awal" name="shift_awal" value="{{ $ubahjadwal->shift_awal }}" required> 
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="keterangan">Keterangan</label>
                                                <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $ubahjadwal->keterangan }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                            <h5 class="card-title">Pengganti</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="uuid_pengganti" style="margin-top: 10px">Karyawan Pengganti</label>
                                                    <select id="uuid_pengganti" class="js-example-basic-single" data-shift='@json($karyawan_pengganti)'>
                                                        <option value="" disabled selected>Pilih Karyawan Pengganti</option>
                                                        @foreach ($karyawan_pengganti as $karyawan)
                                                            <option value="{{ $karyawan->uuid }}" data-shift="{{ json_encode($karyawan->workschedules) }}">
                                                                {{ $karyawan->name }}
                                                            </option>
                                                        @endforeach
                                                    </select> 
                                                    <input type="hidden" id="hidden" name="uuid_pengganti">
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label for="shift_pengganti" class="form-label">Shift Pengganti</label>
                                                    <select class="form-select" name="shift_pengganti" id="shift_pengganti">
                                                        <option value="" disabled selected>Pilih Shift</option>
                                                    </select>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="submit" class="btn btn-success">Update</button>
                </form>
            </section>
        </div>
    </div>

    @push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single { height: 37px; font-size: 18px; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 30px; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 30px; }
    </style>    
    @endpush

    @section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();

            // Ketika tanggal dipilih
            $('#tanggal_perubahan').change(function() {
                var shiftId = $(this).find(':selected').data('shift-id');
                var shiftName = $(this).find(':selected').data('shift-name');

                console.log('Shift ID:', shiftId);
                console.log('Shift Name:', shiftName);

                if (shiftId && shiftName) {
                    $('#shiftDisplay').text(shiftName); 
                    $('#shift_awal').val(shiftId); 
                } else {
                    $('#shiftDisplay').text('Pilih tanggal'); 
                    $('#shift_awal').val(''); 
                }
            });

            // Ketika karyawan pengganti dipilih
            $('#uuid_pengganti').on('change', function() {
                var selectedUUID = $(this).val();
                $('#hidden').val(selectedUUID);
                var selectedDate = $('#tanggal_perubahan').val();
                var selectedOption = $(this).find('option:selected');
                var employeeShifts = selectedOption.data('shift');
                var shifts = @json($shift); 

                $('#shift_pengganti').empty();

                var shift = $('<optgroup>', { label: 'Shift' });
                var tukar_shift = $('<optgroup>', { label: 'Tukar Shift' });

                var shiftId;
                if (employeeShifts) {
                    employeeShifts.forEach(function(shiftData) {
                        if (shiftData.tanggal === selectedDate) {
                            shiftId = shiftData.shift_id;
                            shift.append(
                                $('<option>', { value: shiftData.shift_id, text: shiftData.shift.name, selected: true })
                            );
                        }
                    });
                }

                shifts.forEach(function(shiftData) {
                    if (shiftData.id !== shiftId) {
                        tukar_shift.append(
                            $('<option>', { value: shiftData.id, text: shiftData.name })
                        );
                    }
                });

                $('#shift_pengganti').append(shift).append(tukar_shift);
            });
        });
    </script>
    @endsection
</x-main-layout>
