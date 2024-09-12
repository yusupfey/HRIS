{{-- <x-main-layout>
    @push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
@endpush
<h1>tes</h1>
<div id="map"style="height:350px;"></div>






@section('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
     <script>
        getLocation();
        function getLocation() {
        if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else { 
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            map(position.coords.latitude,position.coords.longitude)
        }
        
        function map(mylatitude, mylongitude){
            console.log(mylatitude,mylongitude);
            let lat = mylatitude;
            let long = mylongitude;
            
            setTimeout(() => {
                var popup = L.popup();
                var map = L.map('map');
                map.setView([-6.410176262551054, 106.96085579133336], 16);
                // var marker = L.marker([51.5, -0.09]).addTo(map);
    
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    // attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map)
                L.marker([-6.410176262551054, 106.96085579133336]).addTo(map).bindPopup('RSIA Kenari Graha Medika');
                
                let iconImg = L.icon({
                    iconUrl: 'https://cdn3.iconfinder.com/data/icons/map-14/144/Map-10-512.png',
                    iconSize:     [40, 40], // size of the icon
                    shadowSize:   [10, 64], // size of the shadow
                    // iconAnchor:   [50, 50], // point of the icon which will correspond to marker's location
                    shadowAnchor: [4, 62],  // the same for the shadow
                    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
                })
                L.marker([lat,long],{icon:iconImg}).addTo(map).bindPopup("Your location.");
    
                L.circle([-6.410176262551054, 106.96085579133336], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.5,
                    radius: 40
                }).addTo(map).bindPopup("RSIA Kenari Graha Medika Area.")

            }, 200);
        }
     </script>

@endsection
</x-main-layout> --}}
