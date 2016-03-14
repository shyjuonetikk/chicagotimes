window.AggregoChatter = {

  /*
     Public Method for injecting Aggrego's Chatter Widget into body of the article
  */
  inject: function(){
    postContent = jQuery('#main').find('.cst-active-scroll-post');
    if ( ! postContent.length ) {
      return;
    }

    var paragraphs = Array.prototype.slice.call(jQuery('.cst-active-scroll-post p'))
    var paragraphsCount = paragraphs.length
    if(!paragraphsCount)
      return

    if(paragraphsCount >= 1) {
      aggregoChatterContentNode = this._aggregoChatterHTMLTag();
      jQuery(paragraphs[2]).append(aggregoChatterContentNode);

      this._insertAggregoChatterJS();
      
    }

  },

  /* Private methods */
  _insertAggregoChatterJS: function(){
    var script = document.createElement('script');
    script.src = "http://suntimes.politicschatter.com/widgets/2.0/collage/politics.js?anchor=politics";
    document.getElementsByTagName('head')[0].appendChild(script);
  },

  _aggregoChatterHTMLTag: function(tag){

    aggrego_chatter_div = jQuery('<div />');
    aggrego_chatter_div.attr( 'class', 'agg-collage politics' );

    return aggrego_chatter_div;
  }

}

