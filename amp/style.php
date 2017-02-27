/* Generic WP styling */
amp-img.alignright { float: right; margin: 0 0 1em 1em; }
amp-img.alignleft { float: left; margin: 0 1em 1em 0; }
amp-img.aligncenter { display: block; margin-left: auto; margin-right: auto; }
.alignright { float: right; }
.alignleft { float: left; }
.aligncenter { display: block; margin-left: auto; margin-right: auto; }
.wp-caption.alignleft { margin-right: 1em; }
.wp-caption.alignright { margin-left: 1em; }
.amp-wp-enforced-sizes {/** Our sizes fallback is 100vw, and we have a padding on the container; the max-width here prevents the element from overflowing. **/
max-width: 100%;
}
.amp-wp-unknown-size img {object-fit: contain; }
/* Template Styles */
.amp-wp-content, .amp-wp-title-bar div {
<?php $content_max_width = absint( $this->get( 'content_max_width' ) ); ?>
<?php if ( $content_max_width > 0 ) : ?>
max-width: <?php echo sprintf( '%dpx', $content_max_width ); ?>;
margin: 0 auto;
<?php endif; ?>
}
body {font-family: 'Merriweather', Serif;font-size: 16px;line-height: 1.8;background: #fff;color: #3d596d;}
.amp-wp-content {padding: 16px;overflow-wrap: break-word;word-wrap: break-word;font-weight: 400;color: #3d596d;}
.amp-wp-title {margin: 36px 0 0 0;font-size: 28px;line-height: 1.158;font-weight: 700;color: #2e4453;border-top: 7px solid #F0F0F0;padding-top: 26px;margin-top:12px;float:left;clear:both;width:100%;}
.amp-wp-meta {margin-bottom: 16px;}
p,
ol,
ul,
figure {margin: 0 0 20px 0;clear: both;}
a,
a:visited {color: #0087be;}
a:hover,
a:active,
a:focus {color: #33bbe3;}
/* UI Fonts */
.amp-wp-meta,
.amp-wp-title-bar,
.wp-caption-text,
.cst-recommendations,
.post-meta-social {font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen-Sans", "Ubuntu", "Cantarell", "Helvetica Neue", sans-serif;font-size: 15px;}
/* Meta */
ul.amp-wp-meta {padding: 10px 0 0 0;margin: 0 0 10px 0;float: left;}
ul.amp-wp-meta li {list-style: none;display: inline-block;margin: 0;line-height: 24px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 300px;}
ul.amp-wp-meta li:before {content: "\0007c";margin: 0 8px;}
ul.amp-wp-meta li:first-child:before {display: none;}
.amp-wp-meta,
.amp-wp-meta a {color: #4f748e;}
.amp-wp-meta .screen-reader-text {/* from twentyfifteen */clip: rect(1px, 1px, 1px, 1px);height: 1px;overflow: hidden;position: absolute;width: 1px;}
.amp-wp-byline amp-img {border-radius: 50%;border: 0;background: #f3f6f8;position: relative;top: 6px;margin-right: 6px;}
/* Titlebar */
.amp-wp-title-bar {background: #0a89c0;padding: 12px 16px;background: #000;height: 40px;}
.amp-wp-title-bar div {line-height: 54px;color: #fff;}
.amp-wp-title-bar .site-logo {max-width: 300px;width: 200px;height: 38px;float: left;display: block;}
.site-logo img {max-width: 200px;}
.amp-wp-title-bar button {padding: 1px;border: 0;color: #fff;background: #000;}
.amp-wp-title-bar a {color: #fff;text-decoration: none;}
.amp-wp-title-bar .amp-wp-site-icon {/** site icon is 32px **/float: left;margin: 11px 8px 0 0;border-radius: 50%;}
/* Captions */
.wp-caption-text {padding: 8px 0;font-style: italic;}
.image-caption p {padding-top: 5px;font-style: italic;font-size: 0.8rem;line-height: 1.3rem;margin-bottom: 0;}
/* Quotes */
blockquote {padding: 16px;margin: 8px 0 24px 0;border-left: 2px solid #87a6bc;color: #4f748e;background: #e9eff3;}
blockquote p:last-child {margin-bottom: 0;}
/* Other Elements */
.cst-recommended-content {clear: both;}
.cst-recommended-image {float: left;width: 100%;height: auto;margin-right: 10px;padding: 0;}
.cst-recommended-image img {max-width: 100%;height: auto;display: inline-block;vertical-align: middle;}
.cst-article {box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);float: none;overflow: hidden;height: 65px;margin: 16px 0;border-radius: 2px;background: #f5f5f5;}
a.cst-rec-anchor {text-decoration: none;color: #000;}
.cst-rec-anchor > span {font-size: 0.85rem;font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen-Sans", "Ubuntu", "Cantarell", "Helvetica Neue", sans-serif;font-weight: 400;vertical-align: top;width: 100%;display: block;line-height:1.3rem;}
amp-carousel {height:480px;}
amp-iframe,
amp-youtube,
amp-instagram,
amp-vine {background: #f3f6f8;}
.amp-wp-content .article .post-lead-media amp-iframe.s2nvcloader {background: #fff;max-height: 22rem;min-height: 22rem;}
.article{clear:both;}
amp-carousel > amp-img > img {object-fit: contain;}
.cst-amp-carousel {margin-bottom: 16px;}
.cst-amp-carousel amp-img .caption {z-index:2;position: absolute;bottom: 0;left: 0;right: 0;padding: 8px;background: rgba(0, 0, 0, 0.6);color: #fff;font-size: smaller;max-height: 30%;}
.amp-wp-iframe-placeholder {background: #f3f6f8 url( <?php echo esc_url( $this->get( 'placeholder_image_url' ) ); ?> ) no-repeat center 40%;background-size: 48px 48px;min-height: 48px;}
footer {width: 100%;background-color: #000;padding: 10px 0px;margin: 0 auto;font-family: "Source Sans Pro", sans-serif;}
footer ul {list-style-type: none;padding: 0;margin: 0;display: inline;line-height: 17px;}
footer li {display: inline;text-transform:uppercase;color: #fff;}
footer p {color: #fff;text-transform: uppercase;}
.footer-container {max-width: 600px;margin: 0 auto;padding:0 16px;}
.footer-nav li {display: block;margin-bottom: 2px;}
.footer-nav li a,
.footer-nav li a:visited,
.footer-nav li a:hover  {text-decoration: none;color: #fff;}
.post-meta-social {background-color: #9a9a9a;text-transform:uppercase;color: #fff;padding:0;line-height:16px;}
.post-meta-social a {padding-left:10px;color: transparent;}
.post-social {fill: #fff;}
.post-meta-social a.original-story {font-size: 0.9rem;text-decoration: none;text-transform: none;fill: #fff;color: #fff;vertical-align:top;line-height:3rem;}
amp-social-share[type="twitter"],
amp-social-share[type="facebook"] {background-color: #9a9a9a;text-align: center;color: #fff;font-size: 18px;}
.amp-cst-meta {clear: both;width: 100%;height: 47px;}
.amp-cst-meta .post-meta-social a {padding: 0 5px;display: inline-block;background:#9a9a9a;line-height:16px;}
.amp-cst-meta .post-meta-social {background:transparent;float:right;}
.amp-wp-meta.author{width:100%;}
.post-lead-media {margin-bottom: 12px;}
.amp-wp-content .cst-amp-carousel .captiontext {color: #fff;font-family: "Open Sans", Arial, sans-serif;font-size: 0.9rem;line-height: 1.3rem;margin-bottom: 0;bottom: 0;left: 0;right: 0;z-index: 99999;position: absolute;}
.article .center,.ad-center{text-align:center}.amp-wp-byline amp-img{border-radius:0}.amp-wp-meta .cst-section{text-transform:uppercase;color:#b53939;font-size:0.75rem;line-height:0.9rem;max-width:auto}.amp-wp-meta .top-date{padding-left:10px;color:#9A9A9A;font-size:0.75rem;line-height:0.9rem}ul.amp-wp-meta li.top-date:before{margin:auto;content:''}.wp-caption-text{padding-top:5px;font-style:italic;font-size:0.8rem;line-height:1.3rem;margin-bottom:12px;padding:0}blockquote{background:#fff;margin:0 0 1.25rem;padding:0.5625rem 1.25rem 0 1.1875rem;border-left:1px solid #ddd}blockquote,blockquote p{line-height:1;color:#6f6f6f;font-size:1rem}.section-heading{color:#fff;float:left}nav ul{list-style-type:none;margin:0;padding:0;transition:transform .45s ease-in-out;-webkit-transition:transform .45s ease-in-out}.section-menu{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI","Roboto","Oxygen-Sans","Ubuntu","Cantarell","Helvetica Neue",sans-serif}nav>ul.section-menu>li>ul>li{font-size:14px;padding:3px 0 3px 16px;line-height:30px}nav>ul.section-menu>li>ul>li>a{background-image:none;display:block;text-decoration:none;padding:2px 0 2px 10px;color:#e0e0e0;font-weight:bold;text-indent:0}.section-heading{font-size:40px;line-height:40px}.section-break{background:aliceblue;height:2px;margin-bottom:5px}.section-break,.section-menu .header{font-size:1.2rem;color:#fff}.header{margin-top:1.8rem;margin-bottom:0}.section-menu .colophon{font-size:0.7rem;line-height:0.7rem;margin:58x 0}.colophon:first-child{padding-top:10px}.section-menu>li.colophon a{font-weight:normal;padding:8px 0;color:#fff;text-transform:uppercase;text-decoration:none}.section-menu .copyright{font-size:0.8rem;color:#fff;line-height:12px;position:absolute}.section-menu .menu-item,.section-menu .item{font-size:0.9rem;margin-bottom:0;line-height:30px}.section-menu .menu-item a,.section-menu .item a{text-decoration:none;color:#fff}amp-sidebar{background:#000}amp-sidebar>ul{padding-left:1rem}.cst-button{padding:0px 4px;border:1px solid #000;font-size:2rem;float:right;line-height:2rem}.amp-sidebar .cst-button{float:left}.related{background-color:#f5f5f5;margin:16px 16px;display:block;color:#111;height:75px;padding:0}.related>span{font-size:16px;line-height:75px;font-weight:400;vertical-align:top;margin:8px}.related:hover{background-color:#ccc}amp-sidebar{width:250px;padding-right:10px}.amp-sidebar-image{line-height:100px;vertical-align:middle}.amp-close-image{top:15px;left:225px;cursor:pointer}li{margin-bottom:20px;list-style:none}button{margin-left:20px}amp-app-banner{padding:10px}amp-app-banner .content{display:flex;align-items:center;justify-content:center}amp-app-banner amp-img{background-color:transparent;margin-right:15px}amp-app-banner .description{margin-right:20px}amp-app-banner h5{margin:0}amp-app-banner p{font-size:10px;margin:3px 0}amp-app-banner .actions button{padding:5px;width:70px;border:1px solid #aaa;font-size:8px;background:#fff}amp-app-banner .actions{text-align:right;font-size:14px}#cst-app-banner{display:flex;width:100%;justify-content:center;align-items:center}#banner-text{flex:1;font-size:14px;padding:0 8px}
.pgs-dpg-btn {max-height: 90px;}