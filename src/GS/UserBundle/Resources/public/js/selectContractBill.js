$(function(){
    var searchField = $('#textContract');
    var selectContract = $('#selectContract');
    var selectClient = $('#selectClient');
    
    searchField.keyup(function(evt){

        $.ajax({
            url: '/web/app_dev.php/bill/selectcontract',
            method: "POST",
            data: "text=" + $(this).val() + "&id=" + selectClient.val() ,
            dataType: 'html',
            success: function(result, request) {

              var parsedData =JSON.parse(result);
                if(parsedData.status ==='success'){
                    selectContract.empty();
                    selectContract.html(parsedData.data);
                    if(selectContract.children().size()==1){
                        searchField.val($("#selectContract option:selected").text());
                        $("#gs_userbundle_bill_contract").val($("#selectContract option:selected").val());
                        if($('#gs_userbundle_bill_tarifa').val()!=""){
                            $('#gs_userbundle_bill_save').prop( "disabled", false );
                        }
                    }
                }else{
                    selectContract.empty();
                    selectContract.html("<option>Ningún Contrato</option>");
                }
            }
        });
    });
    
    selectContract.change(function (evt){
        searchField.val($("#selectContract option:selected").text());
        $("#gs_userbundle_bill_contract").val($("#selectContract option:selected").val());
        if($('#gs_userbundle_bill_tarifa').val()!=""){
            $('#gs_userbundle_bill_save').prop( "disabled", false );
        }
    });
         
    $('#gs_userbundle_bill_tarifa').change(function (evt){
        if(selectContract.val()!=""){
            $('#gs_userbundle_bill_save').prop( "disabled", false );
        }
    });        
});