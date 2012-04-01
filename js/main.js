$(document).ready( function(){
  
  var infoList = $('div#info');
  var twitterData = "";
  var grouponData = "";
  var canvas = $('div#map');
  var entry = $('img#start');

  function random () {
    return Math.floor(Math.random()*30);
  }
  $('li#twitter').on('click', function() {
    if (twitterData.length == 0) {
      $.ajax({
        type: 'POST',
        url: 'backend/controller.php',
        data: {'lens': 'twitter'},
        success: function(response) {
            twitterData = response;
            drawTweets(twitterData);
        }
      });
    }else{
      drawTweets(twitterData);
    };
  })

  function drawTweets (target) {
    for (var i = 0; i < 3 && i < target.length; i++) {
      var current = target[i];
      var lat = current.lat;
      var lng = current.lng;
      var pic = current.img;
      console.log(current);
      //var tweetID = current._id.id;
      //$('<img id="'+tweetID+'" src="' + pic + '"/>')
      
      $('<img src="' + pic + '"/>')
        .insertAfter(entry)
        .css({
          'position': 'absolute',
          'left': lat / 0.9 * 1000 - 15 + random() + 'px',
          'bottom': lng / 2.38 * 600 - 15 + random() + 'px'
        });

    };
  }

}); //end docReady
