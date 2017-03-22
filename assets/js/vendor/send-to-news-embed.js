var s2nVideoPlayer = function(obj) {
  if (this === window) {
    return new s2nVideoPlayer(obj);
  }

  var type = typeof obj;

  if (type === "string") {
    objects = document.getElementsByClassName('k-' + obj);
    this.el = objects[0];
  } else {

    var parts = this.parseUrl('script');

    if(parts['fk']){
      key = parts['fk'];
    } else if(parts['SC']){
      key = parts['SC'];
    }

    objects = document.getElementsByClassName('k-' + key);
    this.el = objects[0];
  }

  return obj;

};

s2nVideoPlayer.prototype = {
  setup: function(){

    var params = this.parseUrl('script');
    var paramType = typeof params;
    var type = '';
    var fk = '';
    var sc = '';
    var cid = '';
    var sk = '';
    var mk = '';
    var pk = '';
    var recache = '';
    var autoplay = '';
    var sound = '';
    var playerParams = ['type', 'fk', 'SC', 'cid', 'sk', 'mk', 'pk', 'recache', 'autoplay', 'sound', 'ref', 'offsetx', 'offsety', 'floatwidth', 'floatpostion', 'animation'];
    var useSSL = 'https:' === document.location.protocol;
    var srcDomain = useSSL ? 'https:' : 'http:'+'//embed.sendtonews.com';
    var srcDir = '/player3/embedplayer.php?';
    var srcParams = '';
    var barkerHeight = '';
    var sidebarPlaylistDisplay = '';
    var sidebarUpNext = '';
    var sidebarHeader = '';
    var sidebarLogo = '';
    var s2nParentWidth = '';
    var parentDiv = this.el;
    var playerDiv = '';
    var transitionComplete = true;
    var playerPosition = 'fixed';
    var playerType = 'float';
    var offsetX = 0;
    var offsetY = 0;
    var screenLocation = 'bottom right';
    var aspectRatio = 16 / 9;
    var floatWidth = 300;
    var floatHeight = 194;
    var animation = 'off';
    var keyFrames = '';
    var isMobile = navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry)/);
    var scriptTags = document.querySelectorAll('[data-type="s2nScript"]');
    // var isSafari = navigator.userAgent.includes('Macintosh');
    var isSafari = (navigator.userAgent.indexOf('Macintosh') >= 0);

    var metaTag = document.querySelector('meta[property="og:url"]');
    var metaUrl = (typeof metaTag !== 'undefined' && metaTag !== null) ? metaTag.getAttribute("content") : null;
    if(metaUrl !== null && metaUrl != ''){
      var ref = metaUrl;
      var ogSet = 1;
    } else {
      var ref = window.location.href;
      var ogSet = 0;
    }

    var pageParams = this.parseUrl('page');

    if (paramType === "object") {

      var i = 0;

      if (typeof pageParams.s2nkey !== 'undefined'){
        params['recache'] = '1';
      }

      for (var prop in params){

        if(playerParams.indexOf(params[prop]) !== '-1'){
          if(prop === 'fk'){

            if (typeof pageParams.s2nkey !== 'undefined'){
              var oldDiv = document.getElementsByClassName('k-' + params[prop]);
              oldDiv[0].classList.add('k-' + pageParams.s2nkey);
              oldDiv[0].classList.remove('k-' + params[prop]);
              key = pageParams.s2nkey;
              params[prop] = key;
            } else {
              key = params[prop];
            }
          } else if (prop === 'cid'){
            if (typeof pageParams.s2ncid !== 'undefined'){
              params[prop] = pageParams.s2ncid;
            }
          } else if(prop === 'SC'){
            if (typeof pageParams.s2nkey !== 'undefined'){
              var oldDiv = document.getElementsByClassName('k-' + params[prop]);
              oldDiv[0].classList.add('k-' + pageParams.s2nkey);
              oldDiv[0].classList.remove('k-' + params[prop]);
              key = pageParams.s2nkey;
              params[prop] = key;
            } else {
              key = params[prop];
            }
          } else if(prop === 'offsetx')
            offsetX = parseInt(params[prop]);
          else if(prop === 'offsety')
            offsetY = parseInt(params[prop]);
          else if(prop === 'floatwidth'){
            floatWidth = parseInt(params[prop]);
            floatHeight = ((floatWidth / aspectRatio) + 25);
          }
          else if(prop === 'floatposition')
            screenLocation = params[prop].replace('-',' ');
          else if(prop === 'animation')
            animation = params[prop];

          if(i === 0){
            srcParams += prop + '=' + params[prop];
          } else {
            srcParams += '&' + prop + '=' + params[prop];
          }

        } // EoIf

        i++;

      } // EoFor

      var keyFrames = document.getElementsByClassName('k-' + key);

      // Override flags from query string params
      if (pageParams.s2nplayertype == 'smart'){
        srcDir = '/player3beta/embedplayer.php?';
      } else if (pageParams.s2nplayertype == 'full'){
        keyFrames[0].setAttribute('data-type','full');
        srcDir = '/player2/embedplayer.php?';
      } else if (pageParams.s2nplayertype == 'single'){
        keyFrames[0].setAttribute('data-type','single');
        srcDir = '/player2/embedplayer.php?';
      } else if (pageParams.s2nplayertype == 'barker'){
        playerType = 'barker';
        keyFrames[0].setAttribute('data-type','barker');
        srcDir = '/player2/embedplayer.php?';

        if(typeof pageParams.s2nbarkersize === 'undefined'){
          srcParams += '&SIZE=220';
          barkerHeight = '220';
        } else {
          srcParams += '&SIZE=' + pageParams.s2nbarkersize;

          if(pageParams.s2nbarkersize == 400){
            barkerHeight = '265';
          } else if(pageParams.s2nbarkersize == 500){
            barkerHeight = '313';
          }
        }

      } else if (pageParams.s2nplayertype == 'sidebar'){
        playerType = 'sidebar2';
        keyFrames[0].setAttribute('data-type','sidebar2');
        srcDir = '/player2/embedplayer.php?';
      }

      // var match = scriptTags[0].getAttribute('src').match(/((http:|https:)?\/\/)(www[0-9]?\.)?(.[^\/:]+)/i);
      // if (match != null && match.length > 2 && typeof match[4] === 'string' && match[4].length > 0) {
      //   srcDomain = match[1] + match[4];
      // }

      var keyFrames = document.getElementsByClassName('k-' + key);
      // type = keyFrames[0].dataset.type;
      type = keyFrames[0].getAttribute('data-type');

      srcParams += '&type=' + type;
      srcParams += '&ogSet=' + ogSet;
      if(inIframe()){
        srcParams += '&inIframe=1';
      } else {
        srcParams += '&inIframe=0';
      }
      srcParams += '&ref=' + encodeURIComponent(ref);

    } else {
      throw new Error("Invalid setup object.");
    }

    if(keyFrames.length <= 1){

      writeIframe(parentDiv);

      var playerDiv = parentDiv.firstChild;
      var playerIframe = playerDiv.firstChild;

      var frameOrigin = playerIframe.src;
      var playerPos = playerDiv.getBoundingClientRect();
      var parentPos = parentDiv.getBoundingClientRect();

      setSize(playerDiv, parentDiv);
      bindEvents(playerDiv, parentDiv, key);

      return playerDiv;
    } else {
      var playerDivs = document.getElementsByClassName('k-' + key);
      var numScriptTags = scriptTags.length;

      for(i = 0; i < numScriptTags; i++){
        if(i != 0){
          playerDivs[i].style.display = 'none';
          playerDivs[i].className = 's2nPlayerDisabled';
          scriptTags[i].src = '';
        }
      }
    }

    /*** Begin functions for player creation ***/
    function writeIframe(obj){
      var srcUrl = srcDomain + srcDir + srcParams;

      obj.innerHTML = '<div class="s2nPlayerFrame">' +
        '<iframe id="' + key + '" src="' + srcUrl + '" frameborder="0" scrolling="no" allowfullscreen="true" style="height:100%; width:1px; min-width:100%; margin:0 auto; padding:0; display:block; border:0 none;"></iframe>' +
        '</div>';
    }

    function setSize(playerDiv, parentDiv) {

      paddingWidth = parseInt(window.getComputedStyle(parentDiv.parentNode).paddingRight) + parseInt(window.getComputedStyle(parentDiv.parentNode).paddingLeft);

      var playerWidth = parentDiv.parentNode.offsetWidth - paddingWidth;
      var playerHeight = (playerWidth / aspectRatio);

      var viewableWidth = document.documentElement.clientWidth || window.innerWidth;
      var viewableHeight = document.documentElement.clientHeight || window.innerHeight;

      if(playerPosition == 'float'){

        if(screenLocation.indexOf('top') !== -1){
          var viewportHeight = parentPos.top >= 0 ? -Math.abs(parentPos.top) + offsetY : Math.abs(parentPos.top) + offsetY;
        } else if (screenLocation.indexOf('bottom') !== -1){
          var viewportHeight = (viewableHeight - floatHeight - parentPos.top - offsetY);
        } else if(screenLocation.indexOf('middle') !== -1){
          var viewportHeight = (viewableHeight / 2) - (floatHeight / 2) - parentPos.top - offsetY;
        }

        if(screenLocation.indexOf('left') !== -1){
          var viewportWidth = -Math.abs(parentPos.left) + offsetX;
        } else if(screenLocation.indexOf('right') !== -1){
          var viewportWidth = (viewableWidth - floatWidth - parentPos.left - offsetX);
        } else if(screenLocation.indexOf('middle') !== -1){
          var viewportWidth = (viewableWidth / 2) - (floatWidth / 2) - parentPos.left - offsetX;
        }

        cssString = 'top:'+parentPos.top+'px; left:'+parentPos.left+'px; transform:translate('+viewportWidth+'px,'+viewportHeight+'px); z-index:2147483647';
        playerDiv.style.cssText += ';' + cssString;

        cssString = 'width:' + playerWidth + 'px; height:' + playerHeight + 'px;';

        if(isSafari){
          cssString += 'position:static;'
        } else{
          cssString += 'position:relative;'
        }

        parentDiv.style.cssText += ';' + cssString;

      } else if(playerPosition == 'fixed'){
        if(playerType == 'barker'){
          playerHeight = barkerHeight;
        } else if (playerType == 'sidebar2') {

          var elementHeight = 375;

          if(sidebarLogo == 'off'){
            var elementHeight = elementHeight - 50;
          }

          if(sidebarPlaylistDisplay == 'off' && sidebarUpNext == 'off'){
            var elementHeight = elementHeight - 275;
          } else if(sidebarPlaylistDisplay == 'off'){
            var elementHeight = elementHeight - 245;
          }

          if(sidebarHeader == 'off'){
            var elementHeight = elementHeight - 50;
          }

          playerHeight = (Math.ceil(playerWidth / (16/9)) + elementHeight);
        }
        cssString = 'width:' + playerWidth + 'px; height:' + playerHeight + 'px; position:absolute; top:0px; left:0px; z-index:1;';
        playerDiv.style.cssText += ';' + cssString;

        cssString = 'width:' + playerWidth + 'px; height:' + playerHeight + 'px; position:relative;';
        parentDiv.style.cssText += ';' + cssString;
      }

    }


    function bindEvents(playerDiv, parentDiv, key){

      var playerPos = playerDiv.getBoundingClientRect();
      var parentPos = parentDiv.getBoundingClientRect();
      var playerStarted = false;
      var firstPlay = true;
      var scrolled = false;
      var returnedKey,aniviewAdState;

      // Set a variable to check if the scroll event has occurred
      window.addEventListener('scroll', function(e){
        scrolled = true;
      });

      // Run the scrolling events every 100ms until the scrolling stops
      setInterval(function(){
        if(scrolled){
          scrolled = false;

          transitionComplete = true;

          // If more than 50% of the player is visible and the player is in the fixed position
          if(isPlayerVisible(parentDiv, 0.50) && playerPosition == 'fixed') {

            var playerFrames = document.getElementsByClassName("s2nPlayer");

            // Loop through all of the s2nPlayer frames on the page and check the status of the player
            for(var i = 0; i < playerFrames.length; i++){

              var frameWrapper = playerFrames[i].firstChild;
              var frame = frameWrapper.firstChild;

              var messageData = {'message':'checkplayerstatus','key':key};
              xPostMessage(frame, messageData, frameOrigin);

              window.addEventListener("message", function (e) {

                if(key === e.data.returnedKey && e.data.message == 'playerStatus' && (e.data.playerState == 'playing' || e.data.playerState == 'buffering' || ((e.data.playerState == 'idle' || e.data.playerState == 'paused') && e.data.hasAniview && (e.data.aniviewAdState == 'ADPLAYING' || e.data.aniviewAdState == 'ADPAUSED')))){
                  playerStarted = true;
                  aniviewAdState = e.data.aniviewAdState;
                  returnedKey = e.data.returnedKey;
                } else {
                  playerStarted = false;
                }

              }, false);
            }

            if((typeof playerStarted === 'undefined' || !playerStarted) && (typeof returnedKey === 'undefined' || key === returnedKey)){

              var messageData = {'message':'startplayer','playerPosition':playerPosition,'firstPlay':true};
              xPostMessage(playerIframe, messageData, frameOrigin);

            }

          }

          if (!isPlayerVisible(parentDiv,0.5) && playerPosition == 'fixed' && isMobile && key === returnedKey && aniviewAdState == 'ADPLAYING'){

            var messageData = {'message':'stopAniview'};
            xPostMessage(playerIframe, messageData, frameOrigin);

          }

          if(isPlayerVisible(parentDiv,0.5) && playerPosition == 'fixed' && isMobile && key === returnedKey && aniviewAdState == 'ADPAUSED'){

            var messageData = {'message':'startAniview'};
            xPostMessage(playerIframe, messageData, frameOrigin);

          }


          // Override for controlling the first float so that the player will only pop-out when the top 49% is hidden on the first play
          if(isPlayerVisible(parentDiv,0.49) && playerPosition == 'fixed'){
            firstPlay = false;
          }

          if(!isPlayerVisible(parentDiv,0.49) && playerPosition == 'fixed' && !firstPlay && (typeof returnedKey === 'undefined' || key === returnedKey) && !isMobile){

            var messageData = {'message':'checkplayerstate','playerPosition':playerPosition,'extRef':ref};
            xPostMessage(playerIframe, messageData, frameOrigin);

          } else if(isPlayerVisible(parentDiv, 0.49) && playerPosition == 'float'){

            var messageData = {'message':'checkplayerstate','playerPosition':playerPosition};
            xPostMessage(playerIframe, messageData, frameOrigin);

          }

        } // EoIf

      },100);

      /*** Play, Close Listener ***/
      window.addEventListener('message', function (e) {

        if(e.data.message == 'closeFloat' && e.data.returnedKey == key){
          s2nPlayerFix(playerDiv,parentDiv,playerIframe);
          closePlayer();
        } else if(e.data.message == 'checkPlayerState' && e.data.returnedKey == key){

          if(playerPosition == 'float'){

            var messageData = {'message':'playerFloating'};
            xPostMessage(playerIframe, messageData, frameOrigin);

          }
        } else if(e.data.message == 'fixplayer' && transitionComplete && playerPosition != 'fixed' && e.data.returnedKey == key){

          s2nPlayerFix(playerDiv,parentDiv,playerIframe);

        } else if(e.data.message == 'floatplayer' && transitionComplete && playerPosition != 'float' && e.data.returnedKey == key){

          s2nPlayerFloat(playerDiv,parentDiv,playerIframe);

        } else if(e.data.message == 'closeAllFloats' && e.data.returnedKey !== key){
          if(playerPosition == 'float'){
            s2nPlayerFix(playerDiv,parentDiv,playerIframe);
          }
          closePlayer();
        } else if(e.data.message == 'isVisible' && isPlayerVisible(parentDiv, 0.50) && playerPosition == 'fixed'){

          var playerFrames = document.getElementsByClassName('s2nPlayer');
          var currentFrame = document.getElementsByClassName('k-' + key);

          if (playerFrames[0] == currentFrame[0]){
            var frameWrapper = playerFrames[0].firstChild;
            var frame = frameWrapper.firstChild;

            var messageData = {'message':'checkplayerstatus','key':key};
            xPostMessage(frame, messageData, frameOrigin);

            window.addEventListener("message", function (e) {

              if(e.data.playerState == 'playing' || e.data.playerState == 'buffering'){
                playerStarted = true;
                returnedKey = e.data.returnedKey;
              } else {

                if(typeof e.data.playerState !== 'undefined'){

                  var messageData = {'message':'startplayer','playerPosition':playerPosition,'firstPlay':true};
                  xPostMessage(playerIframe, messageData, frameOrigin);
                }
              }

            }, false);

            if((typeof playerStarted === 'undefined' || !playerStarted) && (typeof returnedKey === 'undefined' || key === returnedKey)){

              var messageData = {'message':'startplayer','playerPosition':playerPosition,'firstPlay':true};
              xPostMessage(playerIframe, messageData, frameOrigin);

            }
          }

        } else if(e.data.message == 'getPlayStatus') {
          var playerStarted = false;
          var playerFrames = document.getElementsByClassName("s2nPlayer");

          for(var i = 0; i < playerFrames.length; i++){

            var frameWrapper = playerFrames[i].firstChild;
            var frame = frameWrapper.firstChild;

            var messageData = {'message':'checkplayerstatus','key':key};
            xPostMessage(frame, messageData, frameOrigin);

            window.addEventListener("message", function (e) {

              if(e.data.playerState == 'playing' || e.data.playerState == 'buffering'){
                playerStarted = true;
                returnedKey = e.data.returnedKey;
              }

            }, false);
          }

          if(!playerStarted){
            var messageData = {'message':'loadNextVideo'};
            xPostMessage(playerIframe, messageData, frameOrigin);
          }

        } else if(e.data.message == 'isAniviewVisible') {
          if(isPlayerVisible(parentDiv,0.75) && playerPosition == 'fixed'){

            var messageData = {'message':'playerIsVisible'};
            xPostMessage(playerIframe, messageData, frameOrigin);

          }
        }

      }, false);

      /*** Resize Listener ***/
      window.addEventListener('resize', function (e) {
        setSize(playerDiv, parentDiv);
      }, true);

      /*** Transition End Listener ***/
      playerDiv.addEventListener('transitionend',function(e){
        transitionComplete = true;
        cssString = 'transition-property:all; transition-duration:0s; transition-timing-function:ease;';
        playerDiv.style.cssText += ';' + cssString;
      },false);

    } // EoF


    function xPostMessage(iframe, messageData, origin){
      iframe.contentWindow.postMessage(messageData, origin);
    }


    function s2nPlayerFloat(playerDiv,parentDiv,s2nIframe){

      var playerPos = playerDiv.getBoundingClientRect();
      var parentPos = playerDiv.parentNode.getBoundingClientRect();
      var viewableWidth = document.documentElement.clientWidth || window.innerWidth;
      var viewableHeight = document.documentElement.clientHeight || window.innerHeight;
      var messageData = {'message':'float'};

      if(screenLocation.indexOf('top') !== -1){
        var viewportHeight = parentPos.top >= 0 ? -Math.abs(parentPos.top) + offsetY : Math.abs(parentPos.top) + offsetY;
      } else if (screenLocation.indexOf('bottom') !== -1){
        var viewportHeight = (viewableHeight - floatHeight - parentPos.top - offsetY);
      } else if(screenLocation.indexOf('middle') !== -1){
        var viewportHeight = (viewableHeight / 2) - (floatHeight / 2) - parentPos.top - offsetY;
      }

      if(screenLocation.indexOf('left') !== -1){
        var viewportWidth = -Math.abs(parentPos.left) + offsetX;
      } else if(screenLocation.indexOf('right') !== -1){
        var viewportWidth = (viewableWidth - floatWidth - parentPos.left - offsetX);
      } else if(screenLocation.indexOf('middle') !== -1){
        var viewportWidth = (viewableWidth / 2) - (floatWidth / 2) - parentPos.left - offsetX;
      }

      cssString = 'z-index:2147483647;';
      parentDiv.style.cssText += ';' + cssString;

      cssString = 'position:fixed; top:'+parentPos.top+'px; left:'+parentPos.left+'px;';
      playerDiv.style.cssText += ';' + cssString;

      playerPosition = 'float';
      s2nIframe.contentWindow.postMessage(messageData, frameOrigin);

      if(transitionComplete){

        transitionComplete = false;

        cssString = 'width:'+floatWidth+'px; height:'+floatHeight+'px; transform:translate('+viewportWidth+'px,'+viewportHeight+'px);z-index:2147483647;';

        if(typeof animation !== 'undefined' && (animation === 'slide' || animation === 'on')){
          cssString += 'transition-property:transform; transition-duration:0.25s; transition-timing-function:ease-in;';
        }

        playerDiv.style.cssText += ';' + cssString;

        if(isSafari){
          cssString = 'position:static;';
          parentDiv.style.cssText += ';' + cssString;
        }
      }
    } // EoF


    function s2nPlayerFix(playerDiv,parentDiv,s2nIframe){

      var framePos = s2nIframe.getBoundingClientRect();
      var parentPos = parentDiv.getBoundingClientRect();
      var parentWidth = parentDiv.offsetWidth;
      var playerHeight = (parentWidth / aspectRatio);
      var viewableWidth = document.documentElement.clientWidth || window.innerWidth;
      var viewableHeight = document.documentElement.clientHeight || window.innerHeight;
      var messageData = {'message':'fixed'};

      if(screenLocation.indexOf('top') !== -1){
        var viewportHeight = parentPos.top >= 0 ? -Math.abs(parentPos.top) + offsetY : Math.abs(parentPos.top) + offsetY;
      } else if (screenLocation.indexOf('bottom') !== -1){
        var viewportHeight = (viewableHeight - floatHeight - parentPos.top - offsetY);
      } else if(screenLocation.indexOf('middle') !== -1){
        var viewportHeight = (viewableHeight / 2) - (floatHeight / 2) - parentPos.top - offsetY;
      }

      if(screenLocation.indexOf('left') !== -1){
        var viewportWidth = -Math.abs(parentPos.left) + offsetX;
      } else if(screenLocation.indexOf('right') !== -1){
        var viewportWidth = (viewableWidth - floatWidth - parentPos.left - offsetX);
      } else if(screenLocation.indexOf('middle') !== -1){
        var viewportWidth = (viewableWidth / 2) - (floatWidth / 2) - parentPos.left - offsetX;
      }

      playerPosition = 'fixed';
      s2nIframe.contentWindow.postMessage(messageData, frameOrigin);

      if(transitionComplete){

        transitionComplete = false;
        cssString = 'position:absolute; top:'+viewportHeight+'px; left:'+viewportWidth+'px; transform:none; z-index:1;';
        playerDiv.style.cssText += ';' + cssString;

        setTimeout(function(e){
          cssString = 'top:0px; left:0px; width:'+parentWidth+'px; height:'+playerHeight+'px;';

          if(typeof animation !== 'undefined' && (animation === 'slide' || animation === 'on')){
            cssString += 'transition-property:width height top left; transition-duration:0.25s; transition-timing-function:ease-in; ';
          }

          playerDiv.style.cssText += ';' + cssString;
        },25);

        if(isSafari){
          cssString = 'position:relative;';
          parentDiv.style.cssText += ';' + cssString;
        }

        setTimeout(function(e){
          cssString = 'z-index:1;';
          parentDiv.style.cssText += ';' + cssString;
        },250);

      }
    } // EoF

    function isPlayerVisible(s2nDivFrame, minVisRatio) {

      var minVisRatio = (typeof minVisRatio !== 'undefined') ? minVisRatio : 1;

      var playerRect = s2nDivFrame.getBoundingClientRect();
      var frameW = window.innerWidth || document.documentElement.clientWidth;
      var frameH = window.innerHeight || document.documentElement.clientHeight;
      var visPlayerInRect = getVisibleRect(playerRect, frameW, frameH);

      var playerW = playerRect.width || (playerRect.right - playerRect.left);
      var playerH = playerRect.height || (playerRect.bottom - playerRect.top);
      var visPlayerW = visPlayerInRect.width;
      var visPlayerH = visPlayerInRect.height;

      var visRatio = (visPlayerW * visPlayerH) / (playerW * playerH);

      // if(minVisRatio === 1)
      // console.log(visRatio);

      return visRatio >= minVisRatio;
    } // EoF

    function getVisibleRect(rect, windowW, windowH) {

      var topo = Math.min(windowH, Math.max(rect.top, 0));
      var bottomo = Math.min(windowH, Math.max(rect.bottom, 0));
      var lefto = Math.min(windowW, Math.max(rect.left, 0));
      var righto = Math.min(windowW, Math.max(rect.right, 0));

      return {
        'top': topo,
        'bottom': bottomo,
        'left': lefto,
        'right': righto,
        'width': (righto - lefto),
        'height': (bottomo - topo)
      };
    } // EoF

    function closePlayer(){
      var messageData = {'message':'resetPlayer'};
      playerIframe.contentWindow.postMessage(messageData, frameOrigin);
    } // EoF

    function inIframe() {
      try {
        return window.self !== window.top;
      } catch (e) {
        return true;
      }
    } // EoF

  },
  removePlayer: function(){
    this.el.innerHTML = '';

    return this.el;
  },
  resetPlayer: function(){
    var frames = document.getElementsByTagName('iframe');
    var len = frames.length;
    var messageData = {'message':'resetPlayer'};
    var messageData2 = {'message':'checkplayerstate'};

    for (var i = 0, len = frames.length; i < len; i++) {
      var s2nIframeOrigin = frames[i].getAttribute('src');
      if (typeof s2nIframeOrigin !== undefined && s2nIframeOrigin !== null && s2nIframeOrigin.indexOf('sendtonews.com', 0) !== -1) {
        frames[i].contentWindow.postMessage(messageData, s2nIframeOrigin);
        frames[i].contentWindow.postMessage(messageData2, s2nIframeOrigin);
      }
    }

    return this.el;
  },
  parseUrl: function(source){
    var parts = {};

    if(source == 'script'){
      // Parse the URL parameters from the script tag
      var currentScript = document.currentScript || (function() {
          var scripts = document.getElementsByTagName('script');
          return scripts[scripts.length - 1];
        })();

      var scriptSrc = currentScript.src.split("?")[1].replace(/=/gi,':').split('&');
    } else if(source == 'page'){
      var pageUrl = window.location.href;
      scriptSrc = pageUrl.split("?");

      if(typeof scriptSrc[1] !== 'undefined') {
        scriptSrc = scriptSrc[1].replace(/=/gi,':').split('&');
      }
    }

    for(i=0;i<scriptSrc.length;i++){
      split = scriptSrc[i].split(':');
      parts[split[0]] = split[1];
    }

    return parts;
  }
}

// Setup a new video object and pass it the parsed URL parameters
var s2nVideo = new s2nVideoPlayer();
s2nVideo.setup();