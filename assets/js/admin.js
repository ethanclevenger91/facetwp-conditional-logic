var FWPCL = FWPCL || {};


(function($) {


    $(function() {
        FWPCL.load();
        hide_x();

        // Topnav
        $(document).on('click', '.facetwp-tab', function() {
            var tab = $(this).attr('rel');
            $('.facetwp-tab').removeClass('active');
            $(this).addClass('active');
            $('.facetwp-region').removeClass('active');
            $('.facetwp-region-' + tab).addClass('active');

            // Populate the export code
            if ('settings' == tab) {
                var code = JSON.stringify(FWPCL.parse_data());
                $('.export-code').val(code);
            }
        });

        $('.export-code').on('focus', function() {
            $(this).select();
        });

        // Trigger click
        $('.facetwp-header-nav a:first').click();
    });


    function hide_x() {

        $('.ruleset').each(function() {
            var $this = $(this);

            if (1 < $this.find('.action').length) {
                $this.find('.action-drop').removeClass('hidden');
            }
            else {
                $this.find('.action-drop').addClass('hidden');
            }
        });
    }


    FWPCL.load = function() {
        $.each(FWPCL.rules, function(index, ruleset) {
            $('.add-ruleset').click();

            $.each(ruleset.actions, function(index, action) {
                if (0 < index) {
                    $('.facetwp-region-rulesets .action-and:last').click();
                }

                var $last = $('.facetwp-region-rulesets .action:last');
                $last.find('.action-toggle').val(action.toggle);
                $last.find('.action-object').val(action.object);
            });

            $.each(ruleset.conditions, function(index, cond_or) {
                if (0 < index) {
                    $('.facetwp-region-rulesets .condition-or:last').click();
                }

                $.each(cond_or, function(index, cond_and) {
                    if (0 < index) {
                        $('.facetwp-region-rulesets .condition-and:last').click();
                    }

                    var $last = $('.facetwp-region-rulesets .condition:last');
                    $last.find('.condition-object').val(cond_and.object);
                    $last.find('.condition-compare').val(cond_and.compare);
                    $last.find('.condition-value').val(cond_and.value);
                });
            });
        });
    }


    FWPCL.parse_data = function() {
        var rules = [];

        $('.facetwp-region-rulesets .ruleset').each(function(rule_num) {
            rules[rule_num] = {
                'label': '',
                'event': '',
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
                    'object': $(this).find('.action-object').val(),
                    'selector': ''
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


    $(document).on('click', '.add-ruleset', function() {
        var $clone = $('.clone').clone();
        var $rule = $clone.find('.clone-ruleset');

        var $group = $clone.find('.clone-condition-group');
        var $condition = $clone.find('.clone-condition');
        var $action = $clone.find('.clone-action');

        $group.find('.condition-wrap').html($condition.html());
        $rule.find('.left-side').html($group.html());
        $rule.find('.right-side').html($action.html());
        $('.facetwp-region-rulesets .facetwp-content-wrap').append($rule.html());

        hide_x();
    });


    $(document).on('change', '.condition-object', function() {
        var $wrap = $(this).closest('.condition');
        var val = $(this).val();

        $wrap.find('.condition-value').show();
        $wrap.find('.condition-compare').show();
        var is_template = ( 'template-' == val.substr(0, 9));
        if ('pageload' == val || 'refresh' == val || 'facets-empty' == val || 'facets-not-empty' == val || is_template) {
            $wrap.find('.condition-compare').hide();
            $wrap.find('.condition-value').hide();
        }

        hide_x();
    });


    $(document).on('click', '.condition-and', function() {
        var html = $('.clone-condition').html();
        $(this).closest('.condition-wrap').append(html);

        hide_x();
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


    $(document).on('click', '.condition-drop', function() {
        var group_count = $(this).closest('.left-side').find('.group-wrap').length;
        var count = $(this).closest('.condition-wrap').find('.condition').length;
        /*
        if (1 == group_count && 1 == count) {
            $(this).closest('.flexbox').remove(); // remove ruleset
        }
        else */if (1 == count) {
            $(this).closest('.group-wrap').remove(); // remove group
        }
        else {
            $(this).closest('.condition').remove(); // remove condition
        }
    });


    $(document).on('click', '.action-and', function() {
        var html = $('.clone-action').html();
        $(this).closest('.right-side').append(html);

        hide_x();
    });


    $(document).on('click', '.action-drop', function() {
        $(this).closest('.action').remove();
        hide_x();
    });

})(jQuery);
