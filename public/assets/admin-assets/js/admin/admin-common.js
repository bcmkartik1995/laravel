$('#category_id').on('change', function () {
    // console.log(e);
    var cat_id = $(this).val();
    var _token = $("#form_subservice input[name='_token']").val();
    //console.log(cat_id);
    //ajax

    $.ajax({
        url: "/admin/ajax-subcat",
        type: 'POST',
        data: { cat_id: cat_id, _token: _token },
        success: function (data) {
            $('#sub_category_id').empty();
            $('#sub_category_id').append('<option value ="">Selecr Sub Category</option>');
            $.each(data, function (inedx, subcatObj) {
                //console.log(subcatObj.title);
                $('#sub_category_id').append('<option value ="' + subcatObj.id + '">' + subcatObj.title + '</option>');
            });
        }
    });

});


$('#edit_category_id').on('change', function () {
    // console.log(e);
    var cat_id = $(this).val();
    var _token = $("#form_subservice input[name='_token']").val();
    //console.log(cat_id);
    //ajax

    $.ajax({
        url: "/admin/ajax-subcat",
        type: 'POST',
        data: { cat_id: cat_id, _token: _token },
        success: function (data) {
            $('#edit_sub_category_id').empty();
            $('#edit_sub_category_id').append('<option value ="">Selecr Sub Category</option>');
            $.each(data, function (inedx, subcatObj) {
                //console.log(subcatObj.title);
                $('#edit_sub_category_id').append('<option value ="' + subcatObj.id + '">' + subcatObj.title + '</option>');
            });
        }
    });

});