<?php
/**
 * WooCommerce Custom Display Price
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to support@sudosystems.net.au so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Custom Display 
 * Price to newer versions in the future.
 *
 * @package     WC-CDP/Classes
 * @author      Sudo Systems
 * @copyright   Copyright (c) 2014, Sudo Systems
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Custom Display Price Product Class
 *
 * Product utility class
 *
 * @since 0.1
 */
class WC_CDP_Product {

	/**
	 * Returns the display price, if any
	 *
	 * @since 0.1
	 * @param WC_Product|int $product the product or product id
	 * @return float|string product cost if configured, the empty string otherwise
	 */
	public static function get_display_price( $product ) {

		// get the product object
		$product = is_numeric( $product ) ? get_product( $product ) : $product;

		// get the product id
		$product_id = $product->id;

		// get the product display price
		$display_price = get_post_meta( $product_id, '_wc_cdp_price', true );

		return $display_price;

	}
	
	/**
	 * Returns the product display price html, if any
	 *
	 * @since 0.1
	 * @param WC_Product|int $product the product or product id
	 * @return string product cost markup
	 */
	public static function get_display_price_html( $product ) {

		$cost = '';

		// get the product
		$product = is_numeric( $product ) ? get_product( $product ) : $product;

		$display_price = self::get_display_price( $product );

		return $display_price;
	}

}