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
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }


    function init() {
        if ( ! function_exists( 'FWP' ) ) {
            return;
        }

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
                var_dump( $rules );
                echo __( 'Rules saved', 'fwpcl' );
            }
            else {
                echo __( 'Error: invalid JSON', 'fwpcl' );
            }
        }
        exit;
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


    function render_js() {
        $if_statements = array();
        $group_or = array();
        $actions = array();

        foreach ( $this->rules as $rule_num => $ruleset ) {
            foreach ( $ruleset['conditions'] as $or_num => $group ) {
                $group_and = array();

                foreach ( $group as $condition ) {
                    $group_and[] = $this->build_if_clause( $condition );
                }

                $group_or[ $rule_num ][ $or_num ] = implode( ' && ', $group_and );
            }

            foreach ( $ruleset['actions'] as $action ) {
                $actions[ $rule_num ][] = $this->build_action( $action );
            }

            $if_statements[ $rule_num ] = array(
                'if'    => implode( ' || ', $group_or[ $rule_num ] ),
                'then'  => $actions[ $rule_num ]
            );
        }
?>

<!-- BEGIN: FacetWP Conditional Logic -->

<style type="text/css">
.fwp-hidden { display: none !important; }
</style>

<script>
function is_intersect(array1, array2) {
    var result = array1.filter(function(n) {
        return array2.indexOf(n) != -1;
    });
    return result.length > 0;
}

(function($) {
    $(document).on('facetwp-loaded', function() {
<?php
foreach ( $if_statements as $clause ) :
?>
        if (<?php echo $clause['if']; ?>) {
            <?php echo implode( "\n            ", $clause['then'] ); ?>

        }
<?php endforeach; ?>
    });
})(jQuery);
</script>

<!-- END: FacetWP Conditional Logic -->

<?php
    }


    function build_if_clause( $condition ) {
        $clause = '';
        $object = $condition['object'];
        $compare = $condition['compare'];
        $value = $condition['value'];

        if ( 'uri' == $object ) {
            $operator = ( 'is' == $compare ) ? '==' : '!=';
            $clause = "FWP_HTTP.uri $operator '$value'";
        }
        elseif ( 'facets-empty' == $object ) {
            $clause = "FWP.build_query_string() == ''";
        }
        elseif ( 'facets-not-empty' == $object ) {
            $clause = "FWP.build_query_string() != ''";
        }
        elseif ( 'facet-' == substr( $object, 0, 6 ) ) {
            $name = substr( $object, 6 );
            $values = explode( "\n", trim( $value ) );
            $values = array_map( 'trim', $values );
            $values = implode( "','", $values );
            $values = empty( $values ) ? '' : "'$values'";

            $operator = ( 'is' == $compare ) ? '' : '! ';
            $clause = "{$operator}is_intersect(FWP.facets['$name'], [$values])";
        }
        elseif ( 'template-' == substr( $object, 0, 9 ) ) {
            $name = substr( $object, 9 );
            $operator = ( 'is' == $compare ) ? '==' : '!=';
            $clause = "FWP.template $operator '$name'";
        }

        return $clause;
    }


    function build_action( $action ) {
        $selectors = array();
        $toggle = $action['toggle'];
        $object = (array) $action['object'];

        foreach ( $object as $item ) {
            if ( 'template' == $item ) {
                $selectors[] = '.facetwp-template';
            }
            elseif ( 'facets' == $item ) {
                $selectors[] = '.facetwp-facet';
            }
            elseif ( 'facet-' == substr( $item, 0, 6 ) ) {
                $selectors[] = '.facetwp-' . $item;
            }
        }

        if ( ! empty( $selectors ) ) {
            $selectors = implode( ', ', $selectors );
            $toggle = ( 'show' == $toggle ) ? 'removeClass' : 'addClass';
            return "$('$selectors').$toggle('fwp-hidden');";
        }

        return '';
    }
}


new FacetWP_Conditional_Logic_Addon();
