<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 *
 * @package    Compare_Payment
 * @subpackage Compare_Payment/admin/partials
 */
 
if (!defined('WPINC')) {
    die;
}
?>
<?php
	
	if ( isset( $_POST['cp_nounce_config_value'] ) && wp_verify_nonce( $_POST['cp_nounce_config_value'], 'compare_payment_configuration' ) ){
	
		if ( current_user_can('edit_posts') ) {
		
			if ( isset( $_POST['cp-form-save'] ) ) {
		
				$payment_currency = isset( $_POST['payment_currency'] ) ? sanitize_text_field( $_POST['payment_currency'] ): '';
				$range_min = isset( $_POST['range_min'] ) ? sanitize_text_field( $_POST['range_min'] ) : '';
				$range_max = isset( $_POST['range_max'] ) ? sanitize_text_field( $_POST['range_max'] ) : '';
				$range_step = isset( $_POST['range_step'] ) ? sanitize_text_field( $_POST['range_step'] ) : '';
				$range_value = isset( $_POST['range_value'] ) ? sanitize_text_field( $_POST['range_value'] ) : '';
		
				$cp_arr = array(
					'payment_currency' => esc_attr( $payment_currency ),
					'range_min' => esc_attr( $range_min ),
					'range_max' => esc_attr( $range_max ),
					'range_step' => esc_attr( $range_step ),
					'range_value' => esc_attr( $range_value )
				);
		
				update_option('compare_payment_values', $cp_arr );
			}
		}
	}
		
	$cp_values = get_option( 'compare_payment_values' );
	$payment_currency = isset( $cp_values['payment_currency'] ) ? sanitize_text_field( $cp_values['payment_currency'] ) : '';
	$range_min = isset( $cp_values['range_min'] ) ? sanitize_text_field( $cp_values['range_min'] ) : '';
	$range_max = isset( $cp_values['range_max'] ) ? sanitize_text_field( $cp_values['range_max'] ) : '';
	$range_step = isset( $cp_values['range_step'] ) ? sanitize_text_field( $cp_values['range_step'] ) : '';
	$range_value = isset( $cp_values['range_value'] ) ? sanitize_text_field( $cp_values['range_value'] ) : '';
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="compare-payment-admin-wrap">
	<h2 class="fonts-page-title"><?php _e( 'Compare Payment.', 'comparepayment' ) ?></h2>
	<form class="compare-payment-form" action="#" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="payment_currency"><?php esc_html_e( 'Payment Currency', 'comparepayment' ); ?></label>
			<input class="form-control" type="text" name="payment_currency" value="<?php echo esc_attr( $payment_currency ); ?>" placeholder="$">
		</div>
		<div class="form-group">
			<label for="range_min"><?php esc_html_e( 'Range Slider Minimum Value', 'comparepayment' ); ?></label>
			<input class="form-control" type="text" name="range_min" value="<?php echo esc_attr( $range_min ); ?>" placeholder="1">
		</div>
		<div class="form-group">
			<label for="range_max"><?php esc_html_e( 'Range Slider Maximum Value', 'comparepayment' ); ?></label>
			<input class="form-control" type="text" name="range_max" value="<?php echo esc_attr( $range_max ); ?>" placeholder="200">
		</div>
		<div class="form-group">
			<label for="range_step"><?php esc_html_e( 'Range Step Value', 'comparepayment' ); ?></label>
			<input class="form-control" type="text" name="range_step" value="<?php echo esc_attr( $range_step ); ?>" placeholder="1">
		</div>
		<div class="form-group">
			<label for="range_value"><?php esc_html_e( 'Range Default Value', 'comparepayment' ); ?></label>
			<input class="form-control" type="text" name="range_value" value="<?php echo esc_attr( $range_value ); ?>" placeholder="100">
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary cp-form-save" name="cp-form-save" value="<?php esc_html_e( 'Save', 'comparepayment' ); ?> " />
		</div>
		<?php wp_nonce_field( 'compare_payment_configuration', 'cp_nounce_config_value' ); ?>
	</form>
</div>