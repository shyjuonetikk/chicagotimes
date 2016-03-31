<?php

class CST_Nativo_Article_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'cst_nativo_article',
            esc_html__( 'CST Nativo Article', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Display the Nativo Sponsored links on Article Pages.', 'chicagosuntimes' ),
            )
        );

    }

    public function widget( $args, $instance ) {
    
        if( is_single() ) :

            $obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
            if( $obj ) {

                print_r($obj);

            }

        endif;
    }

    public function form( $instance ) {

    }

    public function cst_nativo_determine_positions($slug) {

        $positions = array();
        switch( $slug ) {

            case 'news':
                $positions = array( 'News1', 'News2' );
                break;
            case 'chicago':
                $positions = array('NewsChi1', 'NewsChi2' );
                break;
            case 'crime':
                $positions = array( 'NewsCrime1', 'NewsCrime2' );
                break;
            case 'the-watchdogs':
                $positions = array( 'NewsWatch1', 'NewsWatch2' );
                break;
            case 'nation-world':
                $positions = array( 'NewsNation1', 'NewsNation2' );
                break;
            case 'education':
                $positions = array( 'NewsEdu1', 'NewsEdu2' );
                break;
            case 'transportation':
                $positions = array( 'NewsTrans1', 'NewsTrans2' );
                break;
            case 'business':
                $positions = array( 'NewsBus1', 'NewsBus2' );
                break;
            case 'sneed':
                $positions = array( 'NewsSneed1', 'NewsSneed2' );
                break;
            case 'chicago-politics':
                $positions = array( 'PolChi1', 'PolChi2' );
                break;
            case 'springfield-politics':
                $positions = array( 'PolSpring1', 'PolSpring2' );
                break;
            case 'washington-politics':
                $positions = array( 'PolWash1', 'PolWash2' );
                break;
            case 'lynn-sweet-politics':
                $positions = array( 'PolSweet1', 'PolSweet2' );
                break;
            case 'rick-morrissey':
                $positions = array( 'SportsMorrissey1', 'SportsMorrissey2' );
                break;
            case 'rick-telander':
                $positions = array( 'SportsTelander1', 'SportsTelander2' );
                break;
            case 'cubs-baseball':
                $positions = array( 'SportsCubs1', 'SportsCubs2' );
                break;
            case 'white-sox':
                $positions = array( 'SportsSox1', 'SportsSox2' );
                break;
            case 'bears':
                $positions = array( 'SportsBears1', 'SportsBears2' );
                break;
            case 'blackhawks':
                $positions = array( 'SportsHawks1', 'SportsHawks2' );
                break;
            case 'bulls':
                $positions = array( 'SportsBulls1', 'SportsBulls2' );
                break;
            case 'outdoor':
                $positions = array( 'SportsOutdoor1', 'SportsOutdoor2' );
                break;
            case 'fire':  
                $positions = array( 'SportsFire1', 'SportsFire2' );
                break;
            case 'colleges':
                $positions = array( 'SportsColleges1', 'SportsColleges2' );
                break;
        }
    }

    public function update( $new_instance, $old_instance ) {
        $new_instance = $old_instance;
    }

}