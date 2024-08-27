<x-main-layout>

    <div class="card-body">


        <form>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="starttime">Mulai tanggal:</label>
                <input type="datetime-local" id="starttime" name="starttime" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="endtime">Sampai tanggal:</label>
                <input type="datetime-local" id="endtime" name="endtime" class="form-control" required>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="alasan">Alasan :</label>
            <textarea class="form-control" id="alasan" rows="3"></textarea>
          </div>

          <div class="form-group">
            <label for="alamat">Alamat :</label>
            <textarea class="form-control" id="alamat" rows="3"></textarea>
          </div>

          <div class="form-group">
            <label for="notelp">No Telp :</label>
            <input type="text" class="form-control" id="notelp">
          </div>
          <br>
          <div class="text-right">
            <button type="submit" class="btn btn-primary">Buat Izin</button>
          </div>
        </form>
      </div>


</x-main-layout>
