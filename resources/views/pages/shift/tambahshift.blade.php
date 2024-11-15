<x-main-layout>  
   
    
    <div class="py-12">
        {{-- <div class="container" style="max-width: 100%;" > --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body" style="display: flex; justify-content: space-between; align-items: center; margin-top:20px; ">
                                <h5 class="card-title">New Shift</h5>
                                <button onclick="window.history.back()" class="btn btn-warning">Back</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 bg-white border-bottom border-gray-200">
                <form action="/shift/proses/input" method="post" style="max-width: 100%; margin-left:35px;margin-right:30px;">
                    @csrf
                    <div class="row mb-3">
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
                            <label for="checkin_time" style="font-weight: bold; display: block; margin-bottom: 8px;">CheckIn Time</label>
                            <input class="form-control form-control-lg" type="time" placeholder="Check-in" aria-label="default input example" name="checkin_time" id="checkin_time" style="border-width: 3px;">
                            @if ($errors->has('checkin_time'))
                                <div class="error text-danger">{{ $errors->first('checkin_time') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="checkout_time" style="font-weight: bold; display: block; margin-bottom: 8px;">CheckOut Time</label>
                                <input class="form-control form-control-lg" type="time" placeholder="Check-Out" aria-label="default input example" name="checkout_time" id="checkout_time" style="border-width: 3px;">
                                @if ($errors->has('checkout_time'))
                                    <div class="error text-danger">{{ $errors->first('checkout_time') }}</div>
                                @endif
                            </div>
                        </div>
                            <div class="col-md-6">
                                    <label for="id_unit"style="font-weight: bold; display: block; margin-bottom: 8px;">Pilih Unit:</label>
                                    <select name="id_unit" id="id_unit" class="form-control  form-control-lg"style="border-width: 3px;">
                                        <option value="">Pilih Unit</option> 
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                    </div>
                    
                    <button type="submit"  class="btn btn-success " name="submit" style="margin-top: 10px;margin-bottom:15px">Submit</button>
                </form>
            </div> 
        {{-- </div>  --}}
    </div>
    @section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

</script>
    @endsection
</x-main-layout>
