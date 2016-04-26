(function($) {

    var evaluate_condition = function( rule ){

        if( !rule.compare || !rule.field || !FWP.facets[ rule.field ] ){ return false; }

        var is_valid = false;

        switch( rule.compare ) {
            case 'is':
            if(FWP.facets[ rule.field ].length){
                if(FWP.facets[ rule.field ].indexOf(rule.value.toString()) >= 0){
                    is_valid = true;
                }
            }
            break;
            case 'isnot':
            if(FWP.facets[ rule.field ].length){
                if(FWP.facets[ rule.field ].indexOf(rule.value) < 0){
                    is_valid = true;
                }
            }
            break;
            case '>':
            case 'greater':
            if(FWP.facets[ rule.field ].length){
                is_valid = parseFloat( FWP.facets[ rule.field ].reduce(function(a, b) {return a + b;}) ) > parseFloat( rule.value );
            }
            break;
            case '<':
            case 'smaller':
            if(FWP.facets[ rule.field ].length){
                is_valid = parseFloat( FWP.facets[ rule.field ].reduce(function(a, b) {return a + b;}) ) < parseFloat( rule.value );
            }
            break;
            case 'startswith':
            for( var i = 0; i<FWP.facets[ rule.field ].length; i++){
                if( FWP.facets[ rule.field ][i].toLowerCase().substr(0, rule.value.toLowerCase().length ) === rule.value.toLowerCase()){
                    is_valid = true;
                }
            }
            break;
            case 'endswith':
            for( var i = 0; i<FWP.facets[ rule.field ].length; i++){
                if( FWP.facets[ rule.field ][i].toLowerCase().substr(FWP.facets[ rule.field ][i].toLowerCase().length - rule.value.toLowerCase().length ) === rule.value.toLowerCase()){
                    is_valid = true;
                }
            }
            break;
            case 'contains':
            for( var i = 0; i<FWP.facets[ rule.field ].length; i++){
                if( FWP.facets[ rule.field ][i].toLowerCase().indexOf( rule.value ) >= 0 ){
                    is_valid = true;
                }
            }
            break;
        }
        return is_valid;
    }

    var get_opposite = function( value ){
        if( value === 'show' ){
            return 'hide'
        }else if( value === 'hide' ){
            return 'show';
        }
    }

    var do_action = function( action, type ){

        var item;
        if( action.thing === 'all_facets' ){
            item = $('.facetwp-facet');
        }else if( action.thing === 'template' ){
            item = $('.facetwp-template');
        }else if( action.thing === '_custom' ){
            item = $( action.selector );
        }else{
            item = $('.facetwp-facet-' + action.thing );
        }
        if( ! item.length ){
            return;
        }
        switch( type ){
            case 'hide':
                item.hide();
            break;
            case 'show':
                item.show();
            break;
        }
        item.addClass('fwpcl-applied-logic');
    }

    $(document).on('facetwp-loaded', function() {

        $('.fwpcl-applied-logic').removeClass('fwpcl-applied-logic').show();
        // each set
        for( var set in FWPCL.ruleset ){
            // each condition
            if( !FWPCL.ruleset[ set ][ 'condition'] || !FWPCL.ruleset[ set ][ 'action'] ){
                continue;
            }
            // found a condition and action
            var result = [];
            for( var condition in FWPCL.ruleset[ set ][ 'condition'] ){
                var this_result = evaluate_condition( FWPCL.ruleset[ set ][ 'condition'][ condition ] );                
                if( FWPCL.ruleset[ set ][ 'condition'][ condition ].or ){
                    for( var or in FWPCL.ruleset[ set ][ 'condition'][ condition ].or ){
                        var this_or_result = evaluate_condition( FWPCL.ruleset[ set ][ 'condition'][ condition ].or[ or ] );
                        if( true === this_or_result ){
                            this_result = true;
                            break;
                        }
                    }
                }
                result.push( this_result );
            }
            // yup- do the actions
            for( var action in FWPCL.ruleset[ set ][ 'action'] ){
                var type = FWPCL.ruleset[ set ][ 'action'][ action ].do;
                if( result.indexOf( false ) > -1 ){
                    type = get_opposite( type );
                }
                do_action( FWPCL.ruleset[ set ][ 'action'][ action ], type );
            }
        }
        
    });
})(jQuery);