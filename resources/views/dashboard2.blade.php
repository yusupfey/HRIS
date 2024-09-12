<x-main-layout>
    <x-slot name="test">
        <div>test</div>
    </x-slot>
    <div class="bg-primary py-5">
        <div class="text-center">
            <div class="oclock text-white" style="font-size:32px;">
                <span id="jam"></span>:<span id="menit"></span>
            </div>
            <div class="text-white">Senin, 29 Juli 2024</div>
            <div id="selisih"></div>
        </div>
        <div class="d-flex justify-content-center align-items-center mt-4">
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
                <div class="card card-body p-1" style="width: 100%;">
                    <span class="bi bi-clipboard-x"></span>
                    <div class="text-muted" style="font-size:9px;">Cuti</div>
                </div>
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
    @section('js')
        <script>
            // $(document).ready(function(){
            setTimeout(() => {
                waktu()
            }, 1000);
            // })
            function waktu() {
                var waktu = new Date();
                setTimeout("waktu()", 1000);
                document.getElementById("jam").innerHTML = waktu.getHours();
                document.getElementById("menit").innerHTML = waktu.getMinutes() < 10 ? '0'+waktu.getMinutes():waktu.getMinutes();
                // document.getElementById("detik").innerHTML = waktu.getSeconds();
                setJamAbsen(waktu.getHours(),waktu.getMinutes() < 10 ? '0'+waktu.getMinutes():waktu.getMinutes())
            }

            function setJamAbsen(hours, minutes){
                // errorrrrr
                let jam ='16:00';
                let getjam = jam.split(':')[0]
                let getminutes = jam.split(':')[1]
                console.log(getjam);
                console.log(getminutes);
                // document.getElementById("selisih").innerHTML = `Anda di perbolehkan absen pukul ${getjam - hours} Jam ${minutes - getminutes} Menit`
            }
    </script>
    @endsection
</x-main-layout>
