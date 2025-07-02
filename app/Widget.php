<?php
namespace InvestingLiveCurrency;

/**
 * Dashboard widget functionality for Investing Live Currency.
 *
 * @since 1.0.0
 */
class Widget {
	/**
	 * Constructor.
	 *
	 * Sets up dashboard widget hooks.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wp_dashboard_setup', [ $this, 'addDashboardWidget' ] );
	}

	/**
	 * Add dashboard widget to WordPress admin.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function addDashboardWidget() {
		wp_add_dashboard_widget(
			'investing_live_currency_widget',
			'Live Currency Rates',
			[ $this, 'renderWidget' ]
		);
	}

	/**
	 * Render the dashboard widget content.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function renderWidget() {
		$options   = get_option( 'investing_live_currency_options', [] );
		$iframeUrl = $this->buildIframeUrl( $options );
		$height    = 60 + ( count( $options['currencies'] ?? [ 1617 ] ) * 58 );

		echo '<iframe src="' . esc_url( $iframeUrl ) . '" width="100%" height="' . esc_attr( $height ) . '" frameborder="0" allowtransparency="true" marginwidth="0" marginheight="0"></iframe>';
		echo '<div class="poweredBy" style="font-family: Arial, Helvetica, sans-serif; margin-top: 10px; font-size: 12px; color: #666;">';
		echo 'Powered by <a href="https://www.investing.com?utm_source=WMT&amp;utm_medium=referral&amp;utm_campaign=LIVE_CURRENCY_X_RATES&amp;utm_content=Footer%20Link" target="_blank" rel="nofollow">Investing.com</a>';
		echo '</div>';
	}

	/**
	 * Build the iframe URL for the Investing.com widget.
	 *
	 * @since 1.0.0
	 *
	 * @param array $options Plugin options array.
	 * @return string The complete iframe URL.
	 */
	private function buildIframeUrl( $options ) {
		$baseUrl = 'https://www.widgets.investing.com/live-currency-cross-rates';
		
		$params = [
			'theme'     => $options['widgetTheme'] ?? 'lightTheme',
			'hideTitle' => 'true',
		];

		// Currency pairs
		$currencies      = $options['currencies'] ?? [ 1617 ];
		$params['pairs'] = implode( ',', $currencies );

		// Build URL
		$url = $baseUrl . '?' . http_build_query( $params );
		
		return $url;
	}
} 