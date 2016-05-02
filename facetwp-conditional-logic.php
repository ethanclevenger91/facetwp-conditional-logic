<?php
/*
Plugin Name: FacetWP - Conditional Logic
Plugin URI: https://facetwp.com/
Description: Show / hide facets depending on certain conditions
Version: 0.1
Author: Matt Gibbs

Copyright 2016 Matt Gibbs

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

defined( 'ABSPATH' ) or exit;

class FacetWP_Conditional_Logic_Addon
{

    public $rules;
    public $facets = array();
    public $templates = array();


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
        
        add_action( 'wp_footer', array( $this, 'render_js' ), 25 );
        add_action( 'wp_ajax_fwpcl_save', array( $this, 'save_rules' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );

        $this->facets = FWP()->helper->get_facets();
        $this->templates = FWP()->helper->get_templates();

        // load settings
        $rules = get_option( 'fwpcl_rules' );
        $this->rules = empty( $rules ) ? array() : json_decode( $rules, true );

        // register frontend script
        wp_register_script( 'fwpcl-front-handler', FWPCL_URL . '/assets/js/front.js', array( 'jquery' ), FWPCL_VERSION, true );

        // do rules on front
        add_action( 'wp_footer', array( $this, 'render_js' ) );
    }


    function save_rules() {
        if ( current_user_can( 'manage_options' ) ) {
            $rules = stripslashes( $_POST['data'] );
            $json_test = json_decode( $rules, true );

            // check for valid JSON
            if ( is_array( $json_test ) ) {
                update_option( 'fwpcl_rules', $rules );
                echo __( 'Rules saved', 'fwpcl' );
            }
            else {
                echo __( 'Error: invalid JSON', 'fwpcl' );
            }
        }
        exit;
    }


    function admin_menu() {
        add_options_page( 'FacetWP Logic', 'FacetWP Logic', 'manage_options', 'fwpcl-admin', array( $this, 'settings_page' ) );
    }


    function enqueue_scripts( $hook ) {
        if ( 'settings_page_fwpcl-admin' == $hook ) {
            wp_enqueue_script( 'jquery-ui-sortable' );
        }
    }


    function settings_page() {
        include( dirname( __FILE__ ) . '/page-settings.php' );
    }
}


new FacetWP_Conditional_Logic_Addon();
