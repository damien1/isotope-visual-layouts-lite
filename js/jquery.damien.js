/**
 * Damien's theme jQuery.
 * © 2012 - 2014
 *
 *
 */
 
   
   $j = jQuery.noConflict(); 
   
    $j(document).ready(function(){
    
      var mycontainer = $j('ul.isocontent');
      mycontainer.imagesLoaded( function(){
     	 mycontainer.isotope({
	     	itemSelector: 'li.tile',
	     	masonry : {
          //columnWidth : 90
        }
	     	});
    });
    
    // filter items when filter link is clicked
	$j('#options a').click(function(){
	  var selector = $j(this).attr('data-filter');
	  mycontainer.isotope({ filter: selector });
	  return false;  
	  });
	  
	});