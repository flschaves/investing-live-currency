/* eslint-disable no-undef */
/* eslint-disable no-case-declarations */
/**
 * Admin JavaScript for Investing Live Currency plugin
 */

(function ($) {
	'use strict'

	$(document).ready(function () {
		// Currency pair search functionality.
		const $searchInput    = $('#currency-search')
		const $currencyGrid   = $('.currency-pairs-grid')
		const $currencyLabels = $currencyGrid.find('label')
		const $selectAllBtn   = $('<button type="button" class="button" style="margin-right: 10px;">Select All</button>')
		const $selectNoneBtn  = $('<button type="button" class="button">Select None</button>')

		if ($searchInput.length) {
			$searchInput.on('input', function () {
				const searchTerm = $(this).val().toLowerCase()

				$currencyLabels.each(function () {
					const $label = $(this)
					const currencyText = $label.find('span').text().toLowerCase()

					if (currencyText.includes(searchTerm)) {
						$label.show()
					} else {
						$label.hide()
					}
				})

				// Show/hide "no results" message.
				const visibleLabels = $currencyLabels.filter(':visible')
				if (0 === visibleLabels.length && '' !== searchTerm) {
					if (0 === $('.no-results').length) {
						$currencyGrid.append('<div class="no-results" style="grid-column: 1 / -1; text-align: center; padding: 20px; color: #666; font-style: italic;">No currency pairs found matching "' + searchTerm + '"</div>')
					}
				} else {
					$('.no-results').remove()
				}
			})

			// Clear search when input is cleared.
			$searchInput.on('keyup', function (e) {
				if ('Escape' === e.key) {
					$(this).val('')
					$(this).trigger('input')
				}
			})
		}

		// Select all/none functionality.
		$('.currency-search-wrapper').after(
			$('<div class="currency-actions" style="margin-bottom: 15px;"></div>')
				.append($selectAllBtn)
				.append($selectNoneBtn)
		)

		$selectAllBtn.on('click', function () {
			$currencyLabels.find('input[type="checkbox"]').prop('checked', true)
		})

		$selectNoneBtn.on('click', function () {
			$currencyLabels.find('input[type="checkbox"]').prop('checked', false)
		})
	})
})(jQuery)