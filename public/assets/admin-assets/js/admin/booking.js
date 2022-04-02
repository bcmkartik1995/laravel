$( ".booking-status" ).on( "click", function() {
    var status = $(this).data('status');
    var id = $(this).data('id');
    //alert(id);

    html = '';
    if(status == 'pending'){
        html = '<p><strong>Click Below Button To Manage Order</strong></p>'+
        
        '<div class="mt-2">'+
            '<button class="btn btn-primary order-status mr-25" data-status="processing" data-id="'+id+'">processing</button>'+
            '<button class="btn btn-danger order-status mr-25"  data-status="declined" data-id="'+id+'">declined</button>'+
        '</div>'
    }else if(status == 'processing'){
        html = '<p><strong>Click Below Button To Manage Order</strong></p>'+
        
        '<div class="mt-2">'+
            '<button class="btn btn-primary order-status mr-25" data-status="on delivery" data-id="'+id+'">on delivery</button>'+
            '<button class="btn btn-danger order-status mr-25"  data-status="cancelled" data-id="'+id+'">cancelled</button>'+
        '</div>'
    }else if(status == 'on delivery'){
        html = '<p><strong>Click Below Button To Manage Order</strong></p>'+
        
        '<div class="mt-2">'+
            '<button class="btn btn-primary order-status mr-25" data-status="completed" data-id="'+id+'">completed</button>'+
            '<button class="btn btn-danger order-status mr-25"  data-status="cancelled" data-id="'+id+'">cancelled</button>'+
        '</div>'
    }

    Swal.fire({
        title: "What you want to do?",
        customClass: 'swal-wide',
        showConfirmButton: false,
        showCloseButton: true,
        html: html
    });
    $(document).on('click','.order-status',function(){
    //id = $(this).data('id');
    status = $(this).data('status');
    id = $(this).data('id');
    //alert(id);
    var _token = $("input[name='_token']").val();
        $.ajax({
            
            url: "/admin/orders-status",
            type: 'POST',
            data: { status: status,id: id, _token: _token },
            success: function (bookings) {
                //console.log(bookings.status);
               
                if(bookings.status == 'pending'){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-info">' + 'pending' + '</span>');
                    Swal.close();
                }
                if(bookings.status == 'processing'){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-primary">' + 'processing' + '</span>');
                    Swal.close();
                }
                if(bookings.status == 'completed'){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-success">' + 'completed' + '</span>');
                    Swal.close();
                }
                if(bookings.status == 'declined'){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-danger">' + 'declined' + '</span>');
                    Swal.close();
                }
                if(bookings.status == 'on delivery'){
                    $('.span-'+id).empty();
                    $('.span-'+id).html('<span class="badge badge-pill badge-light-warning">' + 'on delivery' + '</span>');
                    Swal.close();
                }
                window.location.reload();
            }    
        });
    });

});
