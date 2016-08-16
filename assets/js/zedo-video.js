window.CSTZedo = {

  inject: function() {

    postContent = jQuery('#main').find('.cst-active-scroll-post');
    if ( ! postContent.length ) {
      return;
    }
    var paragraphs = Array.prototype.slice.call(jQuery('.cst-active-scroll-post p'));
    var paragraphsCount = paragraphs.length;
    if ( paragraphsCount ) {
      if( ! jQuery('#main').find('.cst-active-scroll-post').hasClass('zedo-inserted') ) {
        if(paragraphsCount >= 3) {
          zedoContentNode = this._insertHTMLTag();
          jQuery('.cst-active-scroll-post .post-content').children('p').not('.wp-caption-text, :first').append(zedoContentNode);
          this._insertZedoJS();
          postContent.addClass('zedo-inserted');
        }
      }

    }
  },

  /* Private methods */
  _insertZedoJS: function(){
    if ( jQuery('#main').find('.cst_article').hasClass('zedo-inserted') )
      return;

    !function (a, n, e, t, r) {
      tagsync = e;
      var c = window[a];
      if (tagsync) {
        var d = document.createElement("script");
        d.src = "http://3107.tm.zedo.com/v1/29252020-9011-4261-83dd-83503d457fb9/atm.js", d.async = !0;
        var i = document.getElementById(n);
        if (null == i || "undefined" == i)return;
        i.parentNode.appendChild(d, i), d.onload = d.onreadystatechange = function () {
          var a = new zTagManager(n);
          a.initTagManager(n, c, this.aync, t, r)
        }
      } else document.write("<script src='http://3107.tm.zedo.com/v1/29252020-9011-4261-83dd-83503d457fb9/tm.js?data=" + a + "'><" + "/script>")
    }("datalayer", "z578f1ef7-f0c5-4f8d-9f90-f7f7b7dc0206", true, 1, 1);
  },

  _insertHTMLTag: function(){

    cst_div_div = jQuery('<div />');
    cst_div_div.attr( 'id', 'z578f1ef7-f0c5-4f8d-9f90-f7f7b7dc0206');
    cst_div_div.attr( 'style', 'display:none;' );

    return cst_div_div;
  }
};
document.addEventListener("DOMContentLoaded", function(){
  window.CSTZedo && window.CSTZedo.inject()
});