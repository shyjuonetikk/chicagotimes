window.AggregoChatter = {

  /*
     Public Method for injecting Aggrego's Chatter Widget into body of the article
  */
  inject: function(sectionNames){
    
    postContent = jQuery('#main').find('.cst-active-scroll-post');
    if ( ! postContent.length ) {
      return;
    }

    var paragraphs = Array.prototype.slice.call(jQuery('.cst-active-scroll-post p'))
    var paragraphsCount = paragraphs.length
    if(!paragraphsCount)
      return

    if(sectionNames == 'politics') {
      var domainTag = 'politics';
      var anchorTag = 'politics';
    } else if(sectionNames == 'entertainment') {
      var domainTag = 'celeb';
      var anchorTag = 'entertainment';
    } else if(sectionNames == 'sports') {
      var domainTag = 'sports';
      var anchorTag = 'sports';
    }

    if(domainTag && anchorTag) {
      if( ! jQuery('.cst-active-scroll-post' ).hasClass('chatter-inserted') ) {
        if(paragraphsCount >= 1) {
          aggregoChatterContentNode = this._aggregoChatterHTMLTag(anchorTag);
          if( jQuery(paragraphs[2]).hasClass('wp-caption-text') ) {
            jQuery(paragraphs[1]).append(aggregoChatterContentNode);
          } else {
            jQuery(paragraphs[2]).append(aggregoChatterContentNode);
          }

          var title = jQuery( '<h4 />' );
              title.attr( 'class', 'agg-sponsored' );
              title.text( 'Promoted Stories from ');
              chatter = jQuery( '<span />' );
              chatter.text( domainTag + 'Chatter' );
              jQuery(title).append(chatter);
              jQuery('.cst-active-scroll-post .agg-collage').before( title );

          this._insertAggregoChatterJS(domainTag, anchorTag);
          jQuery('.cst-active-scroll-post').addClass('chatter-inserted');
        }
      }
    }
  },

  /* Private methods */
  _insertAggregoChatterJS: function(domainTag, anchorTag){
    var script = document.createElement('script');
    script.src = "http://suntimes." + domainTag + "chatter.com/widgets/2.0/collage/" + anchorTag + ".js?anchor=" + anchorTag;
    document.getElementsByTagName('head')[0].appendChild(script);
  },

  _aggregoChatterHTMLTag: function(tag){

    aggrego_chatter_div = jQuery('<div />');
    aggrego_chatter_div.attr( 'class', 'agg-collage ' + tag );

    return aggrego_chatter_div;
  }

}

