define([
    'jquery',
    'jquery/ui',
    'jquery/validate',
    'mage/translate'
], function($){
    'use strict';
    return function() {
        $.validator.addMethod(
            "aureatelabsvalidationrule",
            function(value, element) {
                //Perform your operation here and return the result true/false.
                var thisRegex = /(84|0[3|5|7|8|9])+([0-9]{8})\b/;
                return !!value.match(thisRegex);
            },
            $.mage.__("Incorrect number phone format")
        );
    }
});
