if ( Centro.id ) {
  var ssaUrl = ("https:" == document.location.protocol ? "https://" : "http://") + "centro.pixel.ad/iap/"+Centro.id;
  new Image().src = ssaUrl;
}