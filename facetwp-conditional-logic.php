<?php
/*
Plugin Name: FacetWP - Conditional Logic
Plugin URI: https://facetwp.com/
Description: Show / hide facets depending on certain conditions
Version: 0.1
Author: Matt Gibbs

Copyright 2015 Matt Gibbs

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, see <http://www.gnu.org/licenses/>.
*/

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


class FacetWP_Conditional_Logic_Addon
{

    /**
     * determins if a FacetWP hook was called to propt rendering JS
     *
     * @since 1.0.0
     *
     * @var      bool
     */
    protected $in_use = false;

    function __construct() {
        
        define( 'FWPCL_VERSION', '0.1' );
        define( 'FWPCL_DIR', dirname( __FILE__ ) );
        define( 'FWPCL_URL', plugins_url( '', __FILE__ ) );
        define( 'FWPCL_BASENAME', plugin_basename( __FILE__ ) );

        add_action( 'init', array( $this, 'init' ), 12 );
    }


    function init() {

        if ( ! function_exists( 'FWP' ) ) {
            return;
        }
    
        // include the library
        include_once FWPCL_DIR . '/uix/uix.php';

        // get settings structure
        $structure = include FWPCL_DIR . '/includes/settings.php';

        // initialize admin UI
        $uix = fwpcl_uix::get_instance( 'fwpcl' );
        $uix->register_pages( $structure );

        // register frontend script
        wp_register_script( 'fwpcl-front-handler', FWPCL_URL . '/assets/js/front.min.js', array( 'jquery' ), FWPCL_VERSION, true );

        // do rules on front
        add_action( 'wp_footer', array( $this, 'render_js' ) );

        // put in an action register
        add_filter( "facetwp_render_output", array( $this, "register_facet_use" ) );        

    }

    public function register_facet_use( $output ){
        $this->in_use = true;
        return $output;
    }

    function render_js() {
        
        if( false === $this->in_use ){
            return;
        }

        $rulesets = fwpcl_uix::get_setting( 'admin.filters' );
        if( !empty( $rulesets ) ){
            wp_enqueue_script( 'fwpcl-front-handler' );
            wp_localize_script( 'fwpcl-front-handler', 'FWPCL', $rulesets );
        }

    }

}


new FacetWP_Conditional_Logic_Addon();
