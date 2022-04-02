$(window).on('load', function(){
    $.ajaxSetup({
        statusCode: {
            419: function(){
                    location.reload(); 
                }
        }
    });
});