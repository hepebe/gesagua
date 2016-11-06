function guardarLectura(ncontador, zone){
    var lectura = $('#lectura').val();
    var readDiv = $('#readDiv');
    
    if(lectura==""){
        alert("Por favor, introduzca el valor de la lectura")
    }else{
        $.ajax({
            url: '/web/app_dev.php/reading/savereading',
            method: "POST",
            data: "ncontador="+ncontador+"&lectura="+lectura+"&zone="+zone,
            dataType: 'html',
            
            success: function(result, request) {
              var parsedData =JSON.parse(result);
                if(parsedData.status ==='success'){
                    readDiv.empty();
                    readDiv.html(parsedData.data);
                }else{
                    readDiv.empty();
                    readDiv.html("<p>Zona finalizada</p><br><br><a href='http://gesagua-helenapbe.c9users.io/web/app_dev.php/reading/viewzones' class='btn btn-sm btn-info'>Atrás</a>");
                }
            }
        }); 
    }
         
}