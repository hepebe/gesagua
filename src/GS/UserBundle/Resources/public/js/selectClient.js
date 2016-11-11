$(function(){
    var searchField = $('#textClient');
    var selectClient = $('#selectClient');
    
    searchField.keyup(function(evt){

        $.ajax({
            url: '/web/app_dev.php/claims/selectclient',
            method: "POST",
            data: "text=" + $(this).val() ,
            dataType: 'html',
            success: function(result, request) {

              var parsedData =JSON.parse(result);
                if(parsedData.status ==='success'){
                    selectClient.empty();
                    selectClient.html(parsedData.data);
                    if(selectClient.children().size()==1){
                        searchField.val($("#selectClient option:selected").text());
                        $("#gs_userbundle_claims_client").val($("#selectClient option:selected").val());
                    }
                }else{
                    selectClient.empty();
                    selectClient.html("<option>Ningún Cliente</option>");
                }
            }
        });
    });
    
    selectClient.change(function (evt){
        searchField.val($("#selectClient option:selected").text());
        $("#gs_userbundle_claims_client").val($("#selectClient option:selected").val());
    });
                    
});