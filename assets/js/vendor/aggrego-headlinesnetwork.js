'use strict';
window.AggregoHeadlinesNetwork = {

  /*
     Public Method for injecting Aggrego's HeadlinesNetwork Widget into body of the article
  */
  inject: function(section_name){
    var aggregoHeadlinesNetworkContentNode;
    var anchor_div_id;
    
    var postContent = jQuery("#main").find(".cst-active-scroll-post");
    if ( ! postContent.length ) {
      return;
    }

      if( ! jQuery(".cst-active-scroll-post" ).hasClass("headlinesnetwork-inserted") ) {
          aggregoHeadlinesNetworkContentNode = this.aggregoHeadlinesNetworkHTML(postContent.data("cst-post-id"));
          var headlinesnetwork_div = jQuery("#post-"+postContent.data("cst-post-id")).find(".agg-hn");
          headlinesnetwork_div.append(aggregoHeadlinesNetworkContentNode);


          this.insertAggregoHeadlinesNetwork(postContent.data("cst-post-id"),vendor_hn[section_name]);
          jQuery(".cst-active-scroll-post").addClass("headlinesnetwork-inserted");
      }
  },


  /* Private methods */
  insertAggregoHeadlinesNetwork: function(post_id,section_name){
    var script = document.createElement("script");
    script.src = "//headlinesnetwork.com/embed_widget.js?tag=" + section_name + "&html_anchor_id=exchange-embed-widget-" + post_id;
    document.getElementsByTagName("head")[0].appendChild(script);
  },

  aggregoHeadlinesNetworkHTML: function(post_id){

    var aggrego_headlines_network_div = jQuery("<div />");
    aggrego_headlines_network_div.attr( "class", "agg-hn columns medium-11 medium-offset-1 end" );
    aggrego_headlines_network_div.attr( "id", "exchange-embed-widget-" + post_id );

    return aggrego_headlines_network_div;
  }

};

