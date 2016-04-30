	<?php

	$basic = apply_filters( 'facetwp-conditional-logic-actions', array(
			"uri" => esc_html__( 'Page URI', 'facetwp-conditional-logic' ),
			"result-count" => esc_html__( 'Result Count', 'facetwp-conditional-logic' ),			
			"facets-empty" => esc_html__( 'Facets empty', 'facetwp-conditional-logic' ),
			"facets-not-empty" => esc_html__( 'Facets not empty', 'facetwp-conditional-logic' ),
		) );
	$facets = FWP()->helper->get_facets();
	$templates = FWP()->helper->get_templates();

	?>
	<div class="condition-row-line-{{_id}}">
		<table class="uix-control-bar" cellspacing="0" cellpadding="0">
			<tr>
				{{#is type value="or"}}
					<td class="uix-control-bar-action left" style="background: #f8f8f8;">&nbsp;</td>
				{{/is}}
				<td class="uix-control-bar-action left"><span class="dashicons dashicons-no-alt" data-remove-element=".condition-row-line-{{_id}}"></span></td>
				<td class="uix-control-bar-action left conditional-type-text">
					<span class="type-and"><?php _e('and', 'facetwp-conditional-logic'); ?></span>
					<span class="type-if"><?php _e('If', 'facetwp-conditional-logic'); ?></span>
					<span class="type-or"><?php _e('Or', 'facetwp-conditional-logic'); ?></span>
				</td>
				<td>
					{{:node_point}}
					<input type="hidden" name="{{:name}}[type]" value="{{type}}">
					<select class="condition-field-select" name="{{:name}}[field]" data-live-sync="true">
						<option></option>
						<optgroup label="<?php esc_html_e( 'Basic', 'facetwp-conditional-logic' ); ?>">
							<?php foreach( $basic as $key=>$value ){ ?>
								<option value="_basic_<?php echo $key; ?>" {{#is field value="_basic_<?php echo $key; ?>"}}selected="selected"{{/is}}><?php echo $value; ?></option>
							<?php } ?>
						</optgroup>
						<optgroup label="<?php esc_html_e( 'Facet Value', 'facetwp-conditional-logic' ); ?>">
							<?php foreach( $facets as $facet ){ ?>
								<option value="_facet_<?php echo $facet['name']; ?>" {{#is field value="_facet_<?php echo $facet['name']; ?>"}}selected="selected"{{/is}}><?php echo esc_html__( 'Facet', 'facetwp-conditional-logic' ) . ': ' . $facet['label']; ?></option>
							<?php } ?>
						</optgroup>
						<optgroup label="<?php esc_html_e( 'Template', 'facetwp-conditional-logic' ); ?>">
							<?php foreach( $templates as $template ){ ?>
								<option value="_template_<?php echo $template['name']; ?>" {{#is field value="_template_<?php echo $template['name']; ?>"}}selected="selected"{{/is}}><?php echo esc_html__( 'Template', 'facetwp-conditional-logic' ) . ': ' . $template['label']; ?></option>
							<?php } ?>
						</optgroup>

					</select>
					<select class="condition-field-compare" name="{{:name}}[compare]"

					{{#is field value="_basic_facets-empty"}}style="display:none;"{{/is}}
					{{#is field value="_basic_facets-not-empty"}}style="display:none;"{{/is}}
					<?php foreach( $templates as $template ){ ?>
					{{#is field value="_template_<?php echo $template['name']; ?>"}}style="display:none;"{{/is}}
					<?php } ?>
					>
						<option value="is" {{#is compare value="is"}}selected="selected"{{/is}}><?php esc_html_e( 'is', 'facetwp-conditional-logic' ); ?></option>
						<option value="isnot" {{#is compare value="isnot"}}selected="selected"{{/is}}><?php esc_html_e( 'is not', 'facetwp-conditional-logic' ); ?></option>
						<option value="greater" {{#is compare value="greater"}}selected="selected"{{/is}}><?php esc_html_e( 'greater than', 'facetwp-conditional-logic' ); ?></option>
						<option value="smaller" {{#is compare value="smaller"}}selected="selected"{{/is}}><?php esc_html_e( 'smaller than', 'facetwp-conditional-logic' ); ?></option>
						<option value="startswith" {{#is compare value="startswith"}}selected="selected"{{/is}}><?php esc_html_e( 'starts with', 'facetwp-conditional-logic' ); ?></option>
						<option value="endswith" {{#is compare value="endswith"}}selected="selected"{{/is}}><?php esc_html_e( 'ends with', 'facetwp-conditional-logic' ); ?></option>
						<option value="contains" {{#is compare value="contains"}}selected="selected"{{/is}}><?php esc_html_e( 'contains', 'facetwp-conditional-logic' ); ?></option>
					</select>
					<input class="condition-field-value"
					{{#is field value="_basic_facets-empty"}}style="display:none;"{{/is}}
					{{#is field value="_basic_facets-not-empty"}}style="display:none;"{{/is}}
					<?php foreach( $templates as $template ){ ?>
					{{#is field value="_template_<?php echo $template['name']; ?>"}}style="display:none;"{{/is}}
					<?php } ?>

					type="text" id="field_{{_id}}" name="{{:name}}[value]" value="{{value}}">
				</td>
				{{#is type value="and"}}
				<td class="uix-control-bar-action right"><button type="button" data-add-node="{{_node_point}}.or" data-template="conditional_row" data-node-default='{"type":"or"}' class="button"><?php esc_html_e( 'OR', 'facetwp-conditional-logic' ); ?></button></td>
				{{/is}}
			</tr>
		</table>
		<div class="inner-row" data-node-point="{{_node_point}}.or">
		{{#each or}}
			{{> conditional_row}}
		{{/each}}
		</div>
</div>