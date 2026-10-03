<?php
/**
 * Plugin Name:       WebsourcePriceSupp
 * Plugin URI:        https://www.websource.fr/modules-wordpress/module-arrondi-panier-woocommerce
 * Description:       Arrondit le total du panier WooCommerce à l'unité configurée et affiche l'ajustement en toute transparence dans le panier, le tunnel de commande et la commande.
 * Version:           1.1.0
 * Requires at least: 6.0
 * Requires PHP:      8.1
 * Author:            Websource
 * Author URI:        https://www.websource.fr/
 * License:            GPL v2 or later
 * License URI:        https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:        websource-pricesupp
 * Domain Path:        /languages
 * WC requires at least: 7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WPS_VERSION', '1.1.0' );
define( 'WPS_PLUGIN_FILE', __FILE__ );
define( 'WPS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once WPS_PLUGIN_DIR . 'includes/class-wps-activator.php';
require_once WPS_PLUGIN_DIR . 'includes/class-wps-rounding.php';
require_once WPS_PLUGIN_DIR . 'includes/class-wps-woocommerce.php';

register_activation_hook( __FILE__, array( 'WPS_Activator', 'activate' ) );

function wps_load_textdomain(): void {
	load_plugin_textdomain( 'websource-pricesupp', false, dirname( plugin_basename( WPS_PLUGIN_FILE ) ) . '/languages' );
}
add_action( 'init', 'wps_load_textdomain' );

/**
 * Affiche une notice d'admin si WooCommerce n'est pas actif : le plugin ne fait
 * alors rien (aucun hook WooCommerce n'est enregistré), sans jamais provoquer d'erreur fatale.
 */
function wps_admin_notice_missing_woocommerce(): void {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-warning"><p>' .
		esc_html__( 'WebsourcePriceSupp nécessite WooCommerce pour fonctionner. Le plugin est actif mais n’effectue aucune action tant que WooCommerce n’est pas installé et activé.', 'websource-pricesupp' ) .
		'</p></div>';
}

function wps_init_plugin(): void {
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'wps_admin_notice_missing_woocommerce' );
		return; // No-op complet : aucun hook WooCommerce n'est chargé.
	}

	WPS_WooCommerce::init();

	if ( is_admin() ) {
		require_once WPS_PLUGIN_DIR . 'admin/class-wps-admin.php';
		WPS_Admin::init();
		require_once WPS_PLUGIN_DIR . 'admin/class-wps-support-box.php';
		WPS_Support_Box::init();
	}
}
add_action( 'plugins_loaded', 'wps_init_plugin', 20 );
