$(document).ready( function(){
  
  //Cached selectors
  var infoList = $('div#info');
  var twitterData = "";
  var grouponData = "";
  var canvas = $('div#map');

  //Navbar links
  var twitLink = $('li#twitter');
  var groupLink = $('li#groupon');

  
  /*
   * Twitter handling
   * Draws tweets to the map
   */
  twitLink.on('click', function() {
    twitLink.addClass('active');
    groupLink.removeClass('active');

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
    for (var i = 0; i < target.length; i++) {
      var current = target[i];
      var lat = current.lat;
      var lng = current.lng;
      var pic = current.img;
      console.log(current);
      var tweetID = current._id.$id;

      console.log(random());
      $('<img id="'+tweetID+'" src="'+pic+'"/>')
        .append(canvas)
        .css({
          'position': 'absolute',
          'top': 550.0 * (41.39 - lat)/(41.39-39.0),
          'left': 800 * (-lng - 74) / (0.95)
        });

    };
  });


  /*
   * Groupon handler
   * Finds deals and draws related images on map.
   */
  groupLink.on('click', function() {
    groupLink.addClass('active');
    twitLink.removeClass('active');
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
    for (var i = 0; i < grouponData.length; i++) {
      var current = grouponData[i];
    };
  });


  /*
   * Generates random number from 1 to X.
   */
  function random (x) {
    return Math.floor(Math.random()*x);
  }

}); //end docReady
