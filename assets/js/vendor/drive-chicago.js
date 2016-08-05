window.DriveChicago = {

  /*
     Public Method for injecting Drive Chicago's Search Image Ad into body of the article
  */
  inject: function(driveChicagoSections){
    
    postContent = jQuery('#main').find('.cst-active-scroll-post');
    if ( ! postContent.length ) {
      return;
    }

    var paragraphs = Array.prototype.slice.call(jQuery('.cst-active-scroll-post p'))
    var paragraphsCount = paragraphs.length
    if(!paragraphsCount)
      return

    if(window.SECTIONS_FOR_DRIVE_CHICAGO != 'zautos') {
      return;
    }

    if( ! jQuery('.cst-active-scroll-post' ).hasClass('drive-chicago-inserted') ) {
      if(paragraphsCount >= 1) {
        driveChicagoContentNode = this._driveChicagoHTMLTag();
        if( jQuery(paragraphs[1]).hasClass('wp-caption-text') ) {
          jQuery(paragraphs[1]).append(driveChicagoContentNode);
        } else {
          jQuery(paragraphs[0]).append(driveChicagoContentNode);
        }

        jQuery('.cst-active-scroll-post').addClass('drive-chicago-inserted');
      }
    }
    
  },

  _driveChicagoHTMLTag: function(){

    drive_chicago_div = jQuery('<div />');
    drive_chicago_img = jQuery('<img />');
    drive_chicago_link = jQuery('<a />');
    drive_chicago_img.attr( 'src', window.DRIVE_CHICAGO_IMAGE );
    drive_chicago_link.attr( 'href', 'http://www.drivechicago.com' );
    drive_chicago_div.attr( 'class', 'drive-chicago-insert' );
    jQuery(drive_chicago_link).append(drive_chicago_img);
    jQuery(drive_chicago_div).append(drive_chicago_link);


    return drive_chicago_div;
  }

}
