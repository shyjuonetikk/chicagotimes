(function( $ ) {
  "use strict";
  // var input_elements = [
  //   "js-cst-homepage-headlines-one",
  //   "js-cst-homepage-headlines-two",
  //   "js-cst-homepage-headlines-three"
  // ];
  // console.log('CST Customize Preview here.');
  // input_elements.map(function(element) {
  //   wp.customize(element, function (value) {
  //     value.bind(function (to) {
  //       $('#' + element).text(to);
  //     });
  //   });
  // });
  wp.customize('cst_homepage_headlines_one', function (value) {
        value.bind(function (to) {
          $('#js-cst-homepage-headlines-one').text(to);
        });
      });
} )( jQuery );