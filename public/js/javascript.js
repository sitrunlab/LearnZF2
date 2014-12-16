/**
 * Created by mockie on 11/7/14.
 */

jQuery('document').ready(function(){

    jQuery('a.btn-donate').click(function(){
        var state = jQuery(this).data('toggleState');
        if(!state){
            jQuery(this).next('.donation-desc').slideDown();
        } else {
            jQuery(this).next('.donation-desc').slideUp();
        }
        $(this).data('toggleState', !state);
        return false;
    });

    jQuery('ul.contributor-gallery li').hover(function(){
        $(this).find('.gallery-overlay').stop(true).fadeIn(1500);
    },function(){
        $(this).find('.gallery-overlay').stop(true).fadeOut(1500);
    });

});
