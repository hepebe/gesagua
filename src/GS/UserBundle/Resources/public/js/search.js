$(function(){

        var searchField = $('#search');
        var clientTable = $('#clientTable');
        var clientListDiv = $('#clientDivList');

        searchField.keyup(function(evt){

            $.ajax({
                url: '/web/app_dev.php/client/search',
                method: "POST",
                data: "id=" + $(this).val() ,
                dataType: 'html',
                success: function(result, request) {

                  var parsedData =JSON.parse(result);
                    if(parsedData.status ==='success'){
                        clientListDiv.empty();
                        clientListDiv.html(parsedData.data);
                    }else{
                        clientListDiv.empty();
                        clientListDiv.html("<p>Ningún cliente encontrado</p>");
                    }
                }
            });
        });
    });