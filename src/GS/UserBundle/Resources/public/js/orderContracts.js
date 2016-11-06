function down(id){
    var contractTable = $('#contractTable');
    var contractListDiv = $('#contractDivList');
    $.ajax({
        url: '/web/app_dev.php/reading/downcontract',
        method: "POST",
        data: "id=" + id,
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
}
function up(id){
    var contractTable = $('#contractTable');
    var contractListDiv = $('#contractDivList');
    $.ajax({
        url: '/web/app_dev.php/reading/upcontract',
        method: "POST",
        data: "id=" + id,
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
}