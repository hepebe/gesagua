$(function(){
        var searchField = $('#selectZone');
        var contractTable = $('#contractTable');
        var contractListDiv = $('#contractDivList');

        searchField.change(function(evt){
            $.ajax({
                url: '/web/app_dev.php/reading/searchzone',
                method: "POST",
                data: "id=" + $("#selectZone option:selected").attr('name'),
                dataType: 'html',
                success: function(result, request) {

                  var parsedData =JSON.parse(result);
                    if(parsedData.status ==='success'){
                        contractListDiv.empty();
                        contractListDiv.html(parsedData.data);
                    }else{
                        contractListDiv.empty();
                    }
                }
            });
        });
    });