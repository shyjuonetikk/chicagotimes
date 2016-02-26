window.YieldMo = {

  /*
     Public Method for injecting yieldmo tags into body of the article
     Contains all the logic for setting up yield mo tags
     */
  inject: function(sectionNames){
    var postContent = document.querySelector("*[itemprop*='articleBody']")
    if(!postContent)
      return

    var paragraphs = Array.prototype.slice.call(jQuery(postContent).children("p"))
    var paragraphsCount = paragraphs.length
    if(!paragraphsCount)
      return

    var tags = this._tagsForSectionName(sectionNames)
    if(!tags)
      return

    var contentTag = tags["content"];
    if(paragraphsCount >= 6 && contentTag != "")
      insertParagraphAfter(paragraphs[1], this._yieldMoHTMLTag(contentTag));

    var contentTag = tags["content2"];
    if(paragraphsCount >= 11 && contentTag != "")
      insertParagraphAfter(paragraphs[5], this._yieldMoHTMLTag(contentTag));

    var footerTag = tags["footer"];

    if(footerTag != ""){
      var newNode = document.createElement("p")
      newNode.innerHTML = this._yieldMoHTMLTag(footerTag);
      postContent.appendChild(newNode)
    }
    this._insertYieldMoJS()
  },

  /* Private methods */
  _insertYieldMoJS: function(){
    (function(e,t){if(t._ym===void 0){t._ym="";var m=e.createElement("script");m.type="text/javascript",m.async=!0,m.src="//static.yieldmo.com/ym.m4.js",(e.getElementsByTagName("head")[0]||e.getElementsByTagName("body")[0]).appendChild(m)}else t._ym instanceof String||void 0===t._ym.chkPls||t._ym.chkPls()})(document,window);
  },

  _tags: {
    "sports": { "content": "ym_855676297883098810", "content2": "ym_1135511892507605189", "footer": "ym_855676445589708476" },
    "news": { "content":  "ym_841923243753021123",  "content2": "ym_1135511543642175683", "footer": "ym_841923358878277329" },
    "chicago": { "content":  "ym_841923243753021123",  "content2": "ym_1135511543642175683", "footer": "ym_841923358878277329" },
    "homepage": { "content": "ym_841922833013218953", "content2": "ym_1135511067337013442", "footer": "ym_841923066216521360"},
    "entertainment": { "content": "ym_855676632286568126", "content2": "ym_1135512239997302982", "footer":  "ym_855676780395830976"}
  },

  _tagsForSectionName: function(sectionNames){
    var sectionNames = sectionNames.map(Function.prototype.call, String.prototype.toLowerCase)
    for(i = 0; i< sectionNames.length; i++){
      var categoryTags = this._tags[sectionNames[i]]
      if(categoryTags){
        return categoryTags;
      }
    }
  },

  _yieldMoHTMLTag: function(tag){
    return "<div id='" + tag + "' class='ym'></div>";
  }

}

function insertParagraphAfter(referenceNode, html){
      var newNode = document.createElement("p")
      newNode.innerHTML = html
      referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
      return newNode
  }

