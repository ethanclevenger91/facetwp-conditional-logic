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


class FacetWP_Conditional_Logic
{

    public $rules;
    public $facets = array();
    public $templates = array();


    function __construct() {
        define( 'FWPCL_VERSION', '2.2.8' );
        define( 'FWPCL_DIR', dirname( __FILE__ ) );
        define( 'FWPCL_URL', plugins_url( basename( FWPCL_DIR ) ) );
        define( 'FWPCL_BASENAME', plugin_basename( __FILE__ ) );

        add_action( 'init', array( $this, 'init' ), 12 );
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }


    function init() {
        add_action( 'wp_footer', array( $this, 'render_js' ), 25 );
        add_action( 'wp_ajax_fwpcl_save', array( $this, 'save_rules' ) );

        $this->facets = FWP()->helper->get_facets();
        $this->templates = FWP()->helper->get_templates();

        $rules = get_option( 'fwpcl_rules' );
        $this->rules = empty( $rules ) ? array() : json_decode( $rules, true );
    }


    /**
     * Save rules
     */
    function save_rules() {
        if ( current_user_can( 'manage_options' ) ) {
            $rules = stripslashes( $_POST['data'] );
            $json_test = json_decode( $rules, true );

            // Check for valid JSON
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


    function render_js() {
        echo '<pre>';
        var_dump($this->rules);
        echo '</pre>';

        
?>
<script>
(function($) {
    $(document).on('facetwp-loaded', function() {
    });
})(jQuery);
</script>
<?php
    }


    /**
     * Register the FacetWP settings page
     */
    function admin_menu() {
        add_options_page( 'FacetWP Logic', 'FacetWP Logic', 'manage_options', 'facetwp-logic', array( $this, 'settings_page' ) );
    }


    function settings_page() {
        include( dirname( __FILE__ ) . '/page-settings.php' );
    }
}


new FacetWP_Conditional_Logic();
