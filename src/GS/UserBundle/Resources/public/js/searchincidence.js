$(function(){
    var searchField = $('#searchincidence');
    var incidenceTable = $('#incidenceTable');
    var incidenceListDiv = $('#incidenceDivList');

    searchField.keyup(function(evt){

        $.ajax({
            url: '/web/app_dev.php/incidence/searchincidence',
            method: "POST",
            data: "id=" + $(this).val() ,
            dataType: 'html',
            success: function(result, request) {

              var parsedData =JSON.parse(result);
                if(parsedData.status ==='success'){
                    incidenceListDiv.empty();
                    incidenceListDiv.html(parsedData.data);
                }else{
                    incidenceListDiv.empty();
                    incidenceListDiv.html("<p>Ninguna incidencia encontrada</p>");
                }
            }
        });
    });
});