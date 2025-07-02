<?php
namespace InvestingLiveCurrency;

/**
 * Main plugin class for Investing Live Currency.
 *
 * @since 1.0.0
 */
class InvestingLiveCurrency {
	/**
	 * Plugin instance.
	 *
	 * @since 1.0.0
	 *
	 * @var InvestingLiveCurrency
	 */
	private static $instance;

	/**
	 * Admin functionality instance.
	 *
	 * @since 1.0.0
	 *
	 * @var Admin\Admin
	 */
	public $admin = null;

	/**
	 * Widget functionality instance.
	 *
	 * @since 1.0.0
	 *
	 * @var Widget
	 */
	public $widget = null;

	/**
	 * Get plugin instance.
	 *
	 * @since 1.0.0
	 *
	 * @return InvestingLiveCurrency
	 */
	public static function instance() {
		if ( null === self::$instance || ! self::$instance instanceof self ) {
			self::$instance = new self();
			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * Initialize plugin components.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function init() {
		$this->admin  = new Admin\Admin();
		$this->widget = new Widget();
	}

	/**
	 * Plugin activation hook.
	 *
	 * Sets default options when the plugin is activated.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function activate() {
		// Set default options
		$defaultOptions = [
			'widgetTheme'    => 'lightTheme',
			'currencies'     => [ 1617 ], // EUR/USD by default
			'columns'        => [
				'bid'         => true,
				'ask'         => true,
				'last'        => true,
				'prev'        => true,
				'high'        => true,
				'low'         => true,
				'change'      => true,
				'changePerc'  => true,
				'time'        => true
			]
		];

		update_option( 'investing_live_currency_options', $defaultOptions );
	}

	/**
	 * Plugin deactivation hook.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function deactivate() {
		// Clean up if needed
	}
} 