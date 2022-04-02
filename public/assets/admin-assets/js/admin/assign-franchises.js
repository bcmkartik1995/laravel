$( ".assign-franchises" ).on( "click", function() {
    var id = $(this).data('id');
    var _token = $("input[name='_token']").val();
    $('#order_id').val(id);
    $('#frenchise-assing-modal').modal();
    //alert(id);
    $.ajax({
        url: "/admin/assign-franchises",
        type: 'GET',
        data: { id: id, _token: _token },
        success: function (franchises_order) {
            $('#franchises_id').empty();
            $('#franchises_id').append('<option value ="">Select Frenchise</option>');
            $.each(franchises_order, function (inedx, subcatObj) {
                //console.log(subcatObj.title);
                $('#franchises_id').append('<option value ="' + subcatObj.id + '">' + subcatObj.franchise_name + '</option>');
            });
            //console.log(franchises_order);
        }    
    });



});