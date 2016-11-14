$(document).ready(function () {
    $('#additems').submit(function () {        
        var fd = new FormData(document.forms.additems);
        $.ajax({
            url: "proccess.php",
            type: "post",
            data:fd,
            processData: false,
            contentType: false,
            success: function (data) { 
                $('#additems')[0].reset();
                $('.all_items').empty();
                $.each(data, function(i,items){
                    $('.all_items').append(items.name);
                });                
           }
        });
        return false;
    });
});