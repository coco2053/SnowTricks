$(document).on('click', 'button.ajax', function() {

    $.ajax({
        url:"/loadmore",
        type: "POST",
        dataType: "json",
        data: {
            "limit": 10
        },
        async: true,
        success: function (data)
        {
            console.log(data)
            $('div#ajax-results').html(data.output);

        }
    });
    return false;

});

