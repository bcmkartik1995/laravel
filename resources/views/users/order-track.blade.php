@extends('layouts.front')
@section('content')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/front-assets/css/plugin/datatables/dataTables.bootstrap4.min.css') }}" media="screen">
@endsection

<section class="user-dashbord">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="user-profile-info-area">
                    @include('includes.front.dashboard-links')
                </div>
            </div>

            <div class="col-lg-9">
                <div class="user-profile-details">
                    <div class="order-history">
                        <div class="header-area d-flex align-items-center">
                            <h4 class="title">{{ $langg->lang772 }}</h4>
                        </div>
                            <div class="order-tracking-content">
                                <form method="post" data-action="{{route('user-get-order-track')}}" id="t-form" class="tracking-form">
                                    @csrf
                                    <div class="d-flex">
                                        <div class="form-group mb-0 w-100">
                                            <input type="text" class="form-controls" name="track_code" id="track_code" placeholder="Enter order number">
                                        </div>
                                        <div class="subscribe-btn">
                                            <button class="subscribe-btn-text btn btn-track-order">View Tracking</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="order-tracking-modal" tabindex="-1" role="dialog" aria-labelledby="order-tracking-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"> <b>Order Tracking</b> </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="order-track">

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/front-assets/js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/front-assets/js/plugin/datatables/dataTables.bootstrap4.min.js') }}"></script>


<script>
    $('#example').DataTable();

    $('#t-form').submit(function(){

        $('#t-form .error').remove();
        url = $(this).data('action');
        $('#order-track').html('');
        $.ajax({
            url : url,
            type : 'POST',
            datatype:'json',
            data : $('#t-form').serialize(),
            success : function(data) {

                if(data.success){
                    $('#order-tracking-modal').modal()
                    $('#t-form').find('.alert-success').show();
                    $('#t-form').find('.alert-success .message-span').html(data.message);
                    setTimeout(function(){
                        $('#t-form').find('.alert-success').hide(1000);
                        $('#t-form').find('.alert-success .message-span').html('');
                    }, 3000);

                    html = '';
                    if(data.order_tracks.length){
                        html += '<div class="tracking-steps-area">'+
                                    '<ul class="tracking-steps">';
                                        $.each(data.order_tracks, function(i, val){
                                            html += '<li class="'+(data.datas.includes(val.title)?'active':'')+'">'+
                                                        '<div class="icon">'+(i+1)+'</div>'+
                                                        '<div class="track-content">'+
                                                                '<h4 class="title">'+val.title+'</h4>'+
                                                                '<p class="date">'+val.created_time+'</p>'+
                                                                '<p class="details">'+val.text+'</p>'+
                                                        '</div>'+
                                                    '</li>'
                                        });
                        html +=     '</ul>'+
                                '</div>';

                    }else{
                        html =  '<h5 class="text-center">No Order Tracking Found</h5>';
                    }

                    $('#order-track').html(html);
                }else{
                    $.each(data.errors, function(key,value){
                        $('#t-form').append('<label id="'+key+'-error" class="error" for="'+key+'">'+value[0]+'</label>');
                    });
                }
            }
        });
        return false;
    });
</script>
@endsection
