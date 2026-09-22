<?php
/**
 * Activation : réglages par défaut (arrondi au 0,05 le plus proche).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPS_Activator {

	public static function activate(): void {
		$defaults = array(
			'step'      => '0.05',
			'mode'      => 'nearest', // nearest | up | down.
			'fee_label' => __( 'Ajustement / arrondi', 'websource-pricesupp' ),
			'enabled'   => 1,
		);
		add_option( 'wps_settings', $defaults );
	}
}
