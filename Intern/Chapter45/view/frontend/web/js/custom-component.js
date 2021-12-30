define(['Magento_Ui/js/modal/alert', 'Magento_Ui/js/modal/modal' , 'jquery', 'uiComponent', 'ko'], function (alert, modal, $, Component, ko) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Intern_Chapter45/knockout-test'
            },
            firstbutton: function () {
                alert({
                    title: $.mage.__('Hello World'),
                    content: $.mage.__('Hello World'),
                    actions: {
                        always: function(){}
                    }
                });
            },
            secondbutton: function () {
                modal({
                    type: 'popup',
                    responsive: true,
                    innerScroll: true,
                    title: $.mage.__('Login Modal'),
                }, $('#popup-modal'));
                $('#popup-modal').modal('openModal');
            }
        });
    }
);
