$(document).ready( function(){
  
  var infoList = $('div#info');

  $.ajax({
    type: 'POST',
    url: 'backend/controller.php',
    data: 'twitter',
    success: function(response) {
      console.log(response);
    }

}); //end docReady
