$(function(){

        var searchField = $('#searchbill');
        var billTable = $('#billTable');
        var billListDiv = $('#billDivList');

        searchField.keyup(function(evt){

            $.ajax({
                url: '/web/app_dev.php/bill/searchbill',
                method: "POST",
                data: "id=" + $(this).val() ,
                dataType: 'html',
                success: function(result, request) {

                  var parsedData =JSON.parse(result);
                    if(parsedData.status ==='success'){
                        billListDiv.empty();
                        billListDiv.html(parsedData.data);
                    }else{
                        billListDiv.empty();
                        billListDiv.html("<p>Ninguna factura encontrada</p>");
                    }
                }
            });
        });
    });