<?php
/**
 * Export/Import Panel template
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
			<td><?php esc_html_e( 'Export / Import', 'facetwp-conditional-logic' ); ?></td>
			<td class="uix-control-bar-action left"><button type="button" class="button"><?php esc_html_e( 'Process Import', 'facetwp-conditional-logic' ); ?></button></td>
		</tr>
	</table>
	<div class="uix-control-box-content">
		<input id="export-string" readonly="reasonly" type="text" style="width: 100%;" value="{{json this._tab.filters.ruleset true}}">
		<p class="description"><?php esc_html_e( 'Copy the above code for importing.', 'facetwp-conditional-logic' ); ?></p><br>
		<textarea id="import-string" style="width: 100%;height: 300px;" placeholder="<?php esc_html_e( 'Past import data here and click process import.', 'facetwp-conditional-logic' ); ?>"></textarea>
	</div>
	<table class="uix-control-bar" cellspacing="0" cellpadding="0">
		<tr>
			<td class="uix-control-bar-action left"><button id="process-import" type="button" class="button"><?php esc_html_e( 'Process Import', 'facetwp-conditional-logic' ); ?></button></td>
		</tr>
	</table>
</div>
{{#script}}
//<script>
jQuery( '#export-string' ).on('focus', function(){
	jQuery(this).select();
});
jQuery( '#process-import' ).on('focus', function(){
	var string_data = jQuery( '#import-string' ).val(),
		data;
	try {
		data = JSON.parse( string_data );
		for( var test in data ){
			if( !data[ test ]._id || !data[ test ]._node_point ){
				alert( 'Error: empty import')
			}else{
				if( !data[ test ].condition || !data[ test ].condition ){
					alert( 'Error: no condtions or actions found');
				}else{
					// yay
					if( confirm( 'This wil overwrite you current rulesets. Continue?' ) ){
						conduitApp.filters.data.ruleset = data;
						conduitBuildUI( 'filters' );
						jQuery( '[data-tab="filters"]' ).trigger( 'click' );
						conduitSaveObject();
					}
					break;
				}
			}
		}
	}
	catch(err) {
		alert(' invalid data');
	}
});

{{/script}}