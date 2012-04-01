$(document).ready( function(){

  //Cached selectors
  var infoList = $('div#info');
  var twitterData = "";
  var grouponData = "";
  var images = new Array();
  var groupImages = new Array();
  var theWindow = $(window);
  var map = null; 
  function getMap() {
    map = new Microsoft.Maps.Map(document.getElementById('myMap'), {
      credentials: 'Assd2akCabc9zZOrMER5t5DUkIHfUhvLuUawIyLYrno_IlOa4RU7iVYtVpgYbGn1',
      enableClickableLogo: false,
      enableSearchLogo: false,
      disablePanning: true,
      disableZooming: true,
      showDashboard: false,
      showScalebar: false,
      width: '800px',
      height: '400px',
      mapTypeId: Microsoft.Maps.MapTypeId.mercator,
      zoom: 5,
      center: new Microsoft.Maps.Location(40.0393264770508, -74.5893569946289)
    });
  };  

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
  }); //Preloads images

  getMap();
}); //end docReady
