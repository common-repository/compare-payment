<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://abileweb.com/
 * @since             1.0.0
 * @package           Compare_Payment
 *
 * @wordpress-plugin
 * Plugin Name:       Compare Payment
 * Plugin URI:        http://abileweb.com/compare-payment/
 * Description:       This is online transaction payment compare plugin.
 * Version:           1.0.2
 * Author:            Abileweb
 * Author URI:        http://abileweb.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       compare-payment
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-compare-payment-activator.php
 */
function activate_compare_payment() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-compare-payment-activator.php';
	Compare_Payment_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-compare-payment-deactivator.php
 */
function deactivate_compare_payment() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-compare-payment-deactivator.php';
	Compare_Payment_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_compare_payment' );
register_deactivation_hook( __FILE__, 'deactivate_compare_payment' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-compare-payment.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_compare_payment() {

	$plugin = new Compare_Payment();
	$plugin->run();

}
run_compare_payment();
