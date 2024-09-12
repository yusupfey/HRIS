<x-main-layout>
<div class="py-2 container">
    <div class="row">
        <div class="col-md-12">
            <div class="box p-4 border rounded-4 bg-white shadow-sm">
                <div class="row">
                    <div class="col-md-6">
                        <div id="map" class="custom-map"></div>
                    </div>
                    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center mb-4 mb-md-0">
                        <div>
                         <div class="text-left mb-4 mt-3 mt-md-0">
                            <h5 class="text-muted"style=" font-size:18px; font-weight:bold;">Absensi,</h5>
                            <div style="font-size: 22px;font-weight:bold">Rsia Kenari graha Medika!</div>
                         </div>
                            <div class="d-flex justify-content-center mb-3" style="margin-top:50px;">
                                <div class="m-1 text-center text-dark">
                                    <div class="display-6">--:--</div>
                                    <button class="btn btn-primary" style=" color:#ffffff;font-size:20px;font-family:'Times New Roman', Times, serif;font-weight:bold">Masuk</button>
                                </div>
                                <div class="m-1 text-center text-dark">
                                    <div class="display-6">--:--</div>
                                    <button class="btn btn-danger" style="font-size: 20px;font-family:'Times New Roman', Times, serif;font-weight:bold">Pulang</button>
                                </div>  
                            </div>
                            <div class="d-flex justify-content-center ">
                                <div class="m-1 text-center text-white">
                                    <ul class="d-flex  justify-content-center align-items-center nav nav-tabs nav-justified bg-light border-bottom" style="border-radius: .25rem;">
                                        <li class="nav-item mx-2 py-2">
                                            <a class="nav-link text-success py-3" href="/cuti" style="background-color: #e6f9e6;">
                                                <span class="bi bi-calendar2-week"></span>
                                                <div style="font-size: 10px;">Cuti</div>
                                            </a>
                                        </li>
                                        <li class="nav-item mx-2 py-2">
                                            <a class="nav-link text-success py-2" href="#" style="background-color: #e6f9e6;">
                                                <span class="bi bi-calendar2-x"></span>
                                                <div style="font-size: 10px;">Ubah jadwal</div>
                                            </a>
                                        </li>
                                        <li class="nav-item mx-2 py-4" >
                                            <a class="nav-link text-success py-3" href="/myjadwal/{{ session('uuid') }}" style="background-color: #e6f9e6;">
                                                <span class="bi bi-calendar2-week"></span>
                                                <div style="font-size: 10px;"> Jadwal</div>
                                            </a>
                                        </li>
                                    </ul>
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
            /* @media (max-width: 767.98px) {
                .py-5 {
                    padding-top: 2rem; 
                    padding-bottom: 2rem;
                }
            } */
        </style>
@endpush
    @section('js')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            let lat = '';
            let long = '';
            let marker = null;

            map()
            function getLocation() {
                console.log('jalan');
            
                if (navigator.geolocation) {
                    console.log(navigator.geolocation);
                }
            }
            function showPosition(position) {
                console.log(position);
                lat = position.coords.latitude;
                long = position.coords.longitude;
                // map(position.coords.latitude,position.coords.longitude)
            }
            
            function map(){
                var popup = L.popup();
                var map = L.map('map');
                
                    
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
                        }, 5000);
            
                        L.marker([-6.410176262551054, 106.96085579133336]).addTo(map).bindPopup('RSIA Kenari Graha Medika');
                        
                        L.circle([-6.410176262551054, 106.96085579133336], {
                            color: 'red',
                            fillColor: '#f03',
                            fillOpacity: 0.5,
                            radius: 50
                        }).addTo(map).bindPopup("RSIA Kenari Graha Medika Area.")
        
                    }, 300);
            }
     </script>
    @endsection
</x-main-layout>
