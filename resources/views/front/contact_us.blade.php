@extends('layouts.front')

@section('content')
<div class="about-section ">
    <div class="container mt-5 mb-5">

        <div class="map-section">
            <div class="map-img">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 col-sm-12">
                        <h2 class="title-contain">Contact Us</h2>
                             <form id="frm-contact-us" data-action="{{route('contact_us_save')}}" method="POST" enctype="multipart/form-data">
                                @include('includes.front.ajax-message')
                                @csrf

                                <div class="form-row">
                                    <div class="col">
                                        <input type="text" class="form-control" name="contact_name" placeholder="Name" value="{{old('contact_name')}}">
                                        @error('contact_name')
                                            <label id="contact_name-error" class="error" for="contact_name">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col">
                                        <input type="text" class="form-control" name="contact_email" placeholder="E-mail" value="{{old('contact_email')}}">
                                        @error('contact_email')
                                            <label id="contact_email-error" class="error" for="contact_email">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col">

                                        <input type="text" class="form-control" name="contact_phone" placeholder="Phone" value="{{old('contact_phone')}}">
                                        @error('contact_phone')
                                            <label id="contact_phone-error" class="error" for="contact_phone">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <textarea type="text" class="form-control" name="contact_message" placeholder="Message" rows="4">{{old('contact_message')}}</textarea>
                                        @error('contact_message')
                                            <label id="contact_message-error" class="error" for="contact_message">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row btn-center text-center">
                                    <div class="col-md-12">
                                        <button class="sub-btn-book btn-book" href="#">Submit</button>
                                    </div>
                                </div>
                                 <!-- <button class="btn  my-4 btn-block btn-submit-req" type="submit"></button> -->
                            </form>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="map-area">
                            <iframe src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=velox solutions jamnagar&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
$('#frm-contact-us').submit(function(){

    $('#frm-contact-us .error').remove();
    url = $(this).data('action');
    $.ajax({
        url : url,
        type : 'POST',
        datatype:'json',
        data : $('#frm-contact-us').serialize(),
        success : function(data) {

            if(data.success){
                $('#frm-contact-us').find('.alert-success').show();
                $('#frm-contact-us').find('.alert-success .message-span').html(data.message);
                $('#frm-contact-us')[0].reset();
                setTimeout(function(){
                    $('#frm-contact-us').find('.alert-success').hide(1000);
                    $('#frm-contact-us').find('.alert-success .message-span').html('');
                }, 3000);
                // Swal.fire("Success", data.message, "success");
            }else{
                $.each(data.errors, function(key,value){
                    $("[name='"+key+"']").after('<label id="'+key+'-error" class="error" for="'+key+'">'+value[0]+'</label>');
                });
            }
        }
    });
    return false;
});
</script>
@endsection
