$(function(){
    var searchField = $('#searchclaims');
    var claimsTable = $('#claimsTable');
    var claimsListDiv = $('#claimsDivList');

    searchField.keyup(function(evt){

        $.ajax({
            url: '/web/app_dev.php/claims/searchclaims',
            method: "POST",
            data: "id=" + $(this).val() ,
            dataType: 'html',
            success: function(result, request) {

              var parsedData =JSON.parse(result);
                if(parsedData.status ==='success'){
                    claimsListDiv.empty();
                    claimsListDiv.html(parsedData.data);
                }else{
                    claimsListDiv.empty();
                    claimsListDiv.html("<p>Ninguna reclamación encontrada</p>");
                }
            }
        });
    });
});