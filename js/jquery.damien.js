/**
 * Damien's theme jQuery.
 * © 2012 - 2014
 * Created by IntelliJ IDEA.
 * User: damien saunders
 * Date: 01/01/2012
 * Updated: 01/02/2014
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

$j(".tile-content").click(function(){
    window.location=$j(this).find("a").attr("href");
    return false;
});