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
   
    var triplelifeParNum = 8;
    for (paraNum = 8; paraNum < 10; paraNum++) {
        paraProto = paragraphs[paraNum];
      if ( undefined !== paraProto ) {  paraContent = paraProto.toString();
        if (paraContent.indexOf("blockquote") > -1) {
        triplelifeParNum++;
        continue;
        }
        paraContent = paraContent.replace(/<[\/]{0,1}(p)[^><]*>/ig,"");
        paraContent = paraContent.replace(/(<([^>]+)>)/ig,"");
        paraContent = paraContent.trim();
        if (paraContent.length === 0) {
        triplelifeParNum++;
        }       }
    }   
      
    if (!jQuery(".cst-active-scroll-post").hasClass("triplelift-inserted")) {
      if (paragraphsCount >= triplelifeParNum) {
        if (jQuery(paragraphs[triplelifeParNum]).hasClass("wp-caption-text")) {
          tripleliftContentNode = jQuery(paragraphs[(triplelifeParNum+1)]);
        } else {
          tripleliftContentNode = jQuery(paragraphs[triplelifeParNum]);
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
    if ( node.length && "undefined" !== typeof(node) ) {
      node[0].appendChild(script);
    }
  }

};