

<x-main-layout>
    <x-slot name="test">


    </x-slot>


    <div class="container" style="border: px solid">
        <div class="map-container" style="height: 3px; background-color: #f8f9fa;">
        </div>


        <!-- Informasi Absensi -->
        <div class="container mt-3">
            <div class="row">
                <!-- Card Kiri -->
                <div class="col-md-6">
                    <div class="card" style="border: 1px solid; min-height: 167px;">
                        <div class="card-body d-flex align-items-center">
                            {{-- <i class="bi bi-person-circle" style="position: relative; top: 10px; font-size: 100px; border-radius: 10%; margin-right: 50px; color: #000;"></i> --}}
                            <img src="https://img.icons8.com/?size=100&id=HmQQr0jYHZxu&format=png&color=000000" style="margin-right: 50px; margin-bottom: -25px" alt="">


                            <div>
                                <h5 class="card-title mb-0">{{ $employee->name }}</h5> <!-- mb-0 menghilangkan margin bawah -->
                                <h5 class="mb-0">
                                    @if ($employee->id_unit == 1)
                                        Direktur
                                    @elseif ($employee->id_unit == 2)
                                        HRD
                                    @elseif ($employee->id_unit == 3)
                                    Manager Keperawatan
                                    @elseif ($employee->id_unit == 4)
                                    Instalasi Rawat Jalan
                                    @endif
                                </h5>
                            </div>
                        </div>


                    </div>
                </div>






                <!-- Card Kanan -->
                <div class="col-md-6">
                    <div class="card" style="border: 1px solid;">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <!-- Elemen untuk jam dinding -->
                                <div id="clock" style="position: relative; width: 100px; height: 100px; border-radius: 50%; overflow: hidden; margin-bottom: -20px">

                                    {{-- <i class="bi bi-clock" style="font-size: 70px; color: #000;"></i> --}}
                                    <img src="https://img.icons8.com/?size=100&id=rKEYSosGdrkP&format=png&color=000000" style="margin-right: 50px; width: 70px; height: 70px; margin-bottom: -70px; border-radius: 50%" alt="">


                                    <div id="hour-hand" class="hand"></div>
                                    <div id="minute-hand" class="hand"></div>
                                    <div id="second-hand" class="hand"></div>
                                </div>
                            </div>
                            <div>
                                <p class="card-text">
                                    @php
                                        // Setel lokal ke Bahasa Indonesia
                                        \Carbon\Carbon::setLocale('id');


                                        // Ambil tanggal hari ini
                                        $today = \Carbon\Carbon::today();


                                        // Format tanggal dengan nama hari dalam Bahasa Indonesia
                                        $todayFormatted = $today->translatedFormat('l, d M Y'); // Format: Jumat, 23 Agustus 2024


                                        $found = false;
                                    @endphp


                                    @if(count($worksheadules) > 0)
                                        @foreach ($worksheadules as $work)
                                            @if(isset($work->tanggal) && \Carbon\Carbon::parse($work->tanggal)->format('Y-m-d') == $today->format('Y-m-d'))
                                                <li class="list-group-item">
                                                   <h5> {{ \Carbon\Carbon::parse($work->tanggal)->translatedFormat('l, d M Y') }} </h5>
                                                </li>
                                                    <li class="list-group-item">
                                                            @if($work->shift_id == 1)
                                                                <h1>Pagi</h1>  <h5>{{ $work->checkin_time }}- {{ $work->checkout_time }}</h5>
                                                            @elseif($work->shift_id == 2)
                                                                <h1>Siang</h1> <h2></h2>
                                                            @elseif($work->shift_id == 3)
                                                                <h1>Malam</h1> <h2></h2>
                                                            @else
                                                                Status tidak tersedia
                                                            @endif
                                                    </li>
                                                @php
                                                    $found = true;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endif


                                    @if (!$found)
                                        <h5>Data hari ini tidak tersedia</h5>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>






        <!-- Data Record Absensi -->
        <div class="card mt-3">
            <button class="btn btn-primary">Jadwal Selanjutnya</button>
            <div class="card-body">
                <div class="overflow-auto" style="max-height: 400px;">
                    <ul class="list-group text-center">
                        <h6>
                            @if($worksheadules->count() > 0)
                                @php
                                    $firstItem = true; // Variabel untuk menandai item pertama
                                @endphp


                                    @foreach ($worksheadules as $work)
                                        @if($firstItem)
                                            @php
                                            $firstItem = false; // Lewatkan item pertama
                                            continue; // Lanjutkan ke item berikutnya
                                            @endphp
                                        @endif
                                            <li class="list-group-item">
                                                {{ isset($work->tanggal) ? \Carbon\Carbon::parse($work->tanggal)->format('d M Y') : 'Tanggal tidak tersedia' }} -
                                                @if($work->shift_id == 1)
                                                    Pagi - {{ $work->checkin_time }} - {{ $work->checkout_time }}
                                                    @elseif($work->shift_id == 2)
                                                        Siang - {{ $work->checkin_time }} - {{ $work->checkout_time }}
                                                    @elseif($work->shift_id == 3)
                                                        Libur - <h5>{{ $work->checkin_time }} - {{ $work->checkout_time }} </h5>
                                                    @else
                                                        Status tidak tersedia
                                                @endif
                                            </li>
                                    @endforeach
                                @else
                                    <li class="list-group-item">Tidak ada data untuk ditampilkan.</li>
                            @endif


                        </h6>
                    </ul>
                </div>


                <!-- Tombol Next dan Previous -->
                <div class="text-center mt-5">
                    <div class="pagination-wrapper">
                        {{ $worksheadules->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>





 </x-main-layout>
