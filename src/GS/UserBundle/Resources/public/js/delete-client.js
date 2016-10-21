$(document).ready(function(){
    $('.btn-delete').click(function(g){
       g.preventDefault();
       
       var row= $(this).parents('tr');
       
       var id= row.data('id');
       
       //alert(id);
       
       var form= $('#form-delete');
       
       var url = form.attr('action').replace(':CLIENT_ID', id);
       
       var data = form.serialize();
       
       //alert(data);
       
       bootbox.confirm(message, function(res){
          if(res == true){
              $.post(url, data, function(result){
                 if(result.removed == 1){
                     row.fadeOut();
                     $('#message').removeClass('hidden');
                     $('#user-message').text(result.message);
                 }
              });
          } 
       });
       
    });
});