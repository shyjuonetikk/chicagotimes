;window.CSTTripleLift = {

  /*
   Public Method for injecting Triplelift's ad / widget into body of the article
   */
  inject: function () {
    var tripleliftContentNode, postContent;
    postContent = jQuery("#main").find(".cst-active-scroll-post");
    if (!postContent.length) {
      return;
    }

    var paragraphs = Array.prototype.slice.call(jQuery(".cst-active-scroll-post p"))
    var paragraphsCount = paragraphs.length
    if (!paragraphsCount) {
      return;
    }

    if (!jQuery(".cst-active-scroll-post").hasClass("triplelift-inserted")) {
      if (paragraphsCount >= 5) {
        if (jQuery(paragraphs[5]).hasClass("wp-caption-text")) {
          tripleliftContentNode = jQuery(paragraphs[6]);
        } else {
          tripleliftContentNode = jQuery(paragraphs[5]);
        }
        this._insertTripleLiftJS(tripleliftContentNode);
        jQuery(".cst-active-scroll-post").addClass("triplelift-inserted");
      }
    }
  },

  /* Private methods */
  _insertTripleLiftJS: function (node) {
    var script = document.createElement("script");
    script.src = "http://ib.3lift.com/ttj?inv_code=chicagosuntimes_midarticle";
    node[0].appendChild(script);
  }


};