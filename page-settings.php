<script src="<?php echo FWPCL_URL; ?>/assets/js/admin.js?ver=<?php echo FWPCL_VERSION; ?>"></script>
<link href="<?php echo FACETWP_URL; ?>/assets/css/admin.css?ver=<?php echo FACETWP_VERSION; ?>" rel="stylesheet">
<link href="<?php echo FWPCL_URL; ?>/assets/css/admin.css?ver=<?php echo FWPCL_VERSION; ?>" rel="stylesheet">
<script>
FWPCL.rules = <?php echo json_encode( $this->rules ); ?>;
</script>

<div class="facetwp-header">
    <span class="facetwp-logo" title="FacetWP">&nbsp;</span>
    <span class="facetwp-header-nav">
        <a class="facetwp-tab" rel="rulesets"><?php _e( 'Rulesets', 'fwp' ); ?></a>
        <a class="facetwp-tab" rel="settings"><?php _e( 'Settings', 'fwp' ); ?></a>
    </span>
</div>

<div class="wrap">
    <div class="facetwp-response"></div>

    <div class="facetwp-region facetwp-region-rulesets">
        <div class="flexbox">
            <a class="button add-ruleset">Add Ruleset</a>
            <a class="button-primary facetwp-save" style="margin-left:10px">Save Changes</a>
            <span class="fwpcl-response dashicons"></span>
        </div>

        <div class="facetwp-content-wrap"></div>
    </div>

    <div class="facetwp-region facetwp-region-settings">
        <div class="facetwp-content-wrap">
            <p class="description">To export, copy the code below.</p>
            <input type="text" class="export-code" readonly="readonly" />
            <p class="description" style="margin-top:20px">To import, paste code into the field below.</p>
            <textarea class="import-code"></textarea>
            <p class="description" style="color:red"><strong>NOTE:</strong> importing will replace any existing rulesets.</p>
            <input type="button" class="button" value="Process Import" />
        </div>
    </div>

    <!-- [Begin] Clone HTML -->

    <div class="clone hidden">
        <div class="clone-ruleset">
            <table class="ruleset" style="width:100%">
                <tr>
                    <td colspan="2">
                        <div class="header-bar">
                            <span class="dashicons dashicons-menu"></span>
                            <span class="dashicons dashicons-edit"></span>
                            <span class="title">The Title</span>
                            <span class="dashicons dashicons-trash"></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="conditions-col" style="width:60%">
                        <div class="td-label">Conditions</div>
                        <div class="condition-wrap"></div>
                        <button class="button condition-and">Add Condition</button>
                    </td>
                    <td class="actions-col" style="width:40%">
                        <div class="td-label">Actions</div>
                        <div class="action-wrap"></div>
                        <button class="button action-and">Add Action</button>
                    </td>
                </tr>
            </table>
        </div>

        <div class="clone-condition">
            <table class="condition">
                <tr>
                    <td class="drop">
                        <span class="dashicons dashicons-no-alt condition-drop"></span>
                    </td>
                    <td class="type">IF</td>
                    <td class="logic">
                        <select class="condition-object">
                            <optgroup label="Basic">
                                <option value="uri">Page URI</option>
                                <option value="total-rows">Result count</option>
                                <option value="facets-empty">Facets empty</option>
                                <option value="facets-not-empty">Facets not empty</option>
                            </optgroup>
                            <optgroup label="Facet Value">
<?php foreach ( $this->facets as $facet ) : ?>
                                <option value="facet-<?php echo $facet['name']; ?>">Facet: <?php echo $facet['label']; ?></option>
<?php endforeach; ?>
                            </optgroup>
                            <optgroup label="Template">
<?php foreach ( $this->templates as $template ) : ?>
                                <option value="template-<?php echo $template['name']; ?>">Template: <?php echo $template['label']; ?></option>
<?php endforeach; ?>
                            </optgroup>
                        </select>
                        <select class="condition-compare">
                            <option value="is">is</option>
                            <option value="not">is not</option>
                        </select>
                        <input type="text" class="condition-value" placeholder="enter values" title="comma-separate multiple values"></input>
                    </td>
                    <td class="btn">
                        <button class="button condition-or">OR</button>
                    </td>
                </tr>
            </table>
        </div>

        <div class="clone-action">
            <table class="action">
                <tr>
                    <td class="drop">
                        <span class="dashicons dashicons-no-alt action-drop"></span>
                    </td>
                    <td class="type">THEN</td>
                    <td class="logic">
                        <select class="action-toggle">
                            <option value="show">Show</option>
                            <option value="hide">Hide</option>
                        </select>
                        <select class="action-object">
                            <option value="template">Template</option>
                            <option value="facets">All Facets</option>
                            <optgroup label="Facets">
<?php foreach ( $this->facets as $facet ) : ?>
                                <option value="facet-<?php echo $facet['name']; ?>">Facet: <?php echo $facet['label']; ?></option>
<?php endforeach; ?>
                            </optgroup>
                            <optgroup label="Custom">
                                <option value="selector">Selector</option>
                            </optgroup>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- [End] Clone HTML -->

</div>
