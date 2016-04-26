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
				<input type="text" class="regular-text" value="{{name}}" name="name" id="name" required="required">
			</td>
		</tr>
	</tbody>
</table>
