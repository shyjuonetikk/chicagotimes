;window.CSTTripleLift = {

  /*
   Public Method for injecting Triplelift's ad / widget into body of the article
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


    if(domainTag && anchorTag) {
      if( ! jQuery('.cst-active-scroll-post' ).hasClass('chatter-inserted') ) {
        if(paragraphsCount >= 1) {
          var anchor_div_id = 'agg-collage-' + anchorTag + "-" + postContent.data('cst-post-id');
          tripleliftContentNode = this._aggregoChatterHTMLTag(anchorTag);
          if( jQuery(paragraphs[2]).hasClass('wp-caption-text') ) {
            jQuery(paragraphs[1]).append(tripleliftContentNode);
          } else {
            jQuery(paragraphs[2]).append(tripleliftContentNode);
          }

          var title = jQuery( '<h4 />' );
          title.attr( 'class', 'agg-sponsored' );
          title.text( 'Promoted Stories from ');
          chatter = jQuery( '<span />' );
          chatter.text( domainTag + 'Chatter' );
          jQuery(title).append(chatter);
          jQuery('.cst-active-scroll-post .agg-collage').before( title );

          this._insertTripleLiftJS(anchor_div_id);
          jQuery('.cst-active-scroll-post').addClass('chatter-inserted');
        }
      }
    }
  },

  /* Private methods */
  _insertTripleLiftJS: function(){
    var script = document.createElement('script');
    script.src = "http://suntimes-" + domainTag + "-chatter.suntimes.com/embed-widget/?widgetAnchorID=" + anchor_div_id + "&version=mid_article_three_pack";
    document.getElementsByTagName('head')[0].appendChild(script);
  },


}