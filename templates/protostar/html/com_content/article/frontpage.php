<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params  = $this->item->params;
$images  = json_decode($this->item->images);
$urls    = json_decode($this->item->urls);
$canEdit = $params->get('access-edit');
$user    = JFactory::getUser();
$info    = $params->get('info_block_position', 0);
JHtml::_('behavior.caption');

?>
</div>
</div>
<div class="container homecontainer">
<div class="row-fluid">
<h1>Content goes here</h1>

<script type="javascript">
  var native_width = 1455;
var native_height = 831;

//Now the mousemove function
$(".magnify").mousemove(function(e){
  //When the user hovers on the image, the script will first calculate
  //the native dimensions if they don't exist. Only after the native dimensions
  //are available, the script will show the zoomed version.
  if(!native_width && !native_height)
  {
    //This will create a new image object with the same image as that in .small
    //We cannot directly get the dimensions from .small because of the 
    //width specified to 200px in the html. To get the actual dimensions we have
    //created this image object.
    var image_object = new Image();
    image_object.src = $(".small").attr("src");
    
    //This code is wrapped in the .load function which is important.
    //width and height of the object would return 0 if accessed before 
    //the image gets loaded.
    native_width = image_object.width;
    native_height = image_object.height;
  }
  else
  {
    //x/y coordinates of the mouse
    //This is the position of .magnify with respect to the document.
    var magnify_offset = $(this).offset();
    //We will deduct the positions of .magnify from the mouse positions with
    //respect to the document to get the mouse positions with respect to the 
    //container(.magnify)
    var mx = e.pageX - magnify_offset.left;
    var my = e.pageY - magnify_offset.top;
    
    //Finally the code to fade out the glass if the mouse is outside the container
    if(mx < $(this).width() && my < $(this).height() && mx > 0 && my > 0)
    {
      $(".large").fadeIn(100);
    }
    else
    {
      $(".large").fadeOut(100);
    }
    if($(".large").is(":visible"))
    {
      //The background position of .large will be changed according to the position
      //of the mouse over the .small image. So we will get the ratio of the pixel
      //under the mouse pointer with respect to the image and use that to position the 
      //large image inside the magnifying glass
      var rx = Math.round(mx/$(".small").width()*native_width - $(".large").width()/2)*-1;
      var ry = Math.round(my/$(".small").height()*native_height - $(".large").height()/2)*-1;
      var bgp = rx + "px " + ry + "px";
      
      //Time to move the magnifying glass with the mouse
      var px = mx - $(".large").width()/2;
      var py = my - $(".large").height()/2;
      //Now the glass moves with the mouse
      //The logic is to deduct half of the glass's width and height from the 
      //mouse coordinates to place it with its center at the mouse coordinates
      
      //If you hover on the image now, you should see the magnifying glass in action
      $(".large").css({left: px, top: py, backgroundPosition: bgp});
    }
  }
})
</script>
<script type="stylesheet">
#infograph {
background: url(/images/car_small.png) top left no-repeat;
cursor: pointer;
height: 550px;
width: 963px
}
#hplogot {
-webkit-box-shadow: 5px 5px 10px #ddd;
-moz-box-shadow: 5px 5px 10px #ddd;
box-shadow: 5px 5px 10px #ddd;
-webkit-transition: opacity 0.5s ease-out;
-moz-transition: opacity 0.5s ease-out;
-o-transition: opacity 0.5s ease-out;
transition: opacity 0.5s ease-out;
background-color: #ffffca;
border: 1px solid #b5b5b5;
display: none;
font: normal 10pt arial,sans-serif;
opacity: 0;
padding: 1px 3px;
position: absolute;
white-space: nowrap
}
#loupe {
-webkit-transform: scale(.25) rotateZ(0);
-moz-transform: scale(.25) rotateZ(0);
-webkit-transition-delay: 200ms, 0;
-moz-transition-delay: 200ms, 0;
-webkit-transition: opacity 400ms, -webkit-transform 400ms;
-moz-transition: opacity 400ms, -moz-transform 400ms;
-webkit-user-select: none;
-moz-user-select: none;
user-select: none;
opacity: 0;
overflow: hidden;
position: absolute;
visibility: hidden;
z-index: 2000
}
#loupe.visible {
-webkit-transform: scale(1) rotateZ(0);
-moz-transform: scale(1) rotateZ(0);
-webkit-transition-delay: 0, 100ms;
-moz-transition-delay: 0, 100ms;
-webkit-transition: opacity 400ms, -webkit-transform 400ms;
-moz-transition: opacity 400ms, -moz-transform 400ms;
cursor: none;
opacity: 1
}
.loupe-canvas {
background: white;
overflow: hidden;
position: absolute;
z-index: 3000
}
.loupe-canvas div {
height: 503px;
left: 0;
position: absolute;
top: 0;
width: 1263px
}
.loupe-canvas img {
position: absolute
}
#loupe-canvas-top {
height: 19px;
left: 51px;
top: 22px;
width: 100px
}
#loupe-canvas-mid {
height: 119px;
left: 23px;
top: 41px;
width: 155px
}
#loupe-canvas-bottom {
height: 18px;
left: 51px;
top: 159px;
width: 100px
}
.info-big {
height: 831px;
left: 0;
top: 0;
width: 1455px;
z-index: 4000
}
.large {
	width: 250px;
	height: 250px;
	position: absolute;
	border-radius: 100%;
	box-shadow: 0 0 0 7px rgba(255, 255, 255, 0.85),
		0 0 7px 7px rgba(0, 0, 0, 0.25),
		inset 0 0 40px 2px rgba(0, 0, 0, 0.25);
	background: url('/images/car_large.png') no-repeat;
	display: none;
	cursor: none;
	z-index: 1000;
}
.magnify {
	position: relative;
}
.small { display: block; }
</script>
<div class="magnify">
  <div class="large"></div>
  <img class="small" src="/images/car_small.png"/>
</div>