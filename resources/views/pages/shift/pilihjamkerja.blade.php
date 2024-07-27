<x-main-layout>
    <form action="/jamkerja/proses/input" method="post" style="max-width: 700px; margin-left: 1px; padding: 20px; border: 1px solid #ccc; border-radius: 6px;">
        <div class="row">
          <div class="col">
            <label for="tanggal">Tanggal</label>
            <input type="text" class="form-control" placeholder="tanggal" name="tanggal" id="tanggal">
            @if($errors->has('tanggal'))
                    <div class="error" >{{$errors->first('tanggal')}}</div>
                @endif
          </div>
          <div class="col">
            <label for="shift">shift</label>
            <input type="text" class="form-control" placeholder="shift" name="shift" id="shift">
            @if($errors->has('shift'))
                    <div class="error" >{{$errors->first('shift')}}</div>
                @endif
          </div>
          <div>
            <button type="submit" class="btn btn-success" style="margin-top: 18px; width: 20% ; padding: 10px; font-size: 16px;">submit</button>
          </div>
        </div>
      </form>
</x-main-layout>