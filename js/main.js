$(document).ready( function(){
  
  var infoList = $('div#info');
  var twitterData = "";
  var grouponData = "";
  var canvas = $('canvas');

  $('li#twitter').on('click', function() {
    if (twitterData.length == 0) {
      $.ajax({
        type: 'POST',
        url: 'backend/controller.php',
        data: {'lens': 'twitter'},
        success: function(response) {
          for (var i = 0; i < response.length; i++) {
            twitterData = response[i];
          };
        }
      });
    }else{
      //else
    };
  })

  function drawTweets (target) {
    for (var i = 0; i < target.length; i++) {
      var current = target[i];
      var lat = current.lat;
      var lng = current.lng;
      var pic = current.img;

      $('<img id="' .current._id.id .'" src="' + pic + '"/>')

    };
  }

}); //end docReady
