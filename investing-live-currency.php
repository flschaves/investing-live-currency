<?php
/**
 * Plugin Name: Investing - Live Currency
 * Plugin URI:  https://flschaves.com/
 * Description: Live currency widget for WordPress admin dashboard
 * Author:      Filipe Chaves
 * Author URI:  https://flschaves.com/
 * Text Domain: investing-live-currency
 * Domain Path: /languages
 * Version:     1.0.0
 *
 * @package     Investing_Live_Currency
 */

define( 'INVESTING_LIVE_CURRENCY_VERSION', '1.0.0' );
define( 'INVESTING_LIVE_CURRENCY_PATH', plugin_dir_path( __FILE__ ) );
define( 'INVESTING_LIVE_CURRENCY_URL', plugin_dir_url( __FILE__ ) );

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

function investing_live_currency() {
	return \InvestingLiveCurrency\InvestingLiveCurrency::instance();
}

investing_live_currency();

register_activation_hook( __FILE__, function() {
	investing_live_currency()->activate();
} );

register_deactivation_hook( __FILE__, function() {
	investing_live_currency()->deactivate();
} ); 