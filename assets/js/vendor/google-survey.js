
window.GoogleSurvey = {

  inject: function(){
    var postContent = document.querySelector("*[itemprop*='articleBody']")

    if(!postContent)
      return

    var paragraphs = this._getChildNodes(postContent)

    if(!this.shouldDisplaySurvey(paragraphs))
      return

    this._moveParagraphsOutOfPremiumSection(postContent, paragraphs, 0)

    this._makePremium(postContent)
    this.showSurvey()
  },

  _moveParagraphsOutOfPremiumSection: function(postContent, paragraphs, paragraphsToShow){
    for(var i = 0; i < paragraphsToShow; i++){
      if(!paragraphs[i])
        break
      postContent.parentNode.insertBefore(
        postContent.removeChild( paragraphs[i] ), postContent
      )
    }
  },

  /* Private methods */

  _makePremium: function(node){
    node.className = [node.className, "p402_premium"].join(" ")
  },

  shouldDisplaySurvey: function(paragraphs){
    return paragraphs.length >= 1 && jQuery( document ).width() >= 767
  },

  _getChildNodes: function(parentContent){
    return Array.prototype.slice.apply(jQuery(parentContent).children("div,p"))
  },

  showSurvey: function(){
    try { _402_Show(); } catch(e){console.log(e);}
  }

}
