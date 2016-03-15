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
      var domainTag = 'politicschatter';
      var anchorTag = 'politics';
    } else if(sectionNames == 'entertainment') {
      var domainTag = 'celebchatter';
      var anchorTag = 'entertainment';
    } else if(sectionNames == 'sports') {
      var domainTag = 'sportschatter';
      var anchorTag = 'sports';
    } else {
      var domainTag = 'politicschatter';
      var anchorTag = 'politics';
    }

    if(paragraphsCount >= 1) {
      aggregoChatterContentNode = this._aggregoChatterHTMLTag(anchorTag);
      jQuery(paragraphs[2]).append(aggregoChatterContentNode);

      this._insertAggregoChatterJS(domainTag, anchorTag);      
    }

  },

  /* Private methods */
  _insertAggregoChatterJS: function(domainTag, anchorTag){
    var script = document.createElement('script');
    script.src = "http://suntimes." + domainTag + ".com/widgets/2.0/collage/" + anchorTag + ".js?anchor=" + anchorTag;
    document.getElementsByTagName('head')[0].appendChild(script);
  },

  _aggregoChatterHTMLTag: function(tag){

    aggrego_chatter_div = jQuery('<div />');
    aggrego_chatter_div.attr( 'class', 'agg-collage ' + tag );

    return aggrego_chatter_div;
  }

}

