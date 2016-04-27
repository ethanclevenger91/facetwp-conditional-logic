<?php
/**
 * Ruleset Modal Template
 *
 * @package   facetwp-conditional-logic
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link      
 * @copyright 2016 David Cramer
 */
?>

<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">
				<label for="name"><?php esc_html_e( 'Name' ); ?></label>
			</th>
			<td>
				<input type="text" class="regular-text" value="{{name}}" name="name" id="ruleset-name" required="required">
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label><?php esc_html_e( 'Effect' ); ?></label>
			</th>
			<td>
				<label><input type="radio" value="appear" name="animate" {{#is animate value="appear"}}checked="checked"{{/is}}><?php esc_html_e( 'Appear' ); ?></label>&nbsp;
				<label><input type="radio" value="fade" name="animate" {{#is animate value="fade"}}checked="checked"{{/is}}><?php esc_html_e( 'Fade' ); ?></label>&nbsp;
				<label><input type="radio" value="slide" name="animate" {{#is animate value="slide"}}checked="checked"{{/is}}><?php esc_html_e( 'Slide' ); ?></label>
			</td>
		</tr>
	</tbody>
</table>
{{#is name value="untitled"}}
	{{#script}}
	setTimeout( function(){ jQuery('#ruleset-name').focus().select(); }, 250 );
	{{/script}}
{{/is}}