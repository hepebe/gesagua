$(function(){
    var searchField = $('#textZone');
    var selectZone = $('#selectZone');
    
    searchField.keyup(function(evt){

        $.ajax({
            url: '/web/app_dev.php/street/selectzone',
            method: "POST",
            data: "text=" + $(this).val() ,
            dataType: 'html',
            success: function(result, request) {

              var parsedData =JSON.parse(result);
                if(parsedData.status ==='success'){
                    selectZone.empty();
                    selectZone.html(parsedData.data);
                    if(selectZone.children().size()==1){
                        searchField.val($("#selectZone option:selected").text());
                        $("#street_zone").val($("#selectZone option:selected").val());
                    }
                }else{
                    selectZone.empty();
                    selectZone.html("<option>Ninguna Zona</option>");
                }
            }
        });
    });
    
    selectZone.change(function (evt){
        searchField.val($("#selectZone option:selected").text());
        $("#street_zone").val($("#selectZone option:selected").val());
    });
                    
});