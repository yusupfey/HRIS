<x-main-layout>
@section('title')
    Master Data
@endsection
{{-- @push('css')
    <link rel="stylesheet" href="{{asset('plugins/datatables/datatables.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables/datatables.min.css')}}">

    <link href="{{asset('plugins/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/multiselect/css/multi-select.css')}}" rel="stylesheet" type="text/css" />
@endpush --}}
<div class="py-12">

        @if (Request::segment(2) ==='form-input' || Request::segment(2) ==='form-update')
            @switch(Request::segment(3))
                @case('user')
                    {{-- @include('master/MasterComponent/User') --}}
                    @break
                @case('menu')
                    @include('master/MasterFormComponent/MenuForm')
                    @break
                @case('product')
                    @include('master/MasterFormComponent/ProductForm')
                @break
                @case('reference')
                    @include('master/MasterFormComponent/ReferenceForm')
                @break
                @case('unit')
                    @include('master/MasterFormComponent/UnitForm')
                @break
                @case('section')
                    @include('master/MasterFormComponent/SectionForm')
                @break
                @default
                    
            @endswitch
        @else
        <div class="card">
            <div class="card-body">
                @switch(Request::segment(2))
                    @case('user')
                        @include('master/MasterComponent/User')
                        @break
                    @case('menu')
                        @include('master/MasterComponent/Menu')
                        @break
                    @case('product')
                        @include('master/MasterComponent/Product')
                    @break
                    @case('reference')
                        @include('master/MasterComponent/Reference')
                    @break
                    @case('unit')
                        @include('master/MasterComponent/Unit')
                    @break
                    @case('section')
                        @include('master/MasterComponent/Section')
                    @break
                    @default
                        
                @endswitch
            </div>
        </div>
        @endif
</div>
@section('js')
<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
{{-- <script src="{{asset('plugins/datatables/datatables.min.js')}}"></script>
<script src="{{asset('plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script> --}}

@yield('jsMaster')
@endsection
</x-main-layout>