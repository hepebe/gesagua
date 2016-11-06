$(function(){
    var searchField = $('#searchcounter');
    var counterTable = $('#counterTable');
    var counterListDiv = $('#counterDivList');

    searchField.keyup(function(evt){

        $.ajax({
            url: '/web/app_dev.php/counter/searchcounter',
            method: "POST",
            data: "id=" + $(this).val() ,
            dataType: 'html',
            success: function(result, request) {

              var parsedData =JSON.parse(result);
                if(parsedData.status ==='success'){
                    counterListDiv.empty();
                    counterListDiv.html(parsedData.data);
                }else{
                    counterListDiv.empty();
                    counterListDiv.html("<p>Ningún contador encontrado</p>");
                }
            }
        });
    });
});