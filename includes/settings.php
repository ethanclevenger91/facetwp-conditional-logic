<?php
/**
 * FacetWP Conditional Logic Settings Page Structure
 *
 * @package   fwpcl_uix
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */

$pages = array(
	'admin'   => array(
		'page_title'  =>  esc_html__( 'Conditional Logic', 'facetwp-conditional-logic' ),
		'menu_title'  =>  esc_html__( 'FacetWP Logic', 'facetwp-conditional-logic' ),
		'capability'  =>  'manage_options',
		'save_button' =>  esc_html__( 'Save Changes', 'facetwp-conditional-logic' ),
		'parent'	  =>  'options-general.php',
		'base_color'  => '#906fbc',
		'modals'	  =>  array(
			'ruleset'	=> FWPCL_DIR . '/includes/templates/ruleset-modal.php',
		),
		'tabs'        =>  array(                                                        // tabs array are for setting the tab / section templates
			'filters'		=> array(
				'partials'			=> array(
					'conditional_row' => FWPCL_DIR . '/includes/templates/conditional-row.php',           // the template to define the tab content and values
					'action'          => FWPCL_DIR . '/includes/templates/action.php',           // the template to define the tab content and values
				),
				'template'          => FWPCL_DIR . '/includes/templates/conditional-panel.php',           // the template to define the tab content and values
				'styles'	=> array(
					'conditionals' => FWPCL_URL . '/includes/templates/conditionals.css'
				),
				'default'	=> true,
			),
		),
		'help'	=> array(
			'default-help' => array(
				'title'		=> 	esc_html__( 'Easy to add Help' , 'facetwp-conditional-logic' ),
				'content'	=>	"Just add more items to this array with a unique slug/key."
			),
			'more-help' => array(
				'title'		=> 	esc_html__( 'Makes things Easy' , 'facetwp-conditional-logic' ),
				'content'	=>	"the content can also be a file path to a template"
			)
		),
		'help_sidebar' => 'This can be html or a path to a file as well.'
	),
);

/**
 * Filter settings pages to allow extending settings structure
 *
 * @param array $params any defined save_params.
 */
return apply_filters( 'facetwp-conditional-logic-settings-page', $pages );

