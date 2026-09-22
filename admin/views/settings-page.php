<?php
/**
 * Vue : réglages de l'arrondi de panier.
 *
 * @var array $settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap">
	<h1><?php esc_html_e( 'WebsourcePriceSupp — Arrondi de panier', 'websource-pricesupp' ); ?></h1>
	<p><?php esc_html_e( 'Arrondit le total du panier WooCommerce à l’unité choisie, et affiche l’écart sous forme d’une ligne "Ajustement / arrondi" transparente dans le panier, le tunnel de commande et la commande.', 'websource-pricesupp' ); ?></p>

	<form method="post" action="options.php">
		<?php settings_fields( 'wps_settings_group' ); ?>
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><?php esc_html_e( 'Activer l’arrondi', 'websource-pricesupp' ); ?></th>
				<td>
					<label>
						<input type="checkbox" name="wps_settings[enabled]" value="1" <?php checked( ! empty( $settings['enabled'] ) ); ?> />
						<?php esc_html_e( 'Appliquer l’arrondi sur le panier et le tunnel de commande', 'websource-pricesupp' ); ?>
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="wps_step"><?php esc_html_e( 'Pas d’arrondi', 'websource-pricesupp' ); ?></label></th>
				<td>
					<select id="wps_step" name="wps_settings[step]">
						<?php
						$steps = array(
							'0.05' => __( '0,05 (5 centimes)', 'websource-pricesupp' ),
							'0.10' => __( '0,10 (10 centimes)', 'websource-pricesupp' ),
							'0.50' => __( '0,50 (50 centimes)', 'websource-pricesupp' ),
							'1.00' => __( '1,00 (unité entière)', 'websource-pricesupp' ),
						);
						foreach ( $steps as $value => $label ) :
							?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $settings['step'] ?? '0.05', $value ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Mode d’arrondi', 'websource-pricesupp' ); ?></th>
				<td>
					<label><input type="radio" name="wps_settings[mode]" value="nearest" <?php checked( $settings['mode'] ?? 'nearest', 'nearest' ); ?> /> <?php esc_html_e( 'Au plus proche', 'websource-pricesupp' ); ?></label><br />
					<label><input type="radio" name="wps_settings[mode]" value="up" <?php checked( $settings['mode'] ?? 'nearest', 'up' ); ?> /> <?php esc_html_e( 'Toujours arrondir au-dessus', 'websource-pricesupp' ); ?></label><br />
					<label><input type="radio" name="wps_settings[mode]" value="down" <?php checked( $settings['mode'] ?? 'nearest', 'down' ); ?> /> <?php esc_html_e( 'Toujours arrondir en-dessous', 'websource-pricesupp' ); ?></label>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="wps_fee_label"><?php esc_html_e( 'Libellé de la ligne de frais', 'websource-pricesupp' ); ?></label></th>
				<td><input type="text" id="wps_fee_label" name="wps_settings[fee_label]" class="regular-text" value="<?php echo esc_attr( $settings['fee_label'] ?? __( 'Ajustement / arrondi', 'websource-pricesupp' ) ); ?>" /></td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
</div>
