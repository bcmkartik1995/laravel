$(document).ready(function(){

    $('.common-toggle-button').click(function(){

        var id = $(this).data('id');
        var action = $(this).data('action');
        //alert(action);
        var obj = $(this);
        $.ajax({
            header:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            url: 'toggle-status',
            type: "POST",
            dataType: "json",
            data: {'action': action, 'id': id, "_token": $('meta[name="csrf-token"]').attr('content')},
            success: function(data){
                
                if (obj.hasClass('btn-danger')) {
                obj.html('Active').addClass('btn-success').removeClass('btn-danger');
                $('.status-span-'+id).html('Inactive');
                } else{
                    obj.html('InActive').removeClass('btn-success').addClass('btn-danger');
                    $('.status-span-'+id).html('Active');
                    //$(this).html('InActive').toggleClass('btn-danger');
                }
            }

        });

    });
    
});