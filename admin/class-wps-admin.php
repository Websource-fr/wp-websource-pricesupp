<?php
/**
 * Écran de réglages WebsourcePriceSupp.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPS_Admin {

	public static function init(): void {
		add_action( 'admin_menu', array( __CLASS__, 'register_menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
	}

	public static function register_menu(): void {
		add_submenu_page(
			'woocommerce',
			__( 'Arrondi de panier (PriceSupp)', 'websource-pricesupp' ),
			__( 'Arrondi de panier', 'websource-pricesupp' ),
			'manage_woocommerce',
			'websource-pricesupp',
			array( __CLASS__, 'render_settings_page' )
		);
	}

	public static function register_settings(): void {
		register_setting( 'wps_settings_group', 'wps_settings', array( __CLASS__, 'sanitize_settings' ) );
	}

	public static function sanitize_settings( array $input ): array {
		$allowed_steps = array( '0.05', '0.10', '0.50', '1.00' );
		$step          = isset( $input['step'] ) ? (string) $input['step'] : '0.05';
		if ( ! in_array( $step, $allowed_steps, true ) ) {
			// Autorise aussi une valeur numérique personnalisée saisie librement.
			$step = (string) round( max( 0.01, (float) $step ), 2 );
		}

		$mode = isset( $input['mode'] ) && in_array( $input['mode'], array( 'nearest', 'up', 'down' ), true ) ? $input['mode'] : 'nearest';

		return array(
			'step'      => $step,
			'mode'      => $mode,
			'fee_label' => isset( $input['fee_label'] ) ? sanitize_text_field( $input['fee_label'] ) : __( 'Ajustement / arrondi', 'websource-pricesupp' ),
			'enabled'   => ! empty( $input['enabled'] ) ? 1 : 0,
		);
	}

	public static function render_settings_page(): void {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}
		$settings = WPS_WooCommerce::get_settings();
		include WPS_PLUGIN_DIR . 'admin/views/settings-page.php';
	}
}
