<x-main-layout>
    <div class="container" style="border: 1px solid #e0e0e0;">
        <div class="map-container" style="height: 3px; background-color: #f8f9fa;"></div>

        <!-- Informasi Absensi -->
        <div class="container mt-3">
            <div class="row">
                <!-- Card Kiri -->
                <div class="col-md-6 mb-3">
                    <div class="card border-light shadow-sm">
                        <div class="card-body d-flex align-items-center"style="padding-top:15px">
                            <img src="{{ asset('assets/img/business.png') }}" alt="Logo" class="img-fluid rounded-circle me-3" style="width: 100px; height: 100px;">
                            <div>
                                <h5 class="card-title mb-0">{{ $employee->name }}</h5>
                                <p class="mb-0 text-muted" style="font-family: Times New Roman; font-size: 18px; font-weight: bold;">
                                    {{ $employee->unit->name ?? 'Tidak Diketahui' }}
                                </p>
                            </div>
                        </div> 
                    </div>
                </div>

                <!-- Card Kanan -->
                <div class="col-md-6 mb-3">
                    <div class="card border-light shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3" style="padding-top: 15px;">
                                <div style="position: relative; width: 100px; height: 100px;overflow: hidden;">
                                    <img src="{{ asset('assets/img/offer-up.png') }}"  class="img" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </div>
                            <div>
                                <p class="card-text mb-0"style="padding-top:15px">
                                    @php
                                        $today = date('Y-m-d');
                                        $todayWorks = $worksheadules->filter(function ($work) use ($today) {
                                            return $work->tanggal == $today;
                                        });
                                    @endphp

                                    @if ($todayWorks->isNotEmpty())
                                        @foreach ($todayWorks as $work)
                                            <h5 class="mb-0">{{ date('l, d M Y', strtotime($work->tanggal)) }}</h5>
                                            <h4 class="text-primary">
                                                {{ $work->shift_name ?? 'Status tidak tersedia' }}: <br>
                                                 {{ $work->checkin_time }} - {{ $work->checkout_time }}
                                            </h4>
                                        @endforeach
                                    @else
                                        <h5 class="mb-0">Data hari ini tidak tersedia</h5>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <button class="btn btn-primary">Jadwal Selanjutnya</button>
            <div class="card-body">
                <div class="overflow-auto" style="max-height: 400px;">
                    <ul class="list-group text-center">
                        @if($worksheadules->count() > 0)
                            @foreach ($worksheadules as $work)
                                <li class="list-group-item">
                                    {{ date('d M Y', strtotime($work->tanggal)) }} -
                                    {{ $work->shift_name ?? 'Status tidak tersedia' }} 
                                    
                                    {{ $work->checkin_time }} - {{ $work->checkout_time }}
                                </li>
                            @endforeach
                        @else
                            <li class="list-group-item">Anda tidak memiliki jadwal.</li>
                        @endif
                    </ul>
                </div>
                <div class="text-center mt-5">
                    <div class="pagination-wrapper">
                        {{ $worksheadules->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
