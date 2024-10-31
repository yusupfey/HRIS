<x-main-layout>
    <div class="py-12">
        <div class="container-fluid">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body" style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                                <h5 class="card-title">Update izin</h5>
                                <button onclick="window.history.back()" class="btn btn-warning">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 bg-white border-bottom border-gray-200">
                <form action="{{ route('izin.update', ['id' => $izin->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="uuid_karyawan">Nama</label>
                        <input type="text" class="form-control" id="uuid_karyawan" name="uuid_karyawan" 
                        value="{{ Auth::user()->name}}" readonly>

                    </div>
                    
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="start_time">Start time</label>
                            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ date('H:i', strtotime($izin->start_time)) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="end_time">End time</label>
                            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ date('H:i', strtotime($izin->end_time)) }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alasan">Keterangan</label>
                        <input type="text" class="form-control" id="alasan" name="alasan" value="{{ $izin->alasan }}" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-main-layout>
