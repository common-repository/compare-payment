<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Compare_Payment
 * @subpackage Compare_Payment/admin
 * @author     Abileweb
 */
class Compare_Payment_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/compare-payment-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/compare-payment-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Register Comapare Payment Post Type
	 *
	 * @since    1.0.0
	 */
	public function payment_post_type(){
		
		$cpt_labels = array( 
		'name' 					=> esc_html__( 'Payments Type', 'compare-payment' ),
		'singular_name' 		=> esc_html__( 'Payment', 'compare-payment' ),
		'add_new' 				=> esc_html__( 'Add New', 'compare-payment' ),
		'add_new_item' 			=> esc_html__( 'Add New Payment', 'compare-payment' ),
		'edit_item' 			=> esc_html__( 'Edit Payment', 'compare-payment' ),
		'new_item' 				=> esc_html__( 'New Payment', 'compare-payment' ),
		'all_items' 			=> esc_html__( 'Payments', 'compare-payment' ),
		'view_item' 			=> esc_html__( 'View Payment', 'compare-payment' ),
		'search_items' 			=> esc_html__( 'Search Payments', 'compare-payment' ),
		'not_found' 			=> esc_html__( 'No payments found', 'compare-payment' ),
		'not_found_in_trash' 	=> esc_html__( 'No payments found in Trash', 'compare-payment' ),
		'parent_item_colon' 	=> ''
	);
	
	$cpt_args = array(
		'labels' 				=> $cpt_labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'show_in_menu'       	=> true,
		'query_var' 			=> true,
		'rewrite' 				=> array( 'slug' => 'compare-payments' ),
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'has_archive' 			=> false,
		'exclude_from_search' 	=> true,
		'supports' 				=> array( 'title', 'thumbnail' )
	);
	
	register_post_type( 'compare-payments', $cpt_args );
	
	}

	/**
	 * metabox for comapare payment post type
	 *
	 * @since    1.0.0
	 */
	 public function add_compare_payment_metabox(){
	 	
		add_meta_box( 'compare-payment-metabox', esc_html__( 'Compare Payment Metabox', $this->plugin_name ), array( $this, 'compare_payment_metabox' ), 'compare-payments', 'normal', 'high' );
		
	 }
	 
	 /**
	 * Render Metabox under Compare Payment
	 *
	 * compare-payment meta field
	 *
	 * @param $post
	 *
	 * @since 1.0.0
	 *
	 */
	 public function compare_payment_metabox( $post ){
	 
		$get_cp_own						= get_post_meta( $post->ID, 'cp_own', true );
		$get_cp_trans_fee 				= get_post_meta( $post->ID, 'cp_trans_fee', true );
		$get_cp_trans_add_fee			= get_post_meta( $post->ID, 'cp_trans_additoinal_fee', true );
		$get_cp_min_trans_fee 			= get_post_meta( $post->ID, 'cp_min_trans_fee', true );
		$get_cp_card_body 				= get_post_meta( $post->ID, 'cp_card_body', true );
		$get_cp_card_bottom 			= get_post_meta( $post->ID, 'cp_card_bottom', true );
     	
		$cp_own = isset( $get_cp_own ) ? esc_attr( $get_cp_own ) : '';
		$cp_trans_fee = isset( $get_cp_trans_fee ) ? esc_attr( $get_cp_trans_fee ) : '';
		$cp_trans_additoinal_fee = isset( $get_cp_trans_add_fee ) ? esc_attr( $get_cp_trans_add_fee ) : '';
		$cp_min_trans_fee = isset( $get_cp_min_trans_fee ) ? esc_attr( $get_cp_min_trans_fee ) : '';
		$cp_card_body = isset( $get_cp_card_body ) ? esc_attr( $get_cp_card_body ) : '';
		$cp_card_bottom = isset( $get_cp_card_bottom ) ? esc_attr( $get_cp_card_bottom ) : '';

		wp_nonce_field( 'compare_payment_security', 'cp_nounce_value' );
		
		?>
		<div class="form-group">
			<label for="cp_own"><?php esc_html_e( 'Is This Your Own Payment Method', $this->plugin_name ); ?></label>
			<select class="form-control" name="cp_own" id="cp_own">
				<option value="no" <?php selected( $cp_own, 'no' ); ?>><?php esc_html_e( 'No', $this->plugin_name ); ?></option>
				<option value="yes" <?php selected( $cp_own, 'yes' ); ?>><?php esc_html_e( 'Yes', $this->plugin_name ); ?></option>
			</select>
		</div>
	
		<div class="form-group">
			<label for="cp_trans_fee"><?php esc_html_e( 'Transaction Fee', $this->plugin_name ); ?></label>
			<input class="form-control" type="text" name="cp_trans_fee" id="cp_trans_fee" value="<?php echo esc_attr( $cp_trans_fee ); ?>" />
			<span><?php esc_html_e( 'Enter payment gateway transaction fees. Don\'t mention currency. Example: 2.9', $this->plugin_name ); ?></span>
		</div>
	
		<div class="form-group">
			<label for="cp_trans_additoinal_fee"><?php esc_html_e( 'Additional Fee', $this->plugin_name ); ?></label>
			<input class="form-control" type="text" name="cp_trans_additoinal_fee" id="cp_trans_additoinal_fee" value="<?php echo esc_attr( $cp_trans_additoinal_fee ); ?>" />
			<span><?php esc_html_e( 'Enter payment gateway transaction additional fees. Don\'t mention currency. Example: 0.3', $this->plugin_name ); ?></span>
		</div>
	
		<div class="form-group">
			<label for="cp_min_trans_fee"><?php esc_html_e( 'Minimum Transaction Fee', $this->plugin_name ); ?></label>
			<input class="form-control" type="text" name="cp_min_trans_fee" id="cp_min_trans_fee" value="<?php echo esc_attr( $cp_min_trans_fee ); ?>" />
			<span><?php esc_html_e( 'Enter your minimum transaction fees. Don\'t mention currency. Example: 0.03', $this->plugin_name ); ?></span>
		</div>
	
		<div class="form-group">
			<label for="cp_card_body"><?php esc_html_e( 'Card Body Text', $this->plugin_name ); ?></label>
			<input class="form-control" type="text" name="cp_card_body" id="cp_card_body" value="<?php echo esc_attr( $cp_card_body ); ?>" />
			<span><?php esc_html_e( 'Example: YOU PAY', $this->plugin_name ); ?></span>
		</div>
	
		<div class="form-group">
			<label for="cp_card_bottom"><?php esc_html_e( 'Card Bottom Text', $this->plugin_name ); ?></label>
			<input class="form-control" type="text" name="cp_card_bottom" id="cp_card_bottom" value="<?php echo esc_attr( $cp_card_bottom ); ?>" />
			<span><?php esc_html_e( 'Example: 2.9% + 30&#162;', $this->plugin_name ); ?></span>
		</div>
	 <?php }
	 
	 /**
	 * Determines whether or not the current user has the ability to save meta data associated with this post.
	 *
	 * Save Compare Payment Meta Field
	 *
	 * @param        int $post_id //The ID of the post being save
	 * @param         bool //Whether or not the user has the ability to save this post.
	 */
	 public function save_compare_payment_metabox( $post_id  ){
	 
    	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		
		if ( ! isset( $_POST['cp_nounce_value'] ) || ! wp_verify_nonce( $_POST['cp_nounce_value'], 'compare_payment_security' ) ) return;
		
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;

		if( isset( $_POST[ 'cp_own' ] ) ) :
			update_post_meta( $post_id, 'cp_own', sanitize_text_field( $_POST['cp_own'] ) ); 
		else:
			delete_post_meta( $post_id, 'cp_own' ); 
		endif;
		
		if( isset( $_POST[ 'cp_trans_fee' ] ) ) :
			update_post_meta( $post_id, 'cp_trans_fee', sanitize_text_field( $_POST['cp_trans_fee'] ) );
		else: 
			delete_post_meta( $post_id, 'cp_trans_fee' );
		endif;
		
		if( isset( $_POST[ 'cp_trans_additoinal_fee' ] ) ): 
			update_post_meta( $post_id, 'cp_trans_additoinal_fee', sanitize_text_field( $_POST['cp_trans_additoinal_fee'] ) );
		else:
			delete_post_meta( $post_id, 'cp_trans_additoinal_fee' );
		endif;
		
		if( isset( $_POST[ 'cp_min_trans_fee' ] ) ):
			update_post_meta( $post_id, 'cp_min_trans_fee', sanitize_text_field( $_POST['cp_min_trans_fee'] ) );
		else: 
			delete_post_meta( $post_id, 'cp_min_trans_fee' );
		endif;
		
		if( isset( $_POST[ 'cp_card_body' ] ) ):
			update_post_meta( $post_id, 'cp_card_body', sanitize_text_field( $_POST['cp_card_body'] ) );
		else:
			delete_post_meta( $post_id, 'cp_card_body' );
		endif;
		
		if( isset( $_POST[ 'cp_card_bottom' ] ) ):
			update_post_meta( $post_id, 'cp_card_bottom', sanitize_text_field( $_POST['cp_card_bottom'] ) );
		else:
			delete_post_meta( $post_id, 'cp_card_bottom' );
		endif;
		
	}
	
	// Register the administration menu for this plugin into the WordPress Dashboard menu. 
	public function register_compare_payment_menu_page(){
		add_menu_page(
        	esc_html__( 'Compare Payment', $this->plugin_name ),
        	esc_html__( 'Compare Payment', $this->plugin_name ),
        	'manage_options',
        	'compare-payment',
			array( $this, 'cp_submenu_page_callback' ),
			plugin_dir_url( __FILE__ ) . '/images/transaction.png'
		);
	}
	
	public function cp_submenu_page_callback(){
		
		include('partials/compare-payment-admin-display.php');
	}
}
