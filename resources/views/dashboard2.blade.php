
<x-main-layout>
<div class="py-2 container">
    <div class="row">
        <div class="col-md-12">
            <div class="box p-4 border rounded-4 bg-white shadow-sm">
                <div class="row">
                    <div class="col-12">
                        <div class="text-left mb-1 mt-3 mt-md-0">
                            <h5 class="text-muted"style=" font-size:18px; font-weight:bold;">Absensi,</h5>
                            <div style="font-size: 22px;font-weight:bold">Rsia Kenari graha Medika!</div>
                         </div>
                    </div>
                    <div class="col-md-6">
                        <div id="map" class="custom-map"></div>
                    </div>
                    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center mb-4 mb-md-0">
                        <div>
                         <div class="text-left mb-1 mt-md-0">
                            <input type="hidden" id="schd_id" value="{{$data->id ?? null}}">
                            <div class="text-muted" style="font-size: 14px;font-weight:bold;margin-top:15px;">{{$data->name ?? null}}</div>
                             <div style="font-size: 22px;font-weight:bold">{{$data->tanggal ?? null}}</div>
                             @if($data == null)
                             <div class=" text-center" style="font-size: 18px;font-weight:bold">Anda Tidak Memiliki Jadwal</div>
                             @else
                             <div class="text-muted" style="font-size: 14px;font-weight:bold">masuk</div>
                             <div id="masuk" class="display-6"style="font-size: 20px;font-weight:bold">
                                 @if (isset($absen))
                                     {{ date(' H:i', strtotime($absen->in_date)) }}
                                 @else
                                     --:-- 
                                 @endif
                             </div>
                             <div class="text-muted" style="font-size: 14px;font-weight:bold">pulang</div>
                             <div id="pulang" class="display-6"style="font-size: 20px;font-weight:bold">
                                @if (isset($pulang))
                                    {{ date(' H:i', strtotime($pulang->in_date)) }}
                                @else
                                    --:-- 
                                @endif
                            </div>
                         </div>
                             @endif
                            <div class="d-grid gap-2 d-block text-center" style="margin-top:20px;">
                        
                                @if($data == null)
                                @else
                                <button class="btn  btn-primary" id="checkin" onclick="absen('checkin')" {{ !$checkin ? 'hidden' : '' }}>Masuk</button>
                                <button class="btn  btn-danger " id="checkout" onclick="absen('checkout')"{{ !$checkout ? 'hidden' : '' }}>Pulang</button>   
                               
                                @endif
                            </div>
                            <div class="d-flex justify-content-center ">
                                <div class="m-1 text-center text-dark">
                                    <ul class="d-flex justify-content-center align-items-center nav nav-tabs nav-justified" style="border-radius: .25rem;">
                                        <li class="nav-item mx-2 py-2">
                                            <a class="nav-link text-success py-3" href="/cuti" style="background-color: #f6f1f1; box-shadow: 4px 4px 6px rgba(46, 34, 34, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                                <span class="bi bi-calendar2-week"></span>
                                                <div style="font-size: 15px; font-family: 'Times New Roman', Times, serif;">Cuti</div>
                                            </a>
                                        </li>
                                        <li class="nav-item mx-2 py-2">
                                            <a class="nav-link text-success py-2" href="/ubahjadwal/{{session('uuid')}}" style="background-color: #f1f1f3; box-shadow: 4px 4px 6px rgba(2, 2, 2, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                                <span class="bi bi-calendar2-x"></span>
                                                <div style="font-size: 12px; font-family: 'Times New Roman', Times, serif;">Tukar Shift</div>
                                            </a>
                                        </li>
                                        <li class="nav-item mx-2 py-4">
                                            <a class="nav-link text-success py-3" href="/myjadwal/{{ session('uuid') }}" style="background-color: #f1f1f3; box-shadow: 4px 4px 6px rgba(2, 2, 2, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                                <span class="bi bi-calendar2-week"></span>
                                                <div style="font-size: 12px; font-family: 'Times New Roman', Times, serif;">Jadwal</div>
                                            </a>
                                        </li>
                                    </ul>
                                    
                                    <style>
                                    .nav-link:hover {
                                        transform: scale(1.05); 
                                        box-shadow: 6px 6px 12px rgba(2, 2, 2, 0.3);
                                    }
                                    </style>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </div>
</div>
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <style>
            .custom-map {
                border-radius: 10px;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                margin-top: 5px; 
                height: 250px; 
                width: 100%;
            }
            .box {
                background-color: #ffffff; 
                border: 1px solid #ddd;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            }
        </style>
@endpush

    @section('js')
    <script
    
src="https://code.jquery.com/jquery-3.7.1.min.js"
integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
            let lat = '';
            let long = '';
            let marker = null;
            let circle = null;

            map()
            function getLocation() {
                console.log('jalan');
                
                if (navigator.geolocation) {
                    console.log(navigator.geolocation);
                    
                    navigator.geolocation.getCurrentPosition(showPosition, showError);
                } else { 
                    console.log("Geolocation is not supported by this browser.");
                    
                }
            }
            function showPosition(position) {
                console.log(position);
                lat = position.coords.latitude;
                long = position.coords.longitude;
                // map(position.coords.latitude,position.coords.longitude)
            }
            function showError(position) {
                console.log(position);
                lat = position.coords.latitude;
                long = position.coords.longitude;
                // map(position.coords.latitude,position.coords.longitude)
            }
            
            function map(){
                var popup = L.popup();
                var map = L.map('map', { zoomControl: false });
                
                    
                    setTimeout(() => {
                        setInterval(() => {
                            getLocation()
                                map.setView([lat,long], 16);
                            // var marker = L.marker([51.5, -0.09]).addTo(map);
                
                            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                                // attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                            }).addTo(map)
                            let iconImg = L.icon({
                                iconUrl: 'https://cdn3.iconfinder.com/data/icons/map-14/144/Map-10-512.png',
                                iconSize:     [30, 30], // size of the icon
                                shadowSize:   [10, 64], // size of the shadow
                                // iconAnchor:   [50, 50], // point of the icon which will correspond to marker's location
                                shadowAnchor: [4, 62],  // the same for the shadow
                                popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
                            })

                            if (marker !== null) {
                                map.removeLayer(marker)
                            }
                            marker = L.marker([lat,long],{icon:iconImg}).addTo(map).bindPopup("Your location.");
                        }, 3500);
            
                        L.marker([-6.410176262551054, 106.96085579133336]).addTo(map).bindPopup('RSIA Kenari Graha Medika');
                        
                        circle = L.circle([-6.410176262551054, 106.96085579133336], {
                            color: 'red',
                            fillColor: '#f03',
                            fillOpacity: 0.5,
                            radius: 50
                        }).addTo(map).bindPopup("RSIA Kenari Graha Medika Area.")
        
                    }, 300);
            }
            function isOutsideCircle(latlng, circle) {
                var circleLatLng = circle.getLatLng();
                var circleRadius = circle.getRadius();
                var distance = latlng.distanceTo(circleLatLng);

                console.log('circleLatLng', circleLatLng);
                console.log('circleRadius', circleRadius);
                console.log('distance', distance);
                console.log('distance', distance);
                console.log(distance +'>'+ circleRadius);
                
                return distance > circleRadius;
            }

            function absen(type){
                var markerLatLng = L.latLng([lat, long]);

                
                if (isOutsideCircle(markerLatLng, circle)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan!',
                        text: 'Anda tidak dapat melakukan check-in karena berada di luar zona.',
                        confirmButtonText: 'OK'
                    });
                    
                }else{
                    let token = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                    url:"/absen/store",
                    method:"post",
                    headers: {
                    'X-CSRF-TOKEN': token
                    },
                    data:{
                        schd_id:$('#schd_id').val(),
                        latlong:`${lat},${long}`,
                        mode:type
                    },
                    success: function(res){
                        if (type == 'checkin') {
                            $('#masuk').text(res.response.data.split(' ')[1].slice(0, 5)); // Memilah string
                            $('#checkin').hide();
                            Swal.fire({
                                icon: 'success',
                                title: 'Terimakasih!',
                                text: 'Kehadiran Anda tercatat pada pukul ' + res.response.data.split(' ')[1],
                                confirmButtonText: 'OK'
                            });
                        } else {
                            $('#pulang').text(res.response.data.split(' ')[1].slice(0, 5)); 
                            $('#checkout').hide(); 
                            Swal.fire({
                                icon: 'success',
                                title: 'Terimakasih!',
                                text: 'Jam pulang Anda tercatat pada pukul ' + res.response.data.split(' ')[1],
                                confirmButtonText: 'OK'
                            });
                        }

                    }

                })

                }
                
            }
    </script>
    @endsection
</x-main-layout>
