(function($) {

    var evaluate_condition = function(cond) {
        var is_valid = false;
        var compare_field;

        if ('facets-empty' == cond.object) {
            return FWP.build_query_string().length < 1;
        }
        else if ('facets-not-empty' == cond.object) {
            return FWP.build_query_string().length > 0;
        }
        else if ('uri' == cond.object) {
            compare_field = FWP_HTTP.uri;
        }
        else if ('total-rows' == cond.object) {
            if ('undefined' === typeof FWP.settings.pager) {
                return false;
            }
            compare_field = FWP.settings.pager.total_rows;
        }
        else if ('facet-' == cond.object.substr(0, 6)) {
            var facet_name = cond.object.substr(6);
            if ('undefined' === typeof FWP.facets[facet_name]) {
                return false;
            }
            compare_field = FWP.facets[facet_name];
        }
        else if ('template-' == cond.object.substr(0, 9)) {
            compare_field = FWP.template;
            cond.value = cond.object.substr(9);
        }

        // operators
        if ('is' == cond.compare) {
            if (is_intersect(cond.value, compare_field)) {
                is_valid = true;
            }
        }
        else if ('not' == cond.compare) {
            if (! is_intersect(cond.value, compare_field)) {
                is_valid = true;
            }
        }

        return is_valid;
    }

    var is_intersect = function(arr1, arr2) {

        // force arrays
        arr1 = [].concat(arr1);
        arr2 = [].concat(arr2);

        // exact match
        if (arr1.toString() === arr2.toString()) {
            return true;
        }

        var result = arr1.filter(function(n) {
            return arr2.indexOf(n) != -1;
        });
        return result.length > 0;
    }

    var do_action = function(action, is_valid) {
        var item;
        var is_custom = false;
        var animation = 'hide';

        if ('template' == action.object) {
            item = $('.facetwp-template');
        }
        else if ('facets' == action.object) {
            item = $('.facetwp-facet');
        }
        else if ('facet-' == action.object.substr(0, 6)) {
            item = $('.facetwp-facet-' + action.object.substr(6));
        }
        else if ('custom' == action.object) {
            is_custom = true;
            var lines = action.selector.split("\n");
            var selectors = [];
            for (var i = 0; i < lines.length; i++){
                var selector = lines[i].replace(/^\s+|\s+$/gm, '');
                if (selector.length) {
                    selectors.push(selector);
                }
            }
            item = selectors;
        }

        if (item.length < 1) {
            return;
        }

        if (('show' == action.toggle && is_valid) || ('hide' == action.toggle && ! is_valid)) {
            animation = 'show';
        }

        // toggle
        if (is_custom) {
            $.each(item, function(idx, selector) {
                eval( selector + '.' + animation + '()' );
            });
        }
        else {
            ('show' == animation) ? item.show() : item.hide();
        }
    }

    $(document).on('facetwp-refresh facetwp-loaded', function(e) {

        // foreach ruleset
        $.each(FWPCL, function(idx, ruleset) {

            if ('refresh-loaded' != ruleset.on && e.type != 'facetwp-' + ruleset.on) {
                return; // skip iteration
            }

            // if no conditions, set to TRUE
            var this_result = (ruleset.conditions.length < 1);
            var result = [];

            // foreach condition group
            $.each(ruleset.conditions, function(idx_1, cond_group) {
                this_result = false;

                // foreach "OR" condition
                $.each(cond_group, function(idx_2, cond_or) {
                    if (evaluate_condition(cond_or)) {
                        this_result = true;
                        return false; // exit loop
                    }
                });

                result.push(this_result);
            });

            // make sure no conditions are false
            var is_valid = (result.indexOf(false) < 0);

            // apply actions
            $.each(ruleset.actions, function(idx_1, action) {
                do_action(action, is_valid);
            });
        });
    });
})(jQuery);