<div class="d-flex justify-content-end">
    <a href="/master/form-input/unit" class="btn btn-primary"><div class="fas fa-plus"></div> Add Menu</a>
</div>
<div class="card">
    <div class="card-body">
        <div class="dd">
            <ol class="dd-list" id="header-dd-list">
                <li class="dd-item" data-id="1">
                    <div class="dd-handle">Item 1</div>
                </li>
                <li class="dd-item" data-id="2">
                    <div class="dd-handle">Item 2</div>
                </li>
                <li class="dd-item" data-id="3">
                    <div class="dd-handle">Item 3</div>
                    <ol class="dd-list">
                        <li class="dd-item" data-id="4">
                            <div class="dd-handle">Item 4</div>
                        </li>
                        <li class="dd-item" data-id="5">
                            <div class="dd-handle">Item 5</div>
                        </li>
                    </ol>
                </li>
            </ol>
        </div>
    </div>
</div>


@push('css')
<link rel="stylesheet" href="{{asset('assets/vendor/nestable/nestable.css')}}"></link>
    
@endpush
@section('jsMaster')
<script src="{{asset('assets/vendor/nestable/jquery.nestable.js')}}"></script>
    <script>
        let token = $('meta[name="crsf-token"]').attr('content');
        $(document).ready(function(){
            getData();
            $('.dd').nestable({});
            
        })
        $('.dd').on('change', function() {
            let data =  $('.dd').nestable('serialize');
            let param = JSON.stringify(data)
            $.ajax({
                url: "/master/process/head-unit",
                method: 'post',
                data:{data:param},
                headers:{
                    'X-CSRF-TOKEN':token
                },
                success:function(res){
                    // let data = res;
                    // let html='';
                    // res.forEach(element => {
                    //     html += `
                    //         <li class="dd-item" data-id="${element.id}">
                    //             <div class="dd-handle">${element.name}</div>
                    //         </li>
                    //     `
                    // });
                    // $('#header-dd-list').html(html)
                    console.log(res);
                },
                error:function(err){
                    console.log(err)
                }
            });
        });

        function getChild(id, res){
            let list = '<ol class="dd-list">';
            $.each(res, function(x, val){
                // console.log(val);

                if(val.id_head_unit !==null){
                    if(id === val.id_head_unit){
                        list +=`
                                    <li class="dd-item" data-id="${val.id}">
                                        <div class="dd-handle">${val.name}</div>
                                        ${getChild(val.id, res)}
                                    </li>
                                    
                                
                        `;
                    }
                }
            });
            list +='</ol>';
            return list;
        }

        function getData(){
            console.log('jalan');
            $.ajax({
                url: "/master/data/unit",
                method: 'get',
                success:function(res){
                    // let data = res;
                    let html='';
                    res.forEach(element => {
                        if(element.id_head_unit === null ){
                            html += `
                                <li class="dd-item" data-id="${element.id}">
                                    <div class="dd-handle">${element.name}</div>
                                        ${getChild(element.id, res)}
    
                                </li>
                            `
                        }
                        
                    });
                    $('#header-dd-list').html(html)
                    console.log(res);
                },
                error:function(err){
                    console.log(err)
                }
            });
        }
    </script>
@endsection