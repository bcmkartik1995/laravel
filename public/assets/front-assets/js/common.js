
$(window).on('load', function () {

    /*---------------------
        Preloader
    -----------------------*/
    var preLoder = $("#preloader");
    preLoder.hide();
    var backtoTop = $('.back-to-top')
    /*-----------------------------
        back to top
    -----------------------------*/
    // var backtoTop = $('.bottomtotop')
    // backtoTop.fadeOut(100);
});

$(document).ready(function() {

    $('#btn-forgot-pass').click(function(){

        $('#login .close').trigger('click');
        $('#forgot-pass-modal').modal();
    });


    $('#btn-register,#btn-login').click(function(){
        $this = $('#sign_in');
        $this.find('.alert-success').hide();
        $this.find('.alert-danger').hide();
        $this.find('.alert-danger span.text-left').html('');
        $this.find('.alert-success span.text-left').html('');


        $this = $('#login');
        $this.find('.alert-success').hide();
        $this.find('.alert-danger').hide();
        $this.find('.alert-danger span.text-left').html('');
        $this.find('.alert-success span.text-left').html('');

        $this = $('#forgot-pass-modal');
        $this.find('.alert-success').hide();
        $this.find('.alert-danger').hide();
        $this.find('.alert-danger span.text-left').html('');
        $this.find('.alert-success span.text-left').html('');
    });

    $('#frm-forgot-pass').on('submit', function (e) {
        var $this = $(this).parent();
        e.preventDefault();
        $this.find('button.submit-btn').prop('disabled', true);


        $.ajax({
          method: "POST",
          url: $(this).data('action'),
          data: new FormData(this),
          dataType: 'JSON',
          contentType: false,
          cache: false,
          processData: false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            console.log(data)
            if ((data.errors)) {
                $this.find('.alert-success').hide();
                $this.find('.alert-danger').show();
                $this.find('.alert-danger').html('');
                $.each( data.errors, function( key, value ) {
                    $('#forgot-pass-modal .alert-danger').html( value[0]);
                });
            } else {
                $this.find('.alert-danger').hide();
                $this.find('.alert-success').show();
                $this.find('.alert-success').html(data.message);
                $('#frm-forgot-pass')[0].reset();

            }
            $this.find('button.submit-btn').prop('disabled', false);
        },
        error: function (data) {
            var data = $.parseJSON(data.responseText);

            if ((data.errors)) {

                $this.find('.alert-success').hide();
                $this.find('.alert-danger').show();
                $this.find('.alert-danger').html('');
                $.each( data.errors, function( key, value ) {
                    $('#forgot-pass-modal .alert-danger').html( value[0]);
                });

            }
            $this.find('button.submit-btn').prop('disabled', false);
        }


        });
    });

    $("#send_form").on('submit', function (e) {
        var $this = $(this).parent();
        e.preventDefault();
        $this.find('button.submit-btn').prop('disabled', true);
        var authdata = $this.find('.mauthdata').val();
        $('#send_form .alert-info p').html(authdata);
        $.ajax({
          method: "POST",
          url: $(this).data('action'),
          data: new FormData(this),
          dataType: 'JSON',
          contentType: false,
          cache: false,
          processData: false,
          success: function (data) {
            if ((data.errors)) {
              $this.find('.alert-success').hide();
              $this.find('.alert-danger').show();
              $this.find('.alert-danger').html('');
              $('#sign_in .alert-danger').html( data.errors);
            } else {
              $this.find('.alert-danger').hide();
              $this.find('.alert-success').show();
              $this.find('.alert-success').html('Success !');
              if (data == 1) {
                location.reload();
              } else {
                window.location = data;
              }

            }
            $this.find('button.submit-btn').prop('disabled', false);
          }

        });

    });
    // MODAL LOGIN FORM

    $("#post-form-login").on('submit', function (e) {
        var $this = $(this).parent();
        form_data = new FormData($("#post-form-login").get(0));

        $this.find('button.submit-btn').prop('disabled', true);
        $this.find('.alert-info').show();
        $this.find('.alert-info span.text-left').html($('#authdata').val());
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: $(this).data('action'),
            data: form_data,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {

                if ((data.error)) {
                    $this.find('.alert-success').hide();
                    $this.find('.alert-info').hide();
                    $this.find('.alert-danger').show();
                    $this.find('.alert-danger ul').html('');
                    for(var err in data.error) {
                        $this.find('.alert-danger span.text-left').html(data.error[err]);
                    }
                } else {
                    $this.find('.alert-info').hide();
                    $this.find('.alert-danger').hide();
                    $this.find('.alert-success').show();
                    $this.find('.alert-success span.text-left').html('Success !');
                    window.location = data;
                }
                $this.find('button.submit-btn').prop('disabled',false);

            }

        });
        return false;
    });

    function printErrorMsg (msg) {
         $(".print-error-msg-login").html('');
         $(".print-error-msg-login").css('display','none');
        // $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg-login-"+key).html(value);
            $(".print-error-msg-login-"+key).css('display','block');
        });
    }

    $("#register").on("click", function(e){
        var _token = $("#registerprofessional input[name='_token']").val();
        var country_id = $("#registerprofessional input[name='country_id']").val();
        var state_id = $("#registerprofessional input[name='state_id']").val();
        var city_id = $("#registerprofessional input[name='city_id']").val();
        var mobile = $("#registerprofessional input[name='mobile']").val();
        var name = $("#registerprofessional input[name='name']").val();
        var email = $("#registerprofessional input[name='email']").val();
        var skill = $("#registerprofessional input[name='skill']").val();

        $.ajax({
            url : '/registerprofessional',
            type : 'POST',
            data : {
            _token : _token,
            country_id : country_id,
            state_id : state_id,
            city_id : city_id,
            mobile : mobile,
            name : name,
            email : email,
            skill : skill
            },
            success : function(data) {
            if($.isEmptyObject(data.error)){
                $("#registerprofessional")[0].reset();
                //$(".print-error-msg").css('display','none');
                //alert('The data was saved successfully');
                $(".print-error-msg-login").html('');
                $(".print-error-msg-login").css('display','none');
                $(".print-success-msg-login").html('successfully');
                $(".print-success-msg-login").css('display','block');
            }else{
            //$("#post-form")[0].reset();
                $(".print-danger-msg-login").html('Invalide User');
                $(".print-danger-msg-login").css('display','block');
                printErrorMsg(data.error);
            }
            }
        });
        return false;
    });

    function printErrorMsg (msg) {
        $(".print-error-msg").html('');
        $(".print-error-msg").css('display','none');
        // $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {

            $(".print-error-msg-"+key).html(value);
            $(".print-error-msg-"+key).css('display','block');
        });
    }

    $('#frm_subscribe_form').submit(function(){

        $('#frm_subscribe_form .error').remove();
        url = $(this).data('action');
        $.ajax({
            url : url,
            type : 'POST',
            data : $('#frm_subscribe_form').serialize(),
            success : function(data) {
                if(data.success){
                    $('#frm_subscribe_form')[0].reset();
                    //Swal.fire("Success", data.message, "success");
                    $('#frm_subscribe_form').find('.alert-success').show();
                        $('#frm_subscribe_form').find('.alert-success .message-span').html(data.message);
                        $('#frm_subscribe_form')[0].reset();
                        setTimeout(function(){
                            $('#frm_subscribe_form').find('.alert-success').hide(1000);
                            $('#frm_subscribe_form').find('.alert-success .message-span').html('');
                        }, 3000);
                }else{

                    $.each(data.errors, function(key,value){
                        $('#frm_subscribe_form').append('<label id="'+key+'-error" class="error" for="'+key+'">'+value[0]+'</label>');
                    });
                }

            }
        });
        return false;
    });

    $('body').on('click','.btn-remove-cart', function(){
        var id = $(this).data('id');
        var type = $(this).data('type');
        var url = $(this).data('url');
        // Swal.fire({
        //     title: 'Are you sure ?',
        //     text: "You want to remove this item from cart !",
        //     type: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#DD6B55',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'Yes, remove it!',
        //     confirmButtonClass: 'btn btn-primary',
        //     cancelButtonClass: 'btn btn-danger ml-1',
        //     buttonsStyling: false,
        // }).then(function (result) {
        //     if (result.value) {
                $.ajax({
                    header:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type : "post",
                    dataType:'json',
                    data : {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "id": id,
                        "type": type
                    },
                    success : function(data) {
                        if(data.success){
                            window.location.reload();
                        }

                    }
                });
                return false;
        //     }
        // });
    });

    $('.cart-container').on('click','.btn-view-cart', function(){
        $.ajax({
            header:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            url : '/create_cart_session',
            type : "post",
            dataType:'json',
            data : {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "action": 'view-cart'
            },
            success : function(data) {
                if(data.isUserLogin){
                    window.location.href= data.url;
                }else{
                    $('#btn-login').trigger('click');
                }
            }
        });
    });

    $('.btn-view-cart-2').on('click', function(){
        $.ajax({
            header:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            url : '/create_cart_session',
            type : "post",
            dataType:'json',
            data : {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "action": 'view-cart'
            },
            success : function(data) {
                if(data.isUserLogin){
                    window.location.href= data.url;
                }else{
                    $('#btn-login').trigger('click');
                }
            }
        });
    });

});

function go_to_cart(){
    $.ajax({
        header:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        },
        url : '/create_cart_session',
        type : "post",
        dataType:'json',
        data : {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "action": 'view-cart'
        },
        success : function(data) {
            if(data.isUserLogin){
                window.location.href= data.url;
            }else{
                $('#btn-login').trigger('click');
            }
        }
    });
}
$(document).ready(function(){
    $('.service-search-alert').keyup(function(){
        Swal.fire({
            title: 'Info',
            text: 'Please select location',
            icon: "info",
            showCancelButton: false,
            confirmButtonColor: "#ff7400",
            confirmButtonClass: "btn btn-go",
            closeOnConfirm: true,
        }).then(function (result) {
            if(isIndex){
                $('html, body').animate({
                    scrollTop: $(".main-slider").offset().top
                }, 1000);
            }else{
                window.location.href = isIndexPageUrl;
            }

        });
    });
    $('.service-search').typeahead({
        source: function (query, cb) {
            $.ajax({
                url : $('.service-search').data('url'),
                type : 'get',
                data:{query: query,"_token": $('meta[name="csrf-token"]').attr('content'),},
                dataType : 'json',
                success: function (response, textStatus, jqXHR) {
                    cb(response);
                }
            });
        },
        minLength : 1,
        autoSelect:false,
        displayText: function(item) {
            return item.title
        },
        afterSelect: function(item) {
            url = isIndexPageUrl + '/serviceList' + '/' + item.category_slug;
            window.location.href = url;
            return item;
        }
    });
});



