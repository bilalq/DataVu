$(document).ready( function(){
  
  //Cached selectors
  var infoList = $('div#info');
  var twitterData = "";
  var grouponData = "";
  var preload = $('div#preload');
  var canvas = document.getElementById('map');
  var ctx = canvas.getContext('2d'); 
  canvas.width = 400;
  canvas.height = 600;
  ctx.width = 400;
  ctx.height = 600;
  var images = new Array();
  var groupImages = new Array();

  //Navbar links
  var twitLink = $('li#twitter');
  var groupLink = $('li#groupon');

  $.ajax({
    type: 'POST',
    url: 'backend/controller.php',
    data: {'lens': 'twitter'},
    success: function(response) {
        twitterData = $.parseJSON(response);
        console.log('success');
        for (var i = 0; i < twitterData.length; i++) {
          var current = twitterData[i];
          var pic = current.img;
          var tweetID = current._id.$id;
          var image = new Image();
          image.src = pic;
          images.push(image);
          //preload.append($('<img id="'+tweetID+'" src="'+pic+'"/>'));
          $.ajax({
            type: 'POST',
            url: 'backend/controller.php',
            data: {'lens': 'groupon'},
            success: function(response) {
                grouponData = $.parseJSON(response);
                for (var i = 0; i < grouponData.length; i++) {
                  var curr = grouponData[i];
                  var pic = curr.img;
                  var image = new Image();
                  image.src = pic;
                  groupImages.push(image);
                }
            }
          });
        }
      }
  });
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
    for (var i = 0; i < twitterData.length; i++) {
      var current = twitterData[i];
      var lat = current.lat;
      var lng = current.lng;
      var pic = current.img;
      var tweetID = current._id.$id;
      
      var xOff = 300.0 * 0.9 * (-lng - 74) / (0.95) + 10 - random(20);
      var yOff = 600.0 * 0.9 * (41.39 - lat)/(41.39-39.0) + 10 - random(20);

      ctx.drawImage(images[i], 0, 0, 48, 48, xOff, yOff, 48, 48);

      //$('<img id="'+tweetID+'" src="'+pic+'"/>')
        //.append(canvas)
        //.css({
          //'position': 'absolute',
          //'top': 550.0 * (41.39 - lat)/(41.39-39.0),
          //'left': 800 * (-lng - 74) / (0.95)
        //});

    };
  });


  /*
   * Groupon handler
   * Finds deals and draws related images on map.
   */
  groupLink.on('click', function() {
    groupLink.addClass('active');
    twitLink.removeClass('active');
    $.ajax({
      type: 'POST',
      url: 'backend/controller.php',
      data: {'lens': 'groupon'},
      success: function(response) {
          grouponData = $.parseJSON(response);
          for (var i = 0; i < grouponData.length; i++) {

            var current = grouponData[i];
            var glat = current.lat;
            var glng = current.lng;
            var xgOff = 300.0 * 0.9 * (-glng - 74) / (0.95) + 10 - random(20);
            var ygOff = 600.0 * 0.9 * (41.39 - glat)/(41.39-39.0) + 10 - random(20);
            ctx.drawImage(groupImages[i], 10, 10, 48, 48, xgOff, ygOff, 48, 48);
            //var current = grouponData[i];
            //var lat = current.lat;
            //var lng = current.lng;
            //var expires = current.expires;
            //var dealurl = current.dealurl;
            //var pic = current.img;
            //var title = current.title;
            //var desc = current.description;
            //var groupID = current._id.$id;
          }
      }
    });
  });


  /*
   * Generates random number from 1 to X.
   */
  function random (x) {
    return Math.floor(Math.random()*x);
  }

}); //end docReady
