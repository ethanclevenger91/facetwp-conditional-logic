var FWPCL = FWPCL || {};


(function($) {


    $(function() {
        FWPCL.load();

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


    FWPCL.load = function() {
        $.each(FWPCL.rules, function(index, ruleset) {
            $('.add-ruleset').click();

            $.each(ruleset.actions, function(index, action) {
                $('.facetwp-region-rulesets .action-and:last').click();

                var $last = $('.facetwp-region-rulesets .action:last');
                $last.find('.action-toggle').val(action.toggle);
                $last.find('.action-object').val(action.object);
            });

            $.each(ruleset.conditions, function(index, cond_group) {
                $('.facetwp-region-rulesets .condition-and:last').click();

                $.each(cond_group, function(index, cond) {

                    // Skip first item ("AND")
                    if (0 < index) {
                        $('.facetwp-region-rulesets .condition-or:last').click();
                    }

                    var $last = $('.facetwp-region-rulesets .condition:last');
                    $last.find('.condition-object').val(cond.object);
                    $last.find('.condition-compare').val(cond.compare);
                    $last.find('.condition-value').val(cond.value);
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

            // Get conditions (and preserve groups)
            $(this).find('.condition-group').each(function(group_num) {
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
        $('.fwpcl-response').removeClass('dashicons-yes');
        $('.fwpcl-response').addClass('dashicons-image-rotate')
        $('.fwpcl-response').show();

        var data = FWPCL.parse_data();

        $.post(ajaxurl, {
            'action': 'fwpcl_save',
            'data': JSON.stringify(data)
        }, function(response) {
            $('.fwpcl-response').removeClass('dashicons-image-rotate');
            $('.fwpcl-response').addClass('dashicons-yes');
            setTimeout(function() {
                $('.fwpcl-response').stop().fadeOut();
            }, 4000);
        });
    });


    $(document).on('click', '.add-ruleset', function() {
        var $clone = $('.clone').clone();
        var $rule = $clone.find('.clone-ruleset');
        $('.facetwp-region-rulesets .facetwp-content-wrap').append($rule.html());
    });


    $(document).on('change', '.condition-object', function() {
        var $wrap = $(this).closest('.condition');
        var val = $(this).val();

        $wrap.find('.condition-value').show();
        $wrap.find('.condition-compare').show();
        var is_template = ( 'template-' == val.substr(0, 9));
        if ('facets-empty' == val || 'facets-not-empty' == val || is_template) {
            $wrap.find('.condition-compare').hide();
            $wrap.find('.condition-value').hide();
        }
    });


    $(document).on('click', '.condition-or', function() {
        var html = $('.clone-condition').html();
        $(this).closest('.condition-group').append(html);
    });


    $(document).on('click', '.condition-and', function() {
        var $clone = $('.clone').clone();
        var $condition = $clone.find('.clone-condition');
        var $ruleset = $(this).closest('.conditions-col');

        $ruleset.find('.condition-wrap').append('<div class="condition-group" />');
        var $group = $('.condition-group:last');
        $group.append($condition.html());
        $group.find('.condition-object').trigger('change');
    });


    $(document).on('click', '.condition-drop', function() {
        var count = $(this).closest('.condition-group').find('.condition').length;

        if (1 == count) {
            $(this).closest('.condition-group').remove(); // remove group
        }
        else {
            $(this).closest('.condition').remove(); // remove condition
        }
    });


    $(document).on('click', '.action-and', function() {
        var html = $('.clone-action').html();
        $(this).siblings('.action-wrap').append(html);
    });


    $(document).on('click', '.action-drop', function() {
        $(this).closest('.action').remove();
    });

})(jQuery);
