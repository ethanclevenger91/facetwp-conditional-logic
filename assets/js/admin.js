var FWPCL = FWPCL || {};


(function($) {


    $(function() {
        FWPCL.load();
    });


    function init_scripts() {
        /*
        $('.left-side .condition-object:not(.ready)').fSelect({
            placeholder: 'Select a condition'
        }).addClass('ready');

        $('.right-side .action-object:not(.ready)').fSelect({
            placeholder: 'Select actions'
        }).addClass('ready');
        */
    }


    function hide_x() {
        if (1 < $('.right-side .action').length) {
            $('.action-drop').removeClass('hidden');
        }
        else {
            $('.action-drop').addClass('hidden');
        }
    }


    FWPCL.load = function() {
        $.each(FWPCL.rules, function(index, ruleset) {
            $('.add-rule').click();

            $.each(ruleset.actions, function(index, action) {
                if (0 < index) {
                    $('.facetwp-region .action-and:last').click();
                }

                var $last = $('.facetwp-region .action:last');
                $last.find('.action-toggle').val(action.toggle);
                $last.find('.action-object').val(action.object);
            });

            $.each(ruleset.conditions, function(index, cond_or) {
                if (0 < index) {
                    $('.facetwp-region .condition-or:last').click();
                }

                $.each(cond_or, function(index, cond_and) {
                    if (0 < index) {
                        $('.facetwp-region .condition-and:last').click();
                    }

                    var $last = $('.facetwp-region .condition:last');
                    $last.find('.condition-object').val(cond_and.object);
                    $last.find('.condition-compare').val(cond_and.compare);
                    $last.find('.condition-value').val(cond_and.value);
                });
            });
        });
    }


    FWPCL.parse_data = function() {
        var rules = [];

        $('.facetwp-region .ruleset').each(function(rule_num) {
            rules[rule_num] = {
                'conditions': [],
                'actions': []
            };

            // Get conditions
            $(this).find('.group-wrap').each(function(group_num) {
                var conditions = [];

                $(this).find('.condition').each(function() {
                    var condition = {
                        'object': $(this).find('.condition-object').val(),
                        'compare': $(this).find('.condition-compare').val(),
                        'value': $(this).find('.condition-value').val()
                    };
                    conditions.push(condition);
                });

                rules[rule_num]['conditions'][group_num] = conditions;
            });

            // Get actions
            $(this).find('.action').each(function() {
                var action = {
                    'toggle': $(this).find('.action-toggle').val(),
                    'object': $(this).find('.action-object').val()
                };

                rules[rule_num]['actions'].push(action);
            });
        });

        return rules;
    }


    $(document).on('click', '.facetwp-save', function() {
        $('.facetwp-response').html('Saving...');
        $('.facetwp-response').show();

        var data = FWPCL.parse_data();

        $.post(ajaxurl, {
            'action': 'fwpcl_save',
            'data': JSON.stringify(data)
        }, function(response) {
            $('.facetwp-response').html(response);
        });
    });


    $(document).on('click', '.add-rule', function() {
        var $clone = $('.clone').clone();
        var $rule = $clone.find('.clone-rule');

        var $group = $clone.find('.clone-condition-group');
        var $condition = $clone.find('.clone-condition');
        var $action = $clone.find('.clone-action');

        $group.find('.condition-wrap').html($condition.html());
        $rule.find('.left-side').html($group.html());
        $rule.find('.right-side').html($action.html());
        $('.facetwp-content-wrap').append($rule.html());

        init_scripts();
        hide_x();
    });


    $(document).on('click', '.condition-and', function() {
        var html = $('.clone-condition').html();
        $(this).closest('.condition-wrap').append(html);

        init_scripts();
    });


    $(document).on('click', '.condition-drop', function() {
        var group_count = $(this).closest('.left-side').find('.group-wrap').length;
        var count = $(this).closest('.condition-wrap').find('.condition').length;
        if (1 == group_count && 1 == count) {
            $(this).closest('.flexbox').remove(); // remove ruleset
        }
        else if (1 == count) {
            $(this).closest('.group-wrap').remove(); // remove group
        }
        else {
            $(this).closest('.condition').remove(); // remove condition
        }
    });


    $(document).on('click', '.condition-or', function() {
        var $rule = $(this).closest('.left-side');
        var $clone = $('.clone').clone();
        var $group = $clone.find('.clone-condition-group');
        var $condition = $clone.find('.clone-condition');

        $group.find('.condition-wrap').html($condition.html());
        $rule.find('.condition-or').remove();
        $rule.append($group.html());
        $rule.find('.condition-object').trigger('change');
    });


    $(document).on('click', '.action-and', function() {
        var html = $('.clone-action').html();
        $(this).closest('.right-side').append(html);

        init_scripts();
        hide_x();
    });


    $(document).on('click', '.action-drop', function() {
        $(this).closest('.action').remove();

        hide_x();
    });


    $(document).on('change', '.condition-object', function() {
        var $wrap = $(this).closest('.condition');
        var val = $(this).val();

        $wrap.find('.condition-value').show();
        $wrap.find('.condition-compare').show();
        var is_template = ( 'template-' == val.substr(0, 9));
        if ('pageload' == val || 'facets-empty' == val || 'facets-not-empty' == val || is_template) {
            $wrap.find('.condition-compare').hide();
            $wrap.find('.condition-value').hide();
        }
    });
})(jQuery);