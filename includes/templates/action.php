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
				<td class="uix-control-bar-action left" style="text-align: center; width: 61px; background: rgb(239, 239, 239) none repeat scroll 0% 0%; text-transform: uppercase; font-weight: bold; color: rgb(151, 151, 151);"><?php _e('Then', 'facetwp-conditional-logic'); ?></td>
				<td>
					{{:node_point}}
					<select class="condition-field-select" name="{{:name}}[do]">
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
						<optgroup label="<?php esc_html_e( 'Facet Value', 'facetwp-conditional-logic' ); ?>">
							<?php foreach( $facets as $facet ){ ?>
								<option value="<?php echo $facet['name']; ?>" {{#is thing value="<?php echo $facet['name']; ?>"}}selected="selected"{{/is}}><?php echo esc_html__( 'Facet', 'facetwp-conditional-logic' ) . ': ' . $facet['label']; ?></option>
							<?php } ?>
						</optgroup>

					</select>
				</td>
			</tr>
		</table>
	</div>