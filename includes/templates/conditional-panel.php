<?php
/**
 * Panel template for Setup conditional logic.
 *
 * @package   FacetWP_Conditional_logic
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */

?>
<div class="uix-control-box">

	<table class="uix-control-bar" cellspacing="0" cellpadding="0">
		<tr>
			<td class="uix-control-bar-action left">
				<button type="button" class="button"

					data-title="<?php echo esc_attr( 'Add Ruleset' ); ?>"
					data-height="190"
					data-width="500"

					
					data-modal="ruleset"
					data-template="ruleset"
					data-focus="true"
					data-buttons="create"
					data-footer="conduitModalFooter"
					data-default='{"name":"untitled"}'

					class="button" 

				><?php _e('Add Ruleset', 'facetwp-conditional-logic'); ?></button>
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</div>	
<hr>

{{#each ruleset}}
	
	<div class="uix-control-box ruleset-row-{{_id}}" style="margin-bottom: 18px;">
		{{:node_point}}	
		<table class="uix-control-bar" cellspacing="0" cellpadding="0">
			<tr>
				<td class="uix-control-bar-action left"

					data-title="<?php echo esc_attr( 'Ruleset' ); ?>"
					data-height="190"
					data-width="500"

					
					data-modal="{{_node_point}}"
					data-template="ruleset"
					data-focus="true"
					data-buttons="save delete"
					data-footer="conduitModalFooter"

				><span class="dashicons dashicons-admin-generic"></span></td>
				<td>{{name}}<input type="hidden" name="{{:name}}[name]" value="{{name}}"></td>

			</tr>
		</table>
		
		<div class="uix-control-box-content">
			{{#unless condition}}
				<p class="description"><?php _e('No rules yet', 'facetwp-conditional-logic'); ?></p>
			{{else}}
				<div class="uix-grid">
					<div class="row">
						<div class="col-sm-6">
							{{#each condition}}
								{{> conditional_row}}
							{{/each}}
						</div>
						<div class="col-sm-6">
							{{> action}}
						</div>
						<div class="clear"></div>
					</div>
				</div>
			{{/unless}}


		</div>
		<table class="uix-control-bar" cellspacing="0" cellpadding="0">
			<tr>
				<td class="uix-control-bar-action left">
					{{#unless condition}}
						<button type="button" class="button button-small" data-add-node="{{_node_point}}.condition" data-node-default='{"type":"and"}'>
							<?php _e('Add a Rule', 'facetwp-conditional-logic'); ?>
						</button>
					{{else}}
						<button type="button" class="button" style="text-transform: uppercase;" data-add-node="{{_node_point}}.condition" data-node-default='{"type":"and"}'>
							<?php _e('And', 'facetwp-conditional-logic'); ?>
						</button>
					{{/unless}}
				</td>
				<td>&nbsp;</td>				
				
			</tr>
		</table>
	</div>					
{{/each}}

