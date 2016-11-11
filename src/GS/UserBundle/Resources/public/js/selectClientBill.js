$(function(){
    var searchField = $('#textClient');
    var selectClient = $('#selectClient');
    var selectContract = $('#selectContract');
    var textContract = $('#textContract');
    
    searchField.keyup(function(evt){

        $.ajax({
            url: '/web/app_dev.php/bill/selectclient',
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
                        $("#gs_userbundle_bill_client").val($("#selectClient option:selected").val());
                        selectContract.prop( "disabled", false );
                        textContract.prop( "disabled", false );
                        $.ajax({
                            url: '/web/app_dev.php/bill/fillcontract',
                            method: "POST",
                            data: "id=" + selectClient.val() ,
                            dataType: 'html',
                            success: function(result, request) {
                              var parsedData =JSON.parse(result);
                                if(parsedData.status ==='success'){
                                    selectContract.empty();
                                    selectContract.html(parsedData.data);
                                    if(selectContract.children().size()==1){
                                        searchField.val($("#selectContract option:selected").text());
                                        $("#gs_userbundle_bill_contract").val($("#selectContract option:selected").val());
                                        
                                    }
                                }else{
                                    selectContract.empty();
                                    selectContract.html("<option>Ningún Contrato</option>");
                                }
                            }
                        });
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
        $("#gs_userbundle_bill_client").val($("#selectClient option:selected").val());
        selectContract.prop( "disabled", false );
        textContract.prop( "disabled", false );
        $.ajax({
            url: '/web/app_dev.php/bill/fillcontract',
            method: "POST",
            data: "id=" + selectClient.val() ,
            dataType: 'html',
            success: function(result, request) {
              var parsedData =JSON.parse(result);
                if(parsedData.status ==='success'){
                    selectContract.empty();
                    selectContract.html(parsedData.data);
                    if(selectContract.children().size()==1){
                        searchField.val($("#selectContract option:selected").text());
                        $("#gs_userbundle_bill_contract").val($("#selectContract option:selected").val());
                        
                    }
                }else{
                    selectContract.empty();
                    selectContract.html("<option>Ningún Contrato</option>");
                }
            }
        });
    });
                    
});