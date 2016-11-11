$(function(){
    var searchField = $('#textStreet');
    var selectStreet = $('#selectStreet');
    
    searchField.keyup(function(evt){

        $.ajax({
            url: '/web/app_dev.php/contract/selectstreet',
            method: "POST",
            data: "text=" + $(this).val() ,
            dataType: 'html',
            success: function(result, request) {

              var parsedData =JSON.parse(result);
                if(parsedData.status ==='success'){
                    selectStreet.empty();
                    selectStreet.html(parsedData.data);
                    if(selectStreet.children().size()==1){
                        searchField.val($("#selectStreet option:selected").text());
                        $("#gs_userbundle_contract_street").val($("#selectStreet option:selected").val());
                    }
                }else{
                    selectStreet.empty();
                    selectStreet.html("<option>Ninguna Calle</option>");
                }
            }
        });
    });
    
    selectStreet.change(function (evt){
        searchField.val($("#selectStreet option:selected").text());
        $("#gs_userbundle_contract_street").val($("#selectStreet option:selected").val());
    });
                    
});