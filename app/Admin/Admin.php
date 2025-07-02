<?php
namespace InvestingLiveCurrency\Admin;

/**
 * Admin functionality for Investing Live Currency.
 *
 * @since 1.0.0
 */
class Admin {
	/**
	 * Constructor.
	 *
	 * Sets up admin hooks and actions.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'addAdminMenu' ] );
		add_action( 'admin_init', [ $this, 'initSettings' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueueAdminAssets' ] );
	}

	/**
	 * Add admin menu page.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function addAdminMenu() {
		add_options_page(
			'Investing Live Currency',
			'Investing Live Currency',
			'manage_options',
			'investing-live-currency',
			[ $this, 'settingsPage' ]
		);
	}

	/**
	 * Initialize plugin settings.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function initSettings() {
		register_setting( 'investing_live_currency_options', 'investing_live_currency_options' );
	}

	/**
	 * Render the settings page.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function settingsPage() {
		require_once INVESTING_LIVE_CURRENCY_PATH . 'app/Admin/Pages.php';
		$pages = new Pages();
		$pages->renderSettingsPage();
	}

	/**
	 * Enqueue admin assets.
	 *
	 * @since 1.0.0
	 *
	 * @param string $hook The current admin page.
	 * @return void
	 */
	public function enqueueAdminAssets( $hook ) {
		if ( 'settings_page_investing-live-currency' !== $hook ) {
			return;
		}

		wp_enqueue_style(
			'investing-live-currency-admin',
			INVESTING_LIVE_CURRENCY_URL . 'assets/css/admin.css',
			[],
			INVESTING_LIVE_CURRENCY_VERSION
		);

		wp_enqueue_script(
			'investing-live-currency-admin',
			INVESTING_LIVE_CURRENCY_URL . 'assets/js/admin.js',
			[ 'jquery' ],
			INVESTING_LIVE_CURRENCY_VERSION,
			true
		);
	}
} 