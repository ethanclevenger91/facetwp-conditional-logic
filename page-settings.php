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
        <div class="flexbox menubar">
            <div class="left-side">
                <a class="button add-ruleset">Add Ruleset</a>
            </div>
            <div class="right-side">
                <a class="button-primary facetwp-save">Save Changes</a>
            </div>
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
            <div class="flexbox ruleset">
                <div class="left-side"></div>
                <div class="right-side"></div>
            </div>
        </div>

        <div class="clone-condition-group">
            <div class="group-wrap">
                <div class="condition-wrap"></div>
                <div style="font-weight:bold">or</div>
            </div>
            <button class="button condition-or">Add Condition</button>
        </div>

        <div class="clone-condition">
            <div class="condition">
                <span class="condition-drop btn-drop"></span>
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
                <button class="button condition-and">and</button>
            </div>
        </div>

        <div class="clone-action">
            <div class="action">
                <span class="action-drop btn-drop"></span>
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
                <input type="button" class="button action-and" value="and" />
            </div>
        </div>
    </div>

    <!-- [End] Clone HTML -->

</div>
