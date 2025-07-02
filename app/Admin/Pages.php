<?php
namespace InvestingLiveCurrency\Admin;

/**
 * Settings page functionality for Investing Live Currency.
 *
 * @since 1.0.0
 */
class Pages {
	/**
	 * Render the settings page HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function renderSettingsPage() {
		if ( isset( $_POST['submit'] ) ) {
			$this->saveSettings();
		}

		$options        = get_option( 'investing_live_currency_options', [] );
		$currencyPairs  = \InvestingLiveCurrency\Includes\CurrencyPairs::getPairs();
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			
			<form method="post" action="">
				<?php wp_nonce_field( 'investing_live_currency_settings', 'investing_live_currency_nonce' ); ?>
				
				<h2>Widget Theme</h2>
				<table class="form-table">
					<tr>
						<th scope="row">Color Theme</th>
						<td>
							<label>
								<input type="radio" name="investing_live_currency_options[widgetTheme]" value="lightTheme" <?php checked( $options['widgetTheme'] ?? 'lightTheme', 'lightTheme' ); ?>>
								Light
							</label>
							<br>
							<label>
								<input type="radio" name="investing_live_currency_options[widgetTheme]" value="darkTheme" <?php checked( $options['widgetTheme'] ?? 'lightTheme', 'darkTheme' ); ?>>
								Dark
							</label>
						</td>
					</tr>
				</table>

				<h2>Currencies</h2>
				<table class="form-table">
					<tr>
						<th scope="row">Currency Pairs</th>
						<td>
							<div class="currency-search-wrapper" style="margin-bottom: 15px;">
								<input type="text" id="currency-search" placeholder="Search currency pairs..." style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
							</div>
							<div class="currency-pairs-grid">
								<?php foreach ( $currencyPairs as $id => $label ) : ?>
									<label>
										<input type="checkbox" name="investing_live_currency_options[currencies][]" value="<?php echo esc_attr( $id ); ?>" <?php checked( in_array( $id, $options['currencies'] ?? [ 1617 ] ), true ); ?>>
										<span><?php echo esc_html( $label ); ?></span>
									</label>
								<?php endforeach; ?>
							</div>
							<p class="description">
								Select the currency pairs you want to display in the widget.
							</p>
						</td>
					</tr>
				</table>

				<h2>Columns to Show</h2>
				<table class="form-table">
					<tr>
						<th scope="row">Display Columns</th>
						<td>
							<?php
							$columns = [
								'bid'        => 'Bid',
								'ask'        => 'Ask',
								'last'       => 'Last',
								'prev'       => 'Open',
								'high'       => 'High',
								'low'        => 'Low',
								'change'     => 'Change',
								'changePerc' => 'Change %',
								'time'       => 'Time'
							];
							?>
							<?php foreach ( $columns as $key => $label ) : ?>
								<label style="display: block; margin-bottom: 5px;">
									<input type="checkbox" name="investing_live_currency_options[columns][<?php echo esc_attr( $key ); ?>]" value="1" <?php checked( $options['columns'][$key] ?? true, true ); ?>>
									<?php echo esc_html( $label ); ?>
								</label>
							<?php endforeach; ?>
						</td>
					</tr>
				</table>

				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	/**
	 * Save plugin settings.
	 *
	 * Handles form submission and sanitizes user input.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function saveSettings() {
		if ( ! wp_verify_nonce( $_POST['investing_live_currency_nonce'], 'investing_live_currency_settings' ) ) {
			wp_die( 'Security check failed' );
		}

		$options = $_POST['investing_live_currency_options'] ?? [];
		
		// Sanitize options
		$sanitizedOptions = [
			'widgetTheme' => sanitize_text_field( $options['widgetTheme'] ?? 'lightTheme' ),
			'currencies'  => array_map( 'intval', $options['currencies'] ?? [ 1617 ] ),
			'columns'     => [
				'bid'        => isset( $options['columns']['bid'] ),
				'ask'        => isset( $options['columns']['ask'] ),
				'last'       => isset( $options['columns']['last'] ),
				'prev'       => isset( $options['columns']['prev'] ),
				'high'       => isset( $options['columns']['high'] ),
				'low'        => isset( $options['columns']['low'] ),
				'change'     => isset( $options['columns']['change'] ),
				'changePerc' => isset( $options['columns']['changePerc'] ),
				'time'       => isset( $options['columns']['time'] )
			]
		];

		update_option( 'investing_live_currency_options', $sanitizedOptions );
		
		echo '<div class="notice notice-success"><p>Settings saved successfully!</p></div>';
	}
} 