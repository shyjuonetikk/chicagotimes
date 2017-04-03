<?php

/**
 * YieldMo Test Tags
 */
 class CST_YieldMo_Tags {

    private static $instance;

    public static function get_instance() {

        if ( ! isset( self::$instance ) ) {
            self::$instance = new CST_YieldMo_Tags;
        }
        return self::$instance;
    }

    public function ym_get_demo_tag($ym_tag) {

        switch ( $ym_tag ) {

            case 'YM_Carousel_Demo':
                return $this->ym_carousel_demo();
                break;
            case 'YM_Video_Demo':
                return $this->ym_video_demo();
                break;
            case 'YM_Window_Demo':
                return $this->ym_window_demo();
                break;
            case 'YM_Wrapper_Homepage_Demo':
                return $this->ym_homepage_wrapper_demo();
                break;
            case 'YM_Wrapper_Article_Demo':
                return $this->ym_article_wrapper_demo();
                break;
            case 'YM_Mainstage_Demo':
                return $this->ym_mainstage_demo();
                break;
            default:
                break;
        }

    }

    public function ym_carousel_demo() {
        if( is_singular() ) :
    ?>
        <div id="div-gpt-ym-carousel"></div>
            <script>
                googletag.cmd.push(function() {
                    googletag.display('div-gpt-ym-carousel');
                });
            </script>
        <script>window.YIELDMO_DEMO_TAG = 'div-gpt-ym-carousel';</script>
    <?php else : ?>
        <div id="ym_1415038328455411872" class="ym"></div><script type="text/javascript">(function(e,t){if(t._ym===void 0){t._ym="";var m=e.createElement("script");m.type="text/javascript",m.async=!0,m.src="//static.yieldmo.com/ym.m5.js",(e.getElementsByTagName("head")[0]||e.getElementsByTagName("body")[0]).appendChild(m)}else t._ym instanceof String||void 0===t._ym.chkPls||t._ym.chkPls()})(document,window);</script>
    <?php
        endif;
    }

    public function ym_video_demo() {
        if( is_singular() ) :
    ?>
        <script>window.YIELDMO_DEMO_TAG = 'div-gpt-ym-video';</script>
        <div id="div-gpt-ym-video"></div>
            <script>
                googletag.cmd.push(function() {
                    googletag.display('div-gpt-ym-video');
                });
            </script>
        </div>
    <?php else : ?>
        <div id="ym_1415040035604248738" class="ym"></div><script type="text/javascript">(function(e,t){if(t._ym===void 0){t._ym="";var m=e.createElement("script");m.type="text/javascript",m.async=!0,m.src="//static.yieldmo.com/ym.m5.js",(e.getElementsByTagName("head")[0]||e.getElementsByTagName("body")[0]).appendChild(m)}else t._ym instanceof String||void 0===t._ym.chkPls||t._ym.chkPls()})(document,window);</script>
    <?php
        endif;
    }

    public function ym_window_demo() {
        if( is_singular() ) :
    ?>
        <script>window.YIELDMO_DEMO_TAG = 'div-gpt-ym-window';</script>
        <div id="div-gpt-ym-window"></div>
            <script>
                googletag.cmd.push(function() {
                    googletag.display('div-gpt-ym-window');
                });
            </script>
        </div>
    <?php else : ?>
        <div id="ym_1415041620942108836" class="ym"></div><script type="text/javascript">(function(e,t){if(t._ym===void 0){t._ym="";var m=e.createElement("script");m.type="text/javascript",m.async=!0,m.src="//static.yieldmo.com/ym.m5.js",(e.getElementsByTagName("head")[0]||e.getElementsByTagName("body")[0]).appendChild(m)}else t._ym instanceof String||void 0===t._ym.chkPls||t._ym.chkPls()})(document,window);</script>
    <?php
        endif;
    }

    public function ym_homepage_wrapper_demo() {
    ?>
        <div id="ym_1415063768016468138" class="ym"></div><script type="text/javascript">(function(e,t){if(t._ym===void 0){t._ym="";var m=e.createElement("script");m.type="text/javascript",m.async=!0,m.src="//static.yieldmo.com/ym.m5.js",(e.getElementsByTagName("head")[0]||e.getElementsByTagName("body")[0]).appendChild(m)}else t._ym instanceof String||void 0===t._ym.chkPls||t._ym.chkPls()})(document,window);</script>
    <?php
    }

    public function ym_article_wrapper_demo() {
    ?>
        <div id="ym_1415065486104049838" class="ym"></div><script type="text/javascript">(function(e,t){if(t._ym===void 0){t._ym="";var m=e.createElement("script");m.type="text/javascript",m.async=!0,m.src="//static.yieldmo.com/ym.m5.js",(e.getElementsByTagName("head")[0]||e.getElementsByTagName("body")[0]).appendChild(m)}else t._ym instanceof String||void 0===t._ym.chkPls||t._ym.chkPls()})(document,window);</script>
    <?php
    }

    public function ym_mainstage_demo() {
        if( is_singular() ) :
    ?>
        <script>window.YIELDMO_DEMO_TAG = 'div-gpt-ym-mainstage';</script>
        <div id="div-gpt-ym-mainstage"></div>
            <script>
                googletag.cmd.push(function() {
                    googletag.display('div-gpt-ym-mainstage');
                });
            </script>
        </div>
    <?php else : ?>
        <div id="ym_1415042179262691494" class="ym"></div><script type="text/javascript">(function(e,t){if(t._ym===void 0){t._ym="";var m=e.createElement("script");m.type="text/javascript",m.async=!0,m.src="//static.yieldmo.com/ym.m5.js",(e.getElementsByTagName("head")[0]||e.getElementsByTagName("body")[0]).appendChild(m)}else t._ym instanceof String||void 0===t._ym.chkPls||t._ym.chkPls()})(document,window);</script>
    <?php
        endif;
    }

}
?>