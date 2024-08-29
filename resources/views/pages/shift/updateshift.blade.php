<x-main-layout>
    @if (Session::has('gagal'))
        <div class="alert alert-danger" style="margin-bottom: 20px;">
            {{ Session::get('gagal') }}
        </div>
    @endif  
    <div class="py-12">
        <div class="container" style="max-width: 90%;padding:16px">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body"  style="display: flex; justify-content: space-between; align-items: center; padding-top:20px; ">
                                <h1 class="card-title">Edit Shift</h1>
                                <button onclick="window.history.back()" class="btn btn-warning"><i class="bx bx-arrow-back bx-sm"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 bg-white border-bottom border-gray-200"> 
                <form action="/shift/proses/update" method="post" style="max-width: 100%; ">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" style="font-weight: bold; max-width:50%">Shift</label>
                                <input class="form-control form-control-lg" type="text" placeholder="Shift" value="{{ $shift->name }}" aria-label="default input example" name="name" id="name" style="border-width: 3px;">
                                <input type="hidden" value="{{ $shift->id }}" name="id">
                                @if($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jam" style="font-weight: bold; ">Jam</label>
                                <input class="form-control form-control-lg" type="time" placeholder="Jam Masuk" aria-label="default input example" name="jam" id="jam" value="{{ $shift->jam }}" style="border-width: 3px;">
                                @if($errors->has('jam'))
                                    <div class="error text-danger">{{ $errors->first('jam') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <div class="col-md-6">
                            <label for="checkin_time" style="font-weight: bold; display: block; margin-bottom: 8px;">CheckIn Time</label>
                            <input class="form-control form-control-lg" type="time" placeholder="Check-in" aria-label="default input example" name="checkin_time" id="checkin_time" value="{{ $shift->checkin_time }}" style="border-width: 3px;">
                            @if ($errors->has('checkin_time'))
                                <div class="error text-danger">{{ $errors->first('checkin_time') }}</div>
                            @endif
                        </div>
                        <div class="md-6">
                            <label for="checkout_time" style="font-weight: bold; display: block; margin-bottom: 8px;">CheckOut Time</label>
                            <input class="form-control form-control-lg" type="time" placeholder="Check-Out" aria-label="default input example" name="checkout_time" id="checkout_time" style="border-width: 3px;">
                            @if ($errors->has('checkout_time'))
                                <div class="error text-danger">{{ $errors->first('checkout_time') }}</div>
                            @endif
                        </div>
                    </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success btn-lg" name="submit" style="margin-top: 18px; ">Submit</button>
                </form>
            </div>
        </div>
    </div>
</x-main-layout>

