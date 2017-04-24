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
    } else if(sectionNames == 'news') {
      var domainTag = 'politics';
      var anchorTag = 'politics';
    } else if(sectionNames == 'entertainment' || sectionNames == 'lifestyles') {
      var domainTag = 'celeb';
      var anchorTag = 'entertainment';
    } else if(sectionNames == 'sports') {
      var domainTag = 'sports';
      var anchorTag = 'sports';
    }

    if(domainTag && anchorTag) {
      if( ! jQuery('.cst-active-scroll-post' ).hasClass('chatter-inserted') ) {
        if(paragraphsCount >= 1) {
          var anchor_div_id = 'agg-collage-' + anchorTag + "-" + postContent.data('cst-post-id');
          aggregoChatterContentNode = this._aggregoChatterHTMLTag(anchorTag);
          var chatter_div = jQuery('#post-'+postContent.data('cst-post-id')).find('.agg-chatter');
          chatter_div.append(aggregoChatterContentNode)

          var title_div = jQuery( '<div />' );
          title_div.attr( 'class', 'columns' );
          var title = jQuery( '<h4 />' );
              title.attr( 'class', 'agg-sponsored' );
              title.text( 'Promoted Stories from ');
              chatter = jQuery( '<span />' );
              chatter.text( domainTag + 'Chatter' );
              jQuery(title).append(chatter);
              jQuery(title_div).append(title);
              jQuery('.cst-active-scroll-post .agg-collage').before( title_div );

          this._insertAggregoChatterJS(domainTag, anchor_div_id);
          jQuery('.cst-active-scroll-post').addClass('chatter-inserted');
        }
      }
    }
  },

  /* Private methods */
  _insertAggregoChatterJS: function(domainTag, anchor_div_id){
    var script = document.createElement('script');
    script.src = "http://suntimes-" + domainTag + "-chatter.suntimes.com/embed-widget/?widgetAnchorID=" + anchor_div_id + "&version=mid_article_three_pack";
    document.getElementsByTagName('head')[0].appendChild(script);
  },

  _aggregoChatterHTMLTag: function(tag){

    aggrego_chatter_div = jQuery('<div />');
    aggrego_chatter_div.attr( 'class', 'agg-collage columns ' + tag );
    aggrego_chatter_div.attr( 'id', 'agg-collage-' + tag + "-" + postContent.data('cst-post-id') );

    return aggrego_chatter_div;
  }

}

