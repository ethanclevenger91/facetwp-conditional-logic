<script>
(function($) {
    $(document).on('click', '.condition-and', function() {
        var $wrap = $(this).closest('.condition-wrap');
        $wrap.after($wrap.clone());
    });

    $(document).on('click', '.condition-drop', function() {
        $(this).closest('.condition-wrap').remove();
    });

    $(document).on('click', '.condition-or', function() {

    });

    $(document).on('click', '.action-and', function() {
        var $wrap = $(this).closest('.action-wrap');
        $wrap.after($wrap.clone());
    });

    $(document).on('click', '.action-drop', function() {
        $(this).closest('.action-wrap').remove();
    });

    $(document).on('change', '.condition-object', function() {
        var val = $(this).val();

    });
})(jQuery);
</script>

<style>
.condition-wrap .condition-drop:first-child { display: none; }
.action-wrap .action-drop:first-child { display: none; }
</style>


<div class="wrap">
    <h1>Conditional Logic <a class="page-title-action">Add Rule</a></h1>

    <table style="width:100%">
        <tr>
            <td>If...</td>
            <td>Then...</td>
        </tr>
        <tr>
            <td valign="top">
                <div class="condition-wrap">
                    <select class="condition-object">
                        <option value="pageload">Pageload</option>
                        <option value="facets-empty">Facets are empty</option>
                        <option value="facets-not-empty">Facets are not empty</option>
                        <optgroup label="Facet Value">
                            <option value="facet-1">Facet 1</option>
                            <option value="facet-2">Facet 2</option>
                            <option value="facet-3">Facet 3</option>
                        </optgroup>
                        <optgroup label="Template Name">
                            <option value="template-1">Template 1</option>
                            <option value="template-2">Template 2</option>
                            <option value="template-3">Template 3</option>
                        </optgroup>
                        <option value="uri">Page URI</option>
                    </select>
                    <select class="condition-operator">
                        <option value="is">is</option>
                        <option value="not">is not</option>
                    </select>
                    <button class="condition-drop">x</button>
                    <button class="condition-and">and</button>
                </div>
                <div>Or...</div>
                <button class="condition-or">add subset</button>
            </td>
            <td valign="top">
                <div class="action-wrap">
                    <select class="action-toggle">
                        <option value="show">Show</option>
                        <option value="hide">Hide</option>
                    </select>
                    <select class="action-object">
                        <option value="template">Template</option>
                        <option value="facets">All Facets</option>
                        <option value="facet-1">facet 1</option>
                        <option value="facet-2">facet 2</option>
                        <option value="facet-3">facet 3</option>
                    </select>
                    <button class="action-drop">x</button>
                    <button class="action-and">and</button>
                </div>
            </td>
        </tr>
    </table>

</div>
