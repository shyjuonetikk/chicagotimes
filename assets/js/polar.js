(function(){


  var compiledTemplate0 = '';

  var compiledTemplate1 = '';

  var compiledTemplate2 = '';

  var compiledTemplate3 = '';

  var compiledTemplate4 = '';

  var compiledTemplate5 = '';

  var compiledTemplate6 = '';

  var compiledTemplate7 = '';

  var compiledTemplate8 = '';

window.NATIVEADS = window.NATIVEADS || {};
window.NATIVEADS.injectedAt = new Date().getTime();
window.NATIVEADS.onReady = function(ads) {

  ads.setPropertyID("NA-BREANEWS-11236280");
  ads.setSecondaryPageURL("/sample/publisher/sponsored.html");




  ads.insertPreview({
    label: "Home",
    unit: {"server":"dfp","id":"/61924087/breakingnews/BreakingNews","size":"2x2","targets":{"pos":"Best"}},
    location: ".polar-widget-ads li:eq(0)",
    infoText: "",
    infoButtonText: "",
    template: compiledTemplate0,
    onRender: function($element) { },
    onFill: function(data) { },
    onError: function(error) { }
  });

  ads.injectCSS(" ", "head");

  ads.insertPreview({
    label: "Home",
    unit: {"server":"dfp","id":"/61924087/breakingnews/BreakingNews","size":"2x2","targets":{"pos":"Better 1"}},
    location: ".polar-widget-ads li:eq(0)",
    infoText: "",
    infoButtonText: "",
    template: compiledTemplate1,
    onRender: function($element) { },
    onFill: function(data) { },
    onError: function(error) { }
  });

  ads.injectCSS(" ", "head");

  ads.insertPreview({
    label: "Home",
    unit: {"server":"dfp","id":"/61924087/breakingnews/BreakingNews","size":"2x2","targets":{"pos":"Better 2"}},
    location: ".polar-widget-ads li:eq(0)",
    infoText: "",
    infoButtonText: "",
    template: compiledTemplate2,
    onRender: function($element) { },
    onFill: function(data) { },
    onError: function(error) { }
  });

  ads.injectCSS(" ", "head");

  ads.insertPreview({
    label: "Home",
    unit: {"server":"dfp","id":"/61924087/breakingnews/BreakingNews","size":"2x2","targets":{"pos":"Good 1"}},
    location: ".polar-widget-ads li:eq(0)",
    infoText: "",
    infoButtonText: "",
    template: compiledTemplate3,
    onRender: function($element) { },
    onFill: function(data) { },
    onError: function(error) { }
  });

  ads.injectCSS(" ", "head");

  ads.insertPreview({
    label: "Home",
    unit: {"server":"dfp","id":"/61924087/breakingnews/BreakingNews","size":"2x2","targets":{"pos":"Good 2"}},
    location: ".polar-widget-ads li:eq(0)",
    infoText: "",
    infoButtonText: "",
    template: compiledTemplate4,
    onRender: function($element) { },
    onFill: function(data) { },
    onError: function(error) { }
  });

  ads.injectCSS(" ", "head");

  ads.insertPreview({
    label: "Home",
    unit: {"server":"dfp","id":"/61924087/breakingnews/BreakingNews","size":"2x2","targets":{"pos":"Good 3"}},
    location: ".polar-widget-ads li:eq(0)",
    infoText: "",
    infoButtonText: "",
    template: compiledTemplate5,
    onRender: function($element) { },
    onFill: function(data) { },
    onError: function(error) { }
  });

  ads.injectCSS(" ", "head");

  ads.insertPreview({
    label: "Home",
    unit: {"server":"dfp","id":"/61924087/breakingnews/BreakingNews","size":"2x2","targets":{"pos":"Good 4"}},
    location: ".polar-widget-ads li:eq(0)",
    infoText: "",
    infoButtonText: "",
    template: compiledTemplate6,
    onRender: function($element) { },
    onFill: function(data) { },
    onError: function(error) { }
  });

  ads.injectCSS(" ", "head");

  ads.insertPreview({
    label: "Home",
    unit: {"server":"dfp","id":"/61924087/breakingnews/BreakingNews","size":"2x2","targets":{"pos":"Good 5"}},
    location: ".polar-widget-ads li:eq(0)",
    infoText: "",
    infoButtonText: "",
    template: compiledTemplate7,
    onRender: function($element) { },
    onFill: function(data) { },
    onError: function(error) { }
  });

  ads.injectCSS(" ", "head");

  ads.insertPreview({
    label: "Home",
    unit: {"server":"dfp","id":"/61924087/breakingnews/BreakingNews","size":"2x2","targets":{"pos":"Good 6"}},
    location: ".polar-widget-ads li:eq(0)",
    infoText: "",
    infoButtonText: "",
    template: compiledTemplate8,
    onRender: function($element) { },
    onFill: function(data) { },
    onError: function(error) { }
  });

  ads.injectCSS(" ", "head");  

  ads.configureSecondaryPage({
    binding: {
      sponsor: {
        link: "#sponsor-link",
        logo: "#sponsor-logo",
        name: "#sponsor-name"
      },
      title: "#title",
      summary: "#summary",
      content: "#content",
      author: "#author",
      pubDate: "#pub-date",
      image: {
        href: "#media",
        caption: "#media-caption",
        credits: "#media-credits"
      }
    },
    onFill: function(data) { },
    onRender: function() { },
    onError: function(error) { },
    track: function() { }
  });

};



  /*

   This function represents a pre-compiled Handlebars template. Pre-compiled
   templates are not pretty, but they provide a very significant performance
   boost, especially on mobile devices. For more information, see
   http://handlebarsjs.com/precompilation.html.

   Note that this code has been generated from the following markup:

<li>
<a href="{{link}}">
<span class="headline">{{title}}</span>
</a>
<br>
<span class="sponsor">Sponsored By: {{sponsor.name}}</span>
</li>



  */

  compiledTemplate0 = function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, functionType="function", escapeExpression=this.escapeExpression;


  buffer += "<li>\n<a href=\"";
  if (stack1 = helpers.link) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = depth0.link; stack1 = typeof stack1 === functionType ? stack1.apply(depth0) : stack1; }
  buffer += escapeExpression(stack1)
    + "\">\n<span class=\"headline\">";
  if (stack1 = helpers.title) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = depth0.title; stack1 = typeof stack1 === functionType ? stack1.apply(depth0) : stack1; }
  buffer += escapeExpression(stack1)
    + "</span>\n</a>\n<br>\n<span class=\"sponsor\">Sponsored By: "
    + escapeExpression(((stack1 = ((stack1 = depth0.sponsor),stack1 == null || stack1 === false ? stack1 : stack1.name)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</span>\n</li>\n\n";
  return buffer;
  };

 /*

   This function represents a pre-compiled Handlebars template. Pre-compiled
   templates are not pretty, but they provide a very significant performance
   boost, especially on mobile devices. For more information, see
   http://handlebarsjs.com/precompilation.html.

   Note that this code has been generated from the following markup:

<li>
<a href="{{link}}">
<span class="headline">{{title}}</span>
</a>
<br>
<span class="sponsor">Sponsored By: {{sponsor.name}}</span>
</li>



  */

  compiledTemplate1 = function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, functionType="function", escapeExpression=this.escapeExpression;


  buffer += "<li>\n<a href=\"";
  if (stack1 = helpers.link) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = depth0.link; stack1 = typeof stack1 === functionType ? stack1.apply(depth0) : stack1; }
  buffer += escapeExpression(stack1)
    + "\">\n<span class=\"headline\">";
  if (stack1 = helpers.title) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = depth0.title; stack1 = typeof stack1 === functionType ? stack1.apply(depth0) : stack1; }
  buffer += escapeExpression(stack1)
    + "</span>\n</a>\n<br>\n<span class=\"sponsor\">Sponsored By: "
    + escapeExpression(((stack1 = ((stack1 = depth0.sponsor),stack1 == null || stack1 === false ? stack1 : stack1.name)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</span>\n</li>\n\n";
  return buffer;
  };

 /*

   This function represents a pre-compiled Handlebars template. Pre-compiled
   templates are not pretty, but they provide a very significant performance
   boost, especially on mobile devices. For more information, see
   http://handlebarsjs.com/precompilation.html.

   Note that this code has been generated from the following markup:

<li>
<a href="{{link}}">
<span class="headline">{{title}}</span>
</a>
<br>
<span class="sponsor">Sponsored By: {{sponsor.name}}</span>
</li>



  */

  compiledTemplate3 = function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, functionType="function", escapeExpression=this.escapeExpression;


  buffer += "<li>\n<a href=\"";
  if (stack1 = helpers.link) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = depth0.link; stack1 = typeof stack1 === functionType ? stack1.apply(depth0) : stack1; }
  buffer += escapeExpression(stack1)
    + "\">\n<span class=\"headline\">";
  if (stack1 = helpers.title) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = depth0.title; stack1 = typeof stack1 === functionType ? stack1.apply(depth0) : stack1; }
  buffer += escapeExpression(stack1)
    + "</span>\n</a>\n<br>\n<span class=\"sponsor\">Sponsored By: "
    + escapeExpression(((stack1 = ((stack1 = depth0.sponsor),stack1 == null || stack1 === false ? stack1 : stack1.name)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</span>\n</li>\n\n";
  return buffer;
  };

 /*

   This function represents a pre-compiled Handlebars template. Pre-compiled
   templates are not pretty, but they provide a very significant performance
   boost, especially on mobile devices. For more information, see
   http://handlebarsjs.com/precompilation.html.

   Note that this code has been generated from the following markup:

<li>
<a href="{{link}}">
<span class="headline">{{title}}</span>
</a>
<br>
<span class="sponsor">Sponsored By: {{sponsor.name}}</span>
</li>



  */

  compiledTemplate4 = function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, functionType="function", escapeExpression=this.escapeExpression;


  buffer += "<li>\n<a href=\"";
  if (stack1 = helpers.link) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = depth0.link; stack1 = typeof stack1 === functionType ? stack1.apply(depth0) : stack1; }
  buffer += escapeExpression(stack1)
    + "\">\n<span class=\"headline\">";
  if (stack1 = helpers.title) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = depth0.title; stack1 = typeof stack1 === functionType ? stack1.apply(depth0) : stack1; }
  buffer += escapeExpression(stack1)
    + "</span>\n</a>\n<br>\n<span class=\"sponsor\">Sponsored By: "
    + escapeExpression(((stack1 = ((stack1 = depth0.sponsor),stack1 == null || stack1 === false ? stack1 : stack1.name)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</span>\n</li>\n\n";
  return buffer;
  };

 /*

   This function represents a pre-compiled Handlebars template. Pre-compiled
   templates are not pretty, but they provide a very significant performance
   boost, especially on mobile devices. For more information, see
   http://handlebarsjs.com/precompilation.html.

   Note that this code has been generated from the following markup:

<li>
<a href="{{link}}">
<span class="headline">{{title}}</span>
</a>
<br>
<span class="sponsor">Sponsored By: {{sponsor.name}}</span>
</li>



  */

  compiledTemplate5 = function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, functionType="function", escapeExpression=this.escapeExpression;


  buffer += "<li>\n<a href=\"";
  if (stack1 = helpers.link) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = depth0.link; stack1 = typeof stack1 === functionType ? stack1.apply(depth0) : stack1; }
  buffer += escapeExpression(stack1)
    + "\">\n<span class=\"headline\">";
  if (stack1 = helpers.title) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = depth0.title; stack1 = typeof stack1 === functionType ? stack1.apply(depth0) : stack1; }
  buffer += escapeExpression(stack1)
    + "</span>\n</a>\n<br>\n<span class=\"sponsor\">Sponsored By: "
    + escapeExpression(((stack1 = ((stack1 = depth0.sponsor),stack1 == null || stack1 === false ? stack1 : stack1.name)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</span>\n</li>\n\n";
  return buffer;
  };

 /*

   This function represents a pre-compiled Handlebars template. Pre-compiled
   templates are not pretty, but they provide a very significant performance
   boost, especially on mobile devices. For more information, see
   http://handlebarsjs.com/precompilation.html.

   Note that this code has been generated from the following markup:

<li>
<a href="{{link}}">
<span class="headline">{{title}}</span>
</a>
<br>
<span class="sponsor">Sponsored By: {{sponsor.name}}</span>
</li>



  */

  compiledTemplate6 = function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, functionType="function", escapeExpression=this.escapeExpression;


  buffer += "<li>\n<a href=\"";
  if (stack1 = helpers.link) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = depth0.link; stack1 = typeof stack1 === functionType ? stack1.apply(depth0) : stack1; }
  buffer += escapeExpression(stack1)
    + "\">\n<span class=\"headline\">";
  if (stack1 = helpers.title) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = depth0.title; stack1 = typeof stack1 === functionType ? stack1.apply(depth0) : stack1; }
  buffer += escapeExpression(stack1)
    + "</span>\n</a>\n<br>\n<span class=\"sponsor\">Sponsored By: "
    + escapeExpression(((stack1 = ((stack1 = depth0.sponsor),stack1 == null || stack1 === false ? stack1 : stack1.name)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</span>\n</li>\n\n";
  return buffer;
  };

 /*

   This function represents a pre-compiled Handlebars template. Pre-compiled
   templates are not pretty, but they provide a very significant performance
   boost, especially on mobile devices. For more information, see
   http://handlebarsjs.com/precompilation.html.

   Note that this code has been generated from the following markup:

<li>
<a href="{{link}}">
<span class="headline">{{title}}</span>
</a>
<br>
<span class="sponsor">Sponsored By: {{sponsor.name}}</span>
</li>



  */

  compiledTemplate7 = function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, functionType="function", escapeExpression=this.escapeExpression;


  buffer += "<li>\n<a href=\"";
  if (stack1 = helpers.link) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = depth0.link; stack1 = typeof stack1 === functionType ? stack1.apply(depth0) : stack1; }
  buffer += escapeExpression(stack1)
    + "\">\n<span class=\"headline\">";
  if (stack1 = helpers.title) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = depth0.title; stack1 = typeof stack1 === functionType ? stack1.apply(depth0) : stack1; }
  buffer += escapeExpression(stack1)
    + "</span>\n</a>\n<br>\n<span class=\"sponsor\">Sponsored By: "
    + escapeExpression(((stack1 = ((stack1 = depth0.sponsor),stack1 == null || stack1 === false ? stack1 : stack1.name)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</span>\n</li>\n\n";
  return buffer;
  };

 /*

   This function represents a pre-compiled Handlebars template. Pre-compiled
   templates are not pretty, but they provide a very significant performance
   boost, especially on mobile devices. For more information, see
   http://handlebarsjs.com/precompilation.html.

   Note that this code has been generated from the following markup:

<li>
<a href="{{link}}">
<span class="headline">{{title}}</span>
</a>
<br>
<span class="sponsor">Sponsored By: {{sponsor.name}}</span>
</li>



  */

  compiledTemplate8 = function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, functionType="function", escapeExpression=this.escapeExpression;


  buffer += "<li>\n<a href=\"";
  if (stack1 = helpers.link) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = depth0.link; stack1 = typeof stack1 === functionType ? stack1.apply(depth0) : stack1; }
  buffer += escapeExpression(stack1)
    + "\">\n<span class=\"headline\">";
  if (stack1 = helpers.title) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = depth0.title; stack1 = typeof stack1 === functionType ? stack1.apply(depth0) : stack1; }
  buffer += escapeExpression(stack1)
    + "</span>\n</a>\n<br>\n<span class=\"sponsor\">Sponsored By: "
    + escapeExpression(((stack1 = ((stack1 = depth0.sponsor),stack1 == null || stack1 === false ? stack1 : stack1.name)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</span>\n</li>\n\n";
  return buffer;
  };

})();

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s);
  js.id = id; js.type = "text/javascript"; js.async = true;
  js.src = "http://plugin.mediavoice.com/plugin.js";
  fjs.parentNode.insertBefore(js, fjs);
})(document, "script", "nativeads-plugin");