<?php
/**
 * Logique pure de calcul de l'arrondi (indépendante de WooCommerce, testable isolément).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPS_Rounding {

	/**
	 * Calcule le montant arrondi selon le pas et le mode configurés.
	 *
	 * @param float  $amount Montant à arrondir.
	 * @param float  $step   Pas d'arrondi (ex : 0.05, 0.10, 0.50, 1.00).
	 * @param string $mode   nearest|up|down.
	 */
	public static function round_amount( float $amount, float $step, string $mode = 'nearest' ): float {
		if ( $step <= 0 ) {
			return $amount;
		}

		$ratio = $amount / $step;

		switch ( $mode ) {
			case 'up':
				$rounded_ratio = ceil( $ratio );
				break;
			case 'down':
				$rounded_ratio = floor( $ratio );
				break;
			case 'nearest':
			default:
				$rounded_ratio = round( $ratio );
				break;
		}

		return round( $rounded_ratio * $step, 4 );
	}

	/**
	 * Calcule la différence (delta) entre le montant arrondi et le montant d'origine.
	 * Un delta négatif signifie une réduction, positif une majoration.
	 */
	public static function get_delta( float $amount, float $step, string $mode = 'nearest' ): float {
		return round( self::round_amount( $amount, $step, $mode ) - $amount, 4 );
	}
}
