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
            twitterData = $.parseJSON(response);
        }
      });
    }
    drawTweets(twitterData);
  });

  $('li#groupon').on('click', function() {
    if (grouponData.length == 0) {
      $.ajax({
        type: 'POST',
        url: 'backend/controller.php',
        data: {'lens': 'groupon'},
        success: function(response) {
            grouponData = $.parseJSON(response);
        }
      });
    }
    drawGroups(twitterData);
  });

  function drawTweets (target) {
    for (var i = 0; i < target.length; i++) {
      var current = target[i];
      var lat = current.lat;
      var lng = current.lng;
      var pic = current.img;
      console.log(current);
      var tweetID = current._id.$id;

      console.log(random());
      $('<img id="'+tweetID+'" src="'+pic+'"/>')
        .insertAfter(entry)
        .css({
          'position': 'absolute',
          'top': 550.0 * (41.39 - lat)/(41.39-39.0),
          'left': 800 * (-lng - 74) / (0.95)

          //'bottom': -((-lat) * 550 / 39 + 15 - random()) - 78 +'px',
          //'right': - (lng * 800 / 74 + 15 - random()) + 'px',

//(Pixels from left side) = (total width in pixels) * ((geocode distance between left and your point) / (geocode distance between left side and right side))
          //'bottom': (lng - 39) * 570 / 2.38 + 15 +'px',
          //'right': 300 + (-lat - 73.9) * 800 / 0.9 + 15 - random() +'px',
        });

    };
  }

}); //end docReady
