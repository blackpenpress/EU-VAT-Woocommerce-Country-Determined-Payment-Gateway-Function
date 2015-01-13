<?php

// Function for woocommerce to set the payment gateway based on
// the billing address country. So a service like paddle.com which
// handles VAT can be used for EU countries and a cheaper gateway can be used everywhere else.
// Tom Blaker blackpenpress.co.uk


function disable_gateway_by_country( $available_gateways ) {


	//list of EU country codes, remove your country of origin if you do not need to pay VAT there
	$CCArray = array(
		"AT",
		"BE",
		"BG",
		"HR",
		"CY",
		"CZ",
		"DK",
		"EE",
		"FI",
		"FR",
		"GF",
		"PF",
		"TF",
		"DE",
		"GR",
		"HU",
		"IE",
		"IT",
		"LV",
		"LT",
		"LU",
		"MT",
		"NL",
		"PL",
		"PT",
		"RO",
		"SK",
		"SI",
		"ES",
		"SE",
		"UK"
		);

global $woocommerce;

//set $available_gateways to non EU woocommerce gateway, paypal in this case
if ( isset( $available_gateways['paypal'] ) && in_array($woocommerce->customer->get_country(),$CCArray)) {
    unset(  $available_gateways['paypal'] );
} 

//set $available_gateways to EU woocommerce gateway, paddle in this case
elseif (isset( $available_gateways['wcPaddlePaymentGateway'] )) {
    unset(  $available_gateways['wcPaddlePaymentGateway'] );
}
return $available_gateways;
}
add_filter( 'woocommerce_available_payment_gateways', 'disable_gateway_by_country' );
