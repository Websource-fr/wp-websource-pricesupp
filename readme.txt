=== WebsourcePriceSupp ===
Contributors: websource
Tags: woocommerce, arrondi, cash rounding, panier, checkout
Requires at least: 6.0
Tested up to: 6.6
Requires PHP: 8.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Arrondit le total du panier WooCommerce à l'unité configurée et affiche l'ajustement de façon transparente.

== Description ==

WebsourcePriceSupp arrondit automatiquement le total du panier WooCommerce (par exemple pour faciliter le paiement en espèces) au pas configuré, et ajoute une ligne de frais visible "Ajustement / arrondi" (positive ou négative) dans le panier, le tunnel de commande et la commande finalisée.

**Ce plugin nécessite WooCommerce.** Si WooCommerce n'est pas actif, le plugin reste installé sans erreur, affiche une notice d'administration, et n'effectue aucune action (no-op complet).

**Réglages disponibles :**

* Pas d'arrondi : 0,05 / 0,10 / 0,50 / 1,00 (ou une valeur personnalisée).
* Mode d'arrondi : au plus proche, toujours au-dessus, ou toujours en-dessous.
* Libellé de la ligne de frais affichée au client.
* Activation/désactivation globale.

Par défaut, sans aucune configuration, le plugin arrondit au 0,05 le plus proche.

== Installation ==

1. Assurez-vous que WooCommerce est installé et activé.
2. Copiez le dossier `websource-pricesupp` dans `wp-content/plugins/` et activez le plugin.
3. Réglez le pas et le mode d'arrondi dans **WooCommerce > Arrondi de panier**.

== Frequently Asked Questions ==

= Le plugin fonctionne-t-il sans WooCommerce ? =

Non, l'arrondi de panier n'a de sens qu'avec un panier WooCommerce. Sans WooCommerce actif, le plugin ne fait rien (aucune erreur, juste une notice d'information).

= Comment le montant de l'arrondi est-il calculé ? =

Le plugin calcule l'écart entre le sous-total du panier (après remises, plus livraison et frais déjà appliqués) et sa valeur arrondie au pas configuré, puis ajoute cet écart comme une ligne de frais WooCommerce (`WC_Cart::add_fee()`), positive ou négative. Sur les boutiques appliquant des taux de TVA multiples avec prix TTC, l'arrondi porte sur le total hors taxation finale : il s'agit d'une simplification assumée, cohérente avec l'usage d'un arrondi de caisse.

== Changelog ==

= 1.0.0 =
* Version initiale.
