<x-main-layout>
    <div class="py-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <section class="section">
                <form id="ubahForm" action="{{ route('ubahjadwal.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                <h5 class="card-title">Ajukan Tukar Shift</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="title" style="font-family: 'Times New Roman', Times, serif;font-size:18px;margin-left:10px">Your Information</div>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <div class="card-title mb-0">{{ $employeess->name }}</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="tanggal_perubahan" class="form-label">Tanggal Pertukaran</label>
                                                    <select class="form-select" id="tanggal_perubahan" name="tanggal_perubahan" required>
                                                        <option value="" disabled selected></option>
                                                        @foreach($workSchedules as $workschedule)
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
                                                    <div id="shiftDisplay" class="form-control" style="height: auto;">Pilih tanggal</div>
                                                    <input type="hidden" id="shift_awal" name="shift_awal"> 
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="alasan" class="form-label">Alasan</label>
                                                <textarea class="form-control" id="alasan" name="alasan" rows="3" required></textarea>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="title" style="font-family: 'Times New Roman', Times, serif;font-size:18px;margin-left:10px">Karyawan Pengganti</div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="uuid_pengganti" style="margin-top: 10px">Karyawan Pengganti</label>
                                                    <select id="uuid_pengganti" class="js-example-basic-single" data-shift='@json($karyawan_pengganti)'>
                                                        <option value="" disabled selected>Pilih Karyawan Pengganti</option>
                                                        @foreach ($karyawan_pengganti as $karyawan)
                                                            <option value="{{ $karyawan->uuid }}"
                                                                data-shift="{{ json_encode($karyawan->workschedules) }}">{{ $karyawan->name }}
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
                                            @foreach ($units as $item)
                                                <div class="col-md-6">
                                                    <label for="persetujuan">{{ $item->name }}</label>
                                                    <select name="persetujuan[]" class="form-control" aria-label="Pilih Unit">
                                                        <option value="{{ $item->kepala_unit }}" id="persetujuan">{{ $item->nama_karyawan }}</option>
                                                    </select>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="d-flex justify-content-end"style="margin-right:10px;margin-bottom:10px;">
                                            <button type="submit" id="submit" class="btn btn-success">Ajukan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-container--default .select2-selection--single {
                height: 37px; font-size: 18px;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 30px;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 30px;
            }
        </style>
    @endpush

    @section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 pada dropdown Karyawan Pengganti
            $('#uuid_pengganti').select2({
                placeholder: 'Pilih Karyawan Pengganti',
                allowClear: true,
            });

            $('.js-example-basic-single').select2();

            $('#tanggal_perubahan').change(function() {
                $('#uuid_pengganti').val(null).trigger('change');
                $('#shift_pengganti').empty();
                
                var shiftId = $(this).find(':selected').data('shift-id');
                var shiftName = $(this).find(':selected').data('shift-name');
                
                if (shiftId && shiftName) {
                    $('#shiftDisplay').text(shiftName);
                    $('#shift_awal').val(shiftId);
                } else {
                    $('#shiftDisplay').text('Pilih tanggal');
                    $('#shift_awal').val('');
                }
            });

            // Event ketika karyawan pengganti dipilih
            $('#uuid_pengganti').on('change', function() {
                var selectedUUID = $(this).val();
                $('#hidden').val(selectedUUID);
                var selectedDate = $('#tanggal_perubahan').val();
                var selectedOption = $(this).find('option:selected');
                var employeeShifts = selectedOption.data('shift');

                // Kosongkan opsi shift sebelumnya
                $('#shift_pengganti').empty();

                // Tampilkan shift yang hanya sesuai dengan tanggal yang dipilih
                var shift = $('<optgroup>', { label: 'Shift' });

                if (employeeShifts) {
                    employeeShifts.forEach(function(shiftData) {
                        if (shiftData.tanggal === selectedDate) {
                            shift.append(
                                $('<option>', { value: shiftData.shift_id, text: shiftData.shift.name, selected: true })
                            );
                        }
                    });
                }

                // Menambahkan opsi shift yang sesuai
                if (shift.children().length > 0) {
                    $('#shift_pengganti').append(shift);
                }
            });
        });
    </script>
    @endsection
</x-main-layout>
