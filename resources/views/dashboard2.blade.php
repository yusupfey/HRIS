<x-main-layout>
    <x-slot name="test">
        <div>test</div>
    </x-slot>
    <div class="py-5">
        <div id="map"style="height:250px;"></div>
        <div class="d-flex justify-center mt-4">
            <div class="m-2 text-center text-white">
                <div>--:--</div>
                <div class="btn btn-info">Masuk</div>
            </div>
            <div class="m-2 text-center text-white">
                <div>--:--</div>
                <div class="btn btn-danger ml-2">Pulang</div>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-body row p-4">
            <div class="col-4 text-center">
                <a href="/cuti" class="card card-body p-1" style="width: 100%; text-decoration: none;">
                        <span class="bi bi-clipboard-x"></span>
                        <div class="text-muted" style="font-size:9px;">Cuti</div>
                </a>
            </div>
            <div class="col-4 text-center">
                <div class="card card-body p-1" style="width: 100%;">
                    <span class="bi bi-calendar2-x"></span>
                    <div class="text-muted" style="font-size:9px;">Ubah Jadwal</div>
                </div>
            </div>
            <div class="col-4 text-center">
                <a href="/myjadwal/{{ session('uuid') }}" class="card card-body p-1" style="width: 100%; text-decoration: none;">
                    <span class="bi bi-calendar2-week"></span>
                    <div class="text-muted" style="font-size:9px;">My Jadwal</div>
                </a>
            </div>
        </div>
    </div>
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
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
            
            navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else { 
                console.log("Geolocation is not supported by this browser.");
                
            }
        }
        function showError(error){
            console.log(error);
            
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
