$(function(){
    var searchField = $('#searchstreet');
    var streetTable = $('#streetTable');
    var streetListDiv = $('#streetDivList');

    searchField.keyup(function(evt){

        $.ajax({
            url: '/web/app_dev.php/street/searchstreet',
            method: "POST",
            data: "id=" + $(this).val() ,
            dataType: 'html',
            success: function(result, request) {

              var parsedData =JSON.parse(result);
                if(parsedData.status ==='success'){
                    streetListDiv.empty();
                    streetListDiv.html(parsedData.data);
                }else{
                    streetListDiv.empty();
                    streetListDiv.html("<p>Ninguna calle encontrada</p>");
                }
            }
        });
    });
});