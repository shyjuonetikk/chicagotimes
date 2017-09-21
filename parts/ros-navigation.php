<!-- navigation -->
  <div class="row">
    <div id="fixed-nav-wrapper" class="large-12 columns sticky">
      <nav id="fixed-nav" data-topbar role="navigation" data-options="sticky_on: large">
        <ul class="navigation">
          <?php wp_nav_menu( array( 'theme_location' => 'homepage-menu', 'fallback_cb' => false ) ); ?>
        </ul>
      </nav>
    </div>
  </div>
<!-- / navigation -->