;window.CSTFlipp = {

  /*
   Public Method for injecting Flipp's ad into body of the article
   */
  inject: function () {
    var FlippContentNode, postContent;
    postContent = jQuery("#main").find(".cst-active-scroll-post");
    if (!postContent.length) {
      return;
    }
    var post_id = postContent.data("cst-post-id");
    var paragraphs = Array.prototype.slice.call(jQuery(".cst-active-scroll-post p"))
    var paragraphsCount = paragraphs.length
    if (!paragraphsCount) {
      return;
    }

    var FlippParNum = 5, paraNum;
    for (paraNum = 5; paraNum < 10; paraNum++) {
      paraProto = paragraphs[paraNum];
      if (undefined !== paraProto) {
        paraContent = paraProto.toString();

        if (paraContent.indexOf("read-more-wrap") > -1) {
          FlippParNum++;
        }
        if (paraContent.indexOf("blockquote") > -1) {
          FlippParNum++;
          continue;
        }
        paraContent = paraContent.replace(/<[\/]{0,1}(p)[^><]*>/ig, "");
        paraContent = paraContent.replace(/(<([^>]+)>)/ig, "");
        paraContent = paraContent.trim();
        if (paraContent.length === 0) {
          FlippParNum++;
          continue;
        }
      }

      if (paragraphsCount >= FlippParNum) {
        if (jQuery(paragraphs[FlippParNum]).hasClass("wp-caption-text")) {
          FlippParNum++;
        }
      }

      if (FlippParNum > paragraphsCount) {
        FlippParNum = paragraphsCount;
      }

      if (!jQuery(".cst-active-scroll-post").hasClass("Flipp-inserted")) {
        FlippContentNode = jQuery(paragraphs[FlippParNum]);
        this._insertFlippJS(FlippContentNode);
        jQuery(".cst-active-scroll-post").addClass("Flipp-inserted");
      }
    }
  },

  /* Private methods */
  _insertFlippJS: function (node) {
    var page_count, parents;
    if ( 'undefined' !== typeof( infiniteScroll.scroller ) ) {
      parents = document.querySelectorAll('.infinite-wrap');
      page_count = parents.length - 1;
    } else {
      page_count = infiniteScroll.settings.query_args.page;
    }
    if ( page_count >= 5 ) {
      return;
    }
    var div_id = 10635 + page_count;
    var div = document.createElement("div");
    div.id = 'circularhub_module_' + div_id;
    div.style.cssText = 'background-color: #ffffff; margin-bottom: 10px; padding: 5px 5px 0px 5px;';
    if ( node.length && "undefined" !== typeof(node) ) {
      node[0].appendChild(div);
    }
    var script = document.createElement("script");
    script.src="//api.circularhub.com/"+div_id+"/2e2e1d92cebdcba9/circularhub_module.js?p=" + div_id;
    if ( node.length && "undefined" !== typeof(node) ) {
      node[0].appendChild(script);
    }
  }

};