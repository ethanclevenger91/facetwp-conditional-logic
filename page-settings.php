<script src="<?php echo FACETWP_URL; ?>/assets/js/fSelect/fSelect.js?ver=<?php echo FACETWP_VERSION; ?>"></script>
<script src="<?php echo FWPCL_URL; ?>/assets/js/admin.js?ver=<?php echo FWPCL_VERSION; ?>"></script>
<script>
FWPCL.rules = <?php echo $this->rules; ?>;
</script>
<link href="<?php echo FACETWP_URL; ?>/assets/js/fSelect/fSelect.css?ver=<?php echo FACETWP_VERSION; ?>" rel="stylesheet">
<link href="<?php echo FWPCL_URL; ?>/assets/css/admin.css?ver=<?php echo FWPCL_VERSION; ?>" rel="stylesheet">

<div class="wrap">
    <h1>Conditional Logic</h1>

    <div class="facetwp-response"></div>

    <div class="facetwp-region">
        <div class="flexbox menubar">
            <div class="left-side">
                <a class="button add-rule">Add Rule</a>
            </div>
            <div class="right-side">
                <a class="button-primary facetwp-save">Save Changes</a>
            </div>
        </div>
        <div class="facetwp-content-wrap">
            <div class="flexbox">
                <div class="left-side"><h3>If...</h3></div>
                <div class="right-side"><h3>Then...</h3></div>
            </div>
        </div>
    </div>

    <!-- [Begin] Clone HTML -->

    <div class="clone hidden">
        <div class="clone-rule">
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
            <button class="button condition-or">Add Rule Group</button>
        </div>

        <div class="clone-condition">
            <div class="condition">
                <select class="condition-object">
                    <optgroup label="Basic">
                        <option value="pageload">Pageload</option>
                        <option value="uri">Page URI</option>
                        <option value="facets-empty">Facets are empty</option>
                        <option value="facets-not-empty">Facets are not empty</option>
                    </optgroup>
                    <optgroup label="Facet Value">
<?php foreach ( $this->facets as $facet ) : ?>
                        <option value="facet-<?php echo $facet['name']; ?>"><?php echo $facet['label']; ?></option>
<?php endforeach; ?>
                    </optgroup>
                    <optgroup label="Template Name">
<?php foreach ( $this->templates as $template ) : ?>
                        <option value="template-<?php echo $template['name']; ?>"><?php echo $template['label']; ?></option>
<?php endforeach; ?>
                    </optgroup>
                </select>
                <select class="condition-compare">
                    <option value="is">is</option>
                    <option value="not">is not</option>
                </select>
                <textarea class="condition-value"></textarea>
                <button class="button condition-and">and</button>
                <span class="condition-drop btn-drop"></span>
            </div>
        </div>

        <div class="clone-action">
            <div class="action">
                <select class="action-toggle">
                    <option value="show">Show</option>
                    <option value="hide">Hide</option>
                </select>
                <select class="action-object" multiple="multiple">
                    <option value="template">Template</option>
                    <option value="facets">All Facets</option>
                    <optgroup label="Facets">
<?php foreach ( $this->facets as $facet ) : ?>
                        <option value="facet-<?php echo $facet['name']; ?>"><?php echo $facet['label']; ?></option>
<?php endforeach; ?>
                    </optgroup>
                </select>
                <button class="button action-and">and</button>
                <span class="action-drop btn-drop"></span>
            </div>
        </div>
    </div>

    <!-- [End] Clone HTML -->

</div>
