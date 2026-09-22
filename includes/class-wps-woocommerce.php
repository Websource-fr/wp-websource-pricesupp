<?php
/**
 * Intégration WooCommerce : ajoute une ligne de frais (positive ou négative)
 * égale à l'écart entre le total du panier et sa valeur arrondie.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPS_WooCommerce {

	public static function init(): void {
		add_action( 'woocommerce_cart_calculate_fees', array( __CLASS__, 'apply_rounding_fee' ), 100 );
	}

	public static function get_settings(): array {
		$defaults = array(
			'step'      => '0.05',
			'mode'      => 'nearest',
			'fee_label' => __( 'Ajustement / arrondi', 'websource-pricesupp' ),
			'enabled'   => 1,
		);
		return wp_parse_args( get_option( 'wps_settings', array() ), $defaults );
	}

	/**
	 * Ajoute la ligne de frais d'arrondi au panier WooCommerce.
	 */
	public static function apply_rounding_fee( WC_Cart $cart ): void {
		if ( is_admin() && ! wp_doing_ajax() ) {
			return;
		}

		$settings = self::get_settings();

		if ( empty( $settings['enabled'] ) ) {
			return;
		}

		$step = (float) $settings['step'];
		$mode = in_array( $settings['mode'], array( 'nearest', 'up', 'down' ), true ) ? $settings['mode'] : 'nearest';

		if ( $step <= 0 ) {
			return;
		}

		// Base de calcul : sous-total du panier (après remises), + livraison, + frais déjà ajoutés
		// par d'autres extensions (avant taxes). C'est une simplification volontaire : sur une
		// boutique en taxes incluses avec des taux multiples, l'arrondi porte sur ce total hors
		// dernière étape de taxation, ce qui est documenté dans le readme du plugin.
		$base_total = (float) $cart->get_subtotal() - (float) $cart->get_discount_total() + (float) $cart->get_shipping_total();

		foreach ( $cart->get_fees() as $existing_fee ) {
			$base_total += (float) $existing_fee->amount;
		}

		$delta = WPS_Rounding::get_delta( $base_total, $step, $mode );

		if ( 0.0 === $delta ) {
			return;
		}

		$label = $settings['fee_label'] ?: __( 'Ajustement / arrondi', 'websource-pricesupp' );

		// WC_Cart::add_fee() accepte un montant négatif (remise) ou positif (majoration).
		$cart->add_fee( $label, $delta, false );
	}
}
