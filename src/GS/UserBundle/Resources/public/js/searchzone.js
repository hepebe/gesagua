$(function(){
        var searchField = $('#searchzone');
        var zoneTable = $('#zoneTable');
        var zoneListDiv = $('#zoneDivList');

        searchField.keyup(function(evt){

            $.ajax({
                url: '/web/app_dev.php/zone/searchzone',
                method: "POST",
                data: "id=" + $(this).val() ,
                dataType: 'html',
                success: function(result, request) {

                  var parsedData =JSON.parse(result);
                    if(parsedData.status ==='success'){
                        zoneListDiv.empty();
                        zoneListDiv.html(parsedData.data);
                    }else{
                        zoneListDiv.empty();
                        zoneListDiv.html("<p>Ninguna zona encontrada</p>");
                    }
                }
            });
        });
    });