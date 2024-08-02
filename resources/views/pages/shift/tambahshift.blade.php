<x-main-layout>  
    @if (Session::has('gagal'))
        <div class="alert alert-danger" style="margin-bottom: 20px;">
            {{ Session::get('gagal') }}
        </div>
    @endif
    
    <div class="py-12">
        <div class="container" style="max-width: 90%;padding:16px" >
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-top: 5px; margin-bottom:5px;">New Shift</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-3 bg-white border-bottom border-gray-200">
                <form action="/shift/proses/input" method="post" style="max-width: 100%; margin-left:35px;margin-right:30px;">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" style="font-weight: bold; display: block; margin-bottom: 8px;">Shift</label>
                                <input class="form-control form-control-lg" type="text" placeholder="Shift" aria-label="default input example" name="name" id="name" style="border-width: 3px;">
                                @if ($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jam" style="font-weight: bold; display: block; margin-bottom: 8px;">Jam</label>
                                <input class="form-control form-control-lg" type="time" placeholder="Jam Masuk" aria-label="default input example" name="jam" id="jam" style="border-width: 3px;">
                                @if ($errors->has('jam'))
                                    <div class="error text-danger">{{ $errors->first('jam') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-start mb-3">
                        <div class="col-md-6">
                            <label for="checkin_time" style="font-weight: bold; display: block; margin-bottom: 8px;">CheckIn Time</label>
                            <input class="form-control form-control-lg" type="time" placeholder="Check-in" aria-label="default input example" name="checkin_time" id="checkin_time" style="border-width: 3px;">
                            @if ($errors->has('checkin_time'))
                                <div class="error text-danger">{{ $errors->first('checkin_time') }}</div>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg" name="submit" style="margin-top: 10px;margin-bottom:15px">
                        Submit
                    </button>
                </form>
            </div> 
        </div> 
    </div>
</x-main-layout>