/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
/*browser:true*/
/*global define*/
define(
    [
        'jquery',
        'Magento_Checkout/js/view/payment/default',
        'Mobipaid_Mobipaid/js/action/set-payment-method',
        'Magento_Checkout/js/model/quote'
    ],
    function ($, Component, setPaymentMethodAction, quote) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Mobipaid_Mobipaid/payment/mobipaid-method'
            },
            /** Redirect to Payment Form */
            placeOrderAction: function () {
                this.selectPaymentMethod(); // save selected payment method in Quote
                setPaymentMethodAction(
                    this.messageContainer,
                    {
                        method: this.getCode()
                    }
                );
                return false;
            },
            getLogos: function () {
                return window.checkoutConfig.payment.mobipaid.logos[this.getCode()];
            },
            initMobipaid: function() {
                var billingAddress = quote.billingAddress();

                $('[data-key]').hide();
                
                $("[data-role=opc-continue]").click(function() {
                    location.assign(window.location.href.split('#')[0]+'#payment');
                    location.reload();
                });
                return false;
            }
        });
    }
);



