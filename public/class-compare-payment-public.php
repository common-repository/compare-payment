<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Compare_Payment
 * @subpackage Compare_Payment/public
 * @author     Abileweb
 */
class Compare_Payment_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Compare_Payment_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'rangeslider', plugin_dir_url( __FILE__ ) . 'css/rangeslider.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/compare-payment-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Compare_Payment_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( 'compare-payment-rangslider', plugin_dir_url( __FILE__ ) . 'js/rangeslider.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/compare-payment-public.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Define Short Code Function
	 *
	 * @param $atts
	 *
	 * @return mixed
	 * @since 1.0.0
	 */
	 public function compare_payment_shortcode_function($atts) {
	 	
		$cp_atts = shortcode_atts(
			array(
				'compare_posts' => '',
				'cols' => '3'
			),
			$atts, 
			'compare-payments' 
		);
		
		$output = $this->compare_payment_shortcode_output($cp_atts);
		
		return $output;
	 }
	 
	 /**
	 *  Shortcode Function
	 *
	 * @since   1.0.0
	 *
	 * @param   $args   Shortcode Parameter
	 */
	public function compare_payment_shortcode_output( $cp_atts ){
	
		$compare_posts = isset( $cp_atts['compare_posts'] ) ? sanitize_text_field( $cp_atts['compare_posts'] ) : '';
		$cols = isset( $cp_atts['cols'] ) && $cp_atts['cols'] != '' ? absint( $cp_atts['cols'] ) : '3';
		$cols = $cols ? absint( 12/$cols ) : '4';
		
		$post_in = '';
		if( !empty( $compare_posts ) ){
			$compare_posts = preg_replace('/\s+/', '', $compare_posts);
			$post_in = explode( ",", $compare_posts );		
		}
	
		$cp_values = get_option( 'compare_payment_values' );
		$payment_currency = isset( $cp_values['payment_currency'] ) ? sanitize_text_field( $cp_values['payment_currency'] ): '';
		$range_min = isset( $cp_values['range_min'] ) ? sanitize_text_field( $cp_values['range_min'] ) : '';
		$range_max = isset( $cp_values['range_max'] ) ? sanitize_text_field( $cp_values['range_max'] ) : '';
		$range_step = isset( $cp_values['range_step'] ) ? sanitize_text_field( $cp_values['range_step'] ) : '';
		$range_value = isset( $cp_values['range_value'] ) ? sanitize_text_field( $cp_values['range_value'] ) : '';
		
		$output = '';
		$output .= '<div class="compare-wrap pt-5 pb-5">
						<div class="container">
							<div class="compare-inner-wrap row">
								<div class="compare-ranger-text col-md-2 align-self-center text-center">
									<span>'. esc_html__( 'Minmum', 'comparepayment' ) .'</span>
									<h6>'. esc_html( $range_min ) .'</h6>
								</div>
								<div class="compare-rage-slider mb-5 mt-5 col-md-8">
									<input class="range-slider" type="range" min="'. esc_attr( $range_min ) .'" max="'. esc_attr( $range_max ) .'" step="'. esc_attr( $range_step ) .'" value="'. esc_attr( $range_value ) .'">
								</div>
								<div class="compare-ranger-text col-md-2 align-self-center text-center">
									<span>'. esc_html__( 'Maximum', 'comparepayment' ) .'</span>
									<h6>'. esc_html( $range_max ) .'</h6>
								</div>
							</div><!-- .compare-inner-wrap -->';
	
							$args = array(
								'post_type'		=> 'compare-payments',
								'post_status'	=> array( 'publish' ),
								'post__in'		=> esc_attr( $post_in ),
								'orderby' 		=> 'post__in'
							);
							
						$payment_out = '';
						// The Query
						$the_query = new WP_Query( $args ); //var_dump( $the_query );
						$cp_array = array();
						
						// The Loop
						if ( $the_query->have_posts() ) {
						
							$payment_out .= '<div class="compare-others-wrap"><div class="row">';
						
								while ( $the_query->have_posts() ) { $the_query->the_post();
				
									$post_id = get_the_ID();
									$featured_img_url = get_the_post_thumbnail_url(); 
									$post_title = get_the_title();
									$get_cp_own				= get_post_meta( $post_id, 'cp_own', true );
									$get_cp_trans_fee 		= get_post_meta( $post_id, 'cp_trans_fee', true );
									$get_cp_trans_add_fee	= get_post_meta( $post_id, 'cp_trans_additoinal_fee', true );
									$get_cp_min_trans_fee 	= get_post_meta( $post_id, 'cp_min_trans_fee', true );
									$get_cp_card_body 		= get_post_meta( $post_id, 'cp_card_body', true );
									$get_cp_card_bottom 	= get_post_meta( $post_id, 'cp_card_bottom', true );
									$cp_own = isset( $get_cp_own ) ? sanitize_text_field( $get_cp_own ) : '';
									$cp_trans_fee = isset( $get_cp_trans_fee ) ? sanitize_text_field( $get_cp_trans_fee ) : '';
									$cp_trans_additoinal_fee = isset( $get_cp_trans_add_fee ) ? sanitize_text_field( $get_cp_trans_add_fee ) : '';
									$cp_min_trans_fee = isset( $get_cp_min_trans_fee ) ? sanitize_text_field( $get_cp_min_trans_fee ) : '';
									$cp_card_body = isset( $get_cp_card_body ) ? sanitize_text_field( $get_cp_card_body ) : '';
									$cp_card_bottom = isset( $get_cp_card_bottom ) ? sanitize_text_field( $get_cp_card_bottom ) : '';
							
									$cp_array['compare-payment-post-'. esc_attr( $post_id )] = array(
										'title' => esc_html( $post_title ),
										'compare_trans' => $cp_own,
										'trans_fee' => $cp_trans_fee,
										'additional_fee' => $cp_trans_additoinal_fee,
										'min_trans_fee' => $cp_min_trans_fee
									);
							
									$payment_out .= '<div class="col-md-'. esc_attr( $cols ) .'">
										<div id="compare-payment-post-'. esc_attr( $post_id ) .'" class="card compare-payment text-center compare-'. esc_attr( sanitize_title( $post_title ) ) .'" data-percent="'. esc_attr( $cp_trans_fee ) .'" data-additional="'. esc_attr( $cp_trans_additoinal_fee ) .'" data-min="'. esc_attr( $cp_min_trans_fee ) .'">
											<img class="card-img-top m-auto mt-3" src="'. esc_url( $featured_img_url ) .'" alt="'. esc_attr( $post_title ) .'">
											<div class="card-body">
												<h5 class="card-title">'. esc_html( $cp_card_body ) .'</h5>
												<div class="card-text payment-val"><span>'. esc_html( $payment_currency ) .'</span> <h4 class="payment-val-update"></h4></div>
												<p class="card-bottom">'. esc_html( $cp_card_bottom ) .'</p>
												'. ( $cp_own == 'yes' ? '<div class="cheap-cal-wrap"></div>' : '' ) .'
											</div>
										</div>
									</div>';
								}
						
								$payment_out .= '</div>';
								$payment_out .= '<input type="hidden" class="compare-payment-hidden-json" value="'. htmlspecialchars( json_encode( $cp_array ), ENT_QUOTES, 'UTF-8' ) .'"/>';
								$payment_out .= '</div>';
						
							/* Restore original Post Data */
							wp_reset_postdata();
						}
							$output .= $payment_out;
			$output .= '</div>';
		$output .= '</div>';	
		
		return $output;
	}
	
}
