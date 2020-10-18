<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="container">

	<?php wc_print_notices();
	
	do_action( 'woocommerce_before_checkout_form', $checkout );
	
	// If checkout registration is disabled and not logged in, the user cannot checkout
	if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
		echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
		return;
	}
	
	// filter hook for include new pages inside the payment method
	$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', wc_get_checkout_url() ); ?>
	
	<form name="checkout" method="post" class="checkout woocommerce-checkout sd-form-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">
	
		<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>
	
			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
	
			<div class="col2-set" id="customer_details">
				<div class="row">
					<div class="col-md-6">
						<div class="col-1">
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
						</div>
					</div>
					<!-- col-md-6-->
					<div class="col-md-6">
						<div class="col-2">
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
						</div>
					</div>
					<!-- col-md-6-->
				</div>
				<!-- row -->
			</div>
	
			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
	
			<h3 id="order_review_heading" class="sd-widget-title"><?php _e( 'Your order', 'woocommerce' ); ?></h3>
	
		<?php endif; ?>
	
		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
	
		<div id="order_review" class="woocommerce-checkout-review-order sd-order-review">
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>
	
		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
	
	</form>
	
	<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
</div>
<!-- container -->