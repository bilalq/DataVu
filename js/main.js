$(document).ready( function(){
  
  var infoList = $('div#info');

  $('li.active').on('click', function() {
    $.ajax({
      type: 'POST',
      url: 'backend/controller.php',
      data: {'lens': 'groupon'},
      success: function(response) {
        console.log("response: " +  response);
      }
    });
  })

}); //end docReady
