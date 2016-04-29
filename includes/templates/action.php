	<?php

	$basic = apply_filters( 'facetwp-conditional-logic-actions', array(
			"template" => "Template",
			"all_facets" => "All Facets",
		) );
	$facets = FWP()->helper->get_facets();

	?>
	<div class="condition-row-line-{{_id}}">
		<table class="uix-control-bar" cellspacing="0" cellpadding="0">
			<tr>
				<td class="uix-control-bar-action left"><span class="dashicons dashicons-no-alt" data-remove-element=".condition-row-line-{{_id}}"></span></td>
				<td class="uix-control-bar-action left" style="text-align: center; width: 61px; background: rgb(239, 239, 239) none repeat scroll 0% 0%; text-transform: uppercase; font-weight: bold; color: rgb(151, 151, 151);">
				{{#if @first}}<?php _e('Then', 'facetwp-conditional-logic'); ?>{{else}}<?php _e('And', 'facetwp-conditional-logic'); ?>{{/if}}
				</td>
				<td>
					{{:node_point}}
					{{#if type}}
						<input type="hidden" name="{{:name}}[type]" value="{{type}}">
					{{/if}}
					<select class="condition-field-select" name="{{:name}}[do]" style="width:80px;">
						<option value="show" {{#is do value="how"}}selected="selected"{{/is}}><?php esc_html_e( 'Show', 'facetwp-conditional-logic' ); ?></option>
						<option value="hide" {{#is do value="hide"}}selected="selected"{{/is}}><?php esc_html_e( 'Hide', 'facetwp-conditional-logic' ); ?></option>
					</select>					
					<select class="condition-field-select" name="{{:name}}[thing]" data-live-sync="true">
						<option></option>
						<optgroup label="<?php esc_html_e( 'Basic', 'facetwp-conditional-logic' ); ?>">
							<?php foreach( $basic as $key=>$value ){ ?>
								<option value="<?php echo $key; ?>" {{#is thing value="<?php echo $key; ?>"}}selected="selected"{{/is}}><?php echo $value; ?></option>
							<?php } ?>
						</optgroup>
						<optgroup label="<?php esc_html_e( 'Facet', 'facetwp-conditional-logic' ); ?>">
							<?php foreach( $facets as $facet ){ ?>
								<option value="<?php echo $facet['name']; ?>" {{#is thing value="<?php echo $facet['name']; ?>"}}selected="selected"{{/is}}><?php echo esc_html__( 'Facet', 'facetwp-conditional-logic' ) . ': ' . $facet['label']; ?></option>
							<?php } ?>
						</optgroup>
						<optgroup label="<?php esc_html_e( 'Custom', 'facetwp-conditional-logic' ); ?>">							
							<option value="_custom" {{#is thing value="_custom"}}selected="selected"{{/is}}><?php echo esc_html__( 'Selector', 'facetwp-conditional-logic' ); ?></option>
						</optgroup>

					</select>
					{{#is thing value="_custom"}}
					<button type="button" class="button button-small"
						data-title="<?php echo esc_attr( 'Custom Selectors' ); ?>"
						data-height="350"
						data-width="350"

						
						data-modal="{{_node_point}}"
						data-template="selectors"
						data-focus="true"
						data-buttons="save"
						data-footer="conduitModalFooter"
						style="margin: 1px; display: inline-block; height: 27px; padding: 4px;"
					><span class="dashicons dashicons-editor-code"></span></button>
					{{/is}}	
					<input style="display:none; width: 124px;{{#is thing not="_custom"}}display:none;{{/is}}" placeholder="<?php esc_html_e( 'Custom Selector', 'facetwp-conditional-logic' ); ?>" type="text" name="{{:name}}[selector]" value="{{json selector}}">
					
				</td>
				
			</tr>
		</table>
	</div>
