<!-- navigation -->
  <div class="row">
    <div id="fixed-nav-wrapper" class="large-12 columns sticky">
      <nav class="top-bar" data-topbar="" role="navigation">
          <ul class="title-area">
            <li class="name">
            </li>
            <li class="toggle-topbar menu-icon"><a href=""><span><?php esc_html_e( 'Navigation', 'chicagosuntimes' ); ?></span></a></li>
          </ul>

          
          <section id="fixed-nav" class="top-bar-section" style="left: 0%;">
            <ul class="left navigation">
              <?php wp_nav_menu( array( 'theme_location' => 'homepage-menu', 'fallback_cb' => false ) ); ?>
              <div class="social-sharing show-for-large-up">
                <a href="https://www.facebook.com/thechicagosuntimes" class="sharer facebook-share" title="Follow on Facebook" target="_blank">
                    <span class="fa fa-facebook"></span>
                </a>
                <a href="https://twitter.com/suntimes" class="sharer twitter-share" title="Follow on Twitter" target="_blank">
                    <span class="fa fa-twitter"></span>
                </a>
                <a href="https://itunes.apple.com/us/app/chicago-sun-times-network/id930568136?mt=8" class="app-download">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/appstore.svg" />
                </a>
                <a href="https://play.google.com/store/apps/details?id=com.aggrego.Chicago.il" class="app-download">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/googleplay.png" />
                </a>
              </div>
            </ul>
          </section>
        </nav>
    </div>
  </div>
</header>
<!-- / navigation -->