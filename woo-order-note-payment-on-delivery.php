<?php
error_reporting(0);
/*---------------------------------------------------------
Plugin Name: Nota Pagamento Delivery for WooCommerce 
Plugin URI: https://profiles.wordpress.org/carlosramosweb/#content-plugins
Author: carlosramosweb
Author URI: https://criacaocriativa.com
Donate link: https://donate.criacaocriativa.com
Description: Esse plugin é uma versão BETA. Desenvolvido informar na nota de pedido para vendas por Peso e ou Unidades no WooCommerce.
Text Domain: woo-order-note-payment-on-delivery
Domain Path: /languages/
Version: 1.0.0
Requires at least: 3.5.0
Tested up to: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html 
Package: WooCommerce
------------------------------------------------------------*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Woo_Order_Note_Payment_On_Delivery' ) ) {		
	class Woo_Order_Note_Payment_On_Delivery {
	    
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'init_functions' ) );
		}

		public function init_functions() {
			add_action( 'woocommerce_order_details_after_order_table', array( $this, 'woo_order_note_payment_on_delivery' ), 10, 1 );
		}

		public function woo_order_note_payment_on_delivery( $order ) {
			global $wpdb;			
			$comments = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}comments WHERE comment_type = 'order_note' AND comment_approved = '1' AND comment_post_ID = '" . esc_sql( $order->get_id() ) . "' ORDER BY comment_ID DESC" );
			if ( count( $comments ) > 0 ) { ?>
				<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
					<tfoot>
						<tr class="wrap-pgto">
							<th class="wrap-pgto-title">
								Detalhes do Pagamento:
							</th>
							<td class="wrap-pgto-content">
								<?php echo esc_attr( $comments[0]->comment_content ); ?>
							</td>
						</tr>
					</tfoot>
				</table>
				<?php
			}
		}

	}
	new Woo_Order_Note_Payment_On_Delivery();
}

