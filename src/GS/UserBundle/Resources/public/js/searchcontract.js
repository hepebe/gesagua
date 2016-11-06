$(function(){
    var searchField = $('#searchcontract');
    var contractTable = $('#contractTable');
    var contractListDiv = $('#contractDivList');

    searchField.keyup(function(evt){

        $.ajax({
            url: '/web/app_dev.php/contract/searchcontract',
            method: "POST",
            data: "id=" + $(this).val() ,
            dataType: 'html',
            success: function(result, request) {

              var parsedData =JSON.parse(result);
                if(parsedData.status ==='success'){
                    contractListDiv.empty();
                    contractListDiv.html(parsedData.data);
                }else{
                    contractListDiv.empty();
                    contractListDiv.html("<p>Ningún contrato encontrado</p>");
                }
            }
        });
    });
});