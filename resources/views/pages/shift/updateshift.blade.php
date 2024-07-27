<x-main-layout>  
    @if (Session::has('gagal'))
        <div class="alert alert-danger" style="margin-bottom: 20px;">{{Session::get('gagal')}}</div>
    @endif  

    <form action="/shift/proses/update" method="post" style="max-width: 700px; margin-left: 1px; padding: 20px; border: 1px solid #ccc; border-radius: 10px;">
        @csrf

        <ul style="list-style-type: none; padding: 10px;">
            <li style="margin-bottom: 20px;">
                <label for="name" style="font-weight: bold;">Shift</label><br>
                <input class="form-control" type="text" placeholder="Shift" value="{{$shift->name}}" aria-label="default input example" name="name" id="name">
                <input type="hidden" value="{{$shift->id}}" name="id">
                @if($errors->has('name'))
                    <div class="error">{{$errors->first('name')}}</div>
                @endif
            </li>
            <li style="margin-bottom: 20px;">
                <label for="jam" style="font-weight: bold;">Jam</label><br>
                <input class="form-control" type="time" placeholder="Jam Masuk" aria-label="default input example" name="jam" id="jam" value="{{$shift->jam}}">
                @if($errors->has('jam'))
                    <div class="error">{{$errors->first('jam')}}</div>
                @endif
            </li>
            <li style="margin-bottom: 20px;">
                <label for="checkin_time" style="font-weight: bold;">CheckIn Time</label><br>
                <input class="form-control" type="time" placeholder="Jam checkin_time" aria-label="default input example" name="checkin_time" id="checkin_time" value="{{$shift->checkin_time}}">
                @if($errors->has('checkin_time'))
                    <div class="error">{{$errors->first('checkin_time')}}</div>
                @endif
            </li>
            <li>
                <button type="submit" class="btn btn-success" name="submit">Submit</button>
            </li>
        </ul>
    </form>
</x-main-layout>
