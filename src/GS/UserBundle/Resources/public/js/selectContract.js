$(function(){
    var searchField = $('#textContract');
    var selectContract = $('#selectContract');
    
    searchField.keyup(function(evt){

        $.ajax({
            url: '/web/app_dev.php/counter/selectcontract',
            method: "POST",
            data: "text=" + $(this).val() ,
            dataType: 'html',
            success: function(result, request) {

              var parsedData =JSON.parse(result);
                if(parsedData.status ==='success'){
                    selectContract.empty();
                    selectContract.html(parsedData.data);
                    if(selectContract.children().size()==1){
                        searchField.val($("#selectContract option:selected").text());
                        $("#gs_userbundle_counter_contract").val($("#selectContract option:selected").val());
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
        $("#gs_userbundle_counter_contract").val($("#selectContract option:selected").val());
    });
                    
});