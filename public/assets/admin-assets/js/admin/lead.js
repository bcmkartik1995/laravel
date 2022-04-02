$('#country_id').on('change', function () {
    // console.log(e);
    var country_id = $(this).val();
    var _token = $("#form_lead input[name='_token']").val();
    //console.log(cat_id);
    //ajax

    $.ajax({
        url: "/admin/ajax-country",
        type: 'POST',
        data: { country_id: country_id, _token: _token },
        success: function (data) {
            $('#state_id').empty();
            $('#state_id').append('<option value ="">Select State</option>');
            $.each(data, function (inedx, subcatObj) {
                //console.log(subcatObj.title);
                $('#state_id').append('<option value ="' + subcatObj.id + '">' + subcatObj.name + '</option>');
            });
        }
    });

});


$('#state_id').on('change', function () {
    // console.log(e);
    var state_id = $(this).val();
    var _token = $("#form_lead input[name='_token']").val();
    //console.log(cat_id);
    //ajax

    $.ajax({
        url: "/admin/ajax-state",
        type: 'POST',
        data: { state_id: state_id, _token: _token },
        success: function (data) {
            $('#city_id').empty();
            $('#city_id').append('<option value ="">Select City</option>');
            $.each(data, function (inedx, subcatObj) {
                //console.log(subcatObj.title);
                $('#city_id').append('<option value ="' + subcatObj.id + '">' + subcatObj.name + '</option>');
            });
        }
    });

});


$( ".status" ).on( "click", function() {
    var id = $(this).data('id');
Swal.fire({
    title: "What you want to do?",
    icon: "warning",
    customClass: 'swal-wide',
    showConfirmButton: false,
    showCloseButton: true,
    html: '<p><strong>Click Below Button To Manage Lead</strong></p>'+
      '<div class="mt-2">'+
        '<button class="btn btn-success lead-status mr-25" data-id="'+id+'" data-action="1">Accept</button>'+
        '<button class="btn btn-danger lead-status mr-25"  data-id="'+id+'" data-action="2">Decline</button>'+
      '</div>'
});

    $(document).on('click','.lead-status',function(){
    id = $(this).data('id');
    action =  $(this).data('action');
        //alert(action);
    var _token = $("input[name='_token']").val();
        $.ajax({
            
            url: "/admin/lead-status",
            type: 'POST',
            data: { id: id, action: action, _token: _token },
            success: function (leads) {
                //console.log(leads.status);
                if(leads.status == 0){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-info">' + 'Pending' + '</span>');
                    Swal.close();
                }
                if(leads.status == 1){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-success">' + 'Accept' + '</span>');
                    Swal.close();
                }
                if(leads.status == 2){Swal.close()
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-danger">' + 'Decline' + '</span>');
                    Swal.close();
                }
                
            }    
        });
    });

});


