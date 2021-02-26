/**
 * Base Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Base Theme Customizer preview reload changes asynchronously.
 *
 * https://developer.wordpress.org/themes/customize-api/tools-for-improved-user-experience/#using-postmessage-for-improved-setting-previewing
 */

(function ($) {
	function createStyleSheet(settingName, styles) {
		var $styleElement;

		style = '<style class="' + settingName + '">';
		style += styles.reduce(function (rules, style) {
			rules += style.selectors + '{' + style.property + ':' + style.value + ';} ';
			return rules;
		}, '');
		style += '</style>';

		$styleElement = $('.' + settingName);

		if ($styleElement.length) {
			$styleElement.replaceWith(style);
		} else {
			$('head').append(style);
		}
	}

	//
	// Theme global colors
	//
	wp.customize('site_accent_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_accent_color', [
				{
					property: 'color',
					value: to,
					selectors: 'a:hover,a:focus,.navigation > li ul a:hover,.entry .entry-meta dd a ',
				},
				{
					property: 'background-color',
					value: to,
					selectors:
					'blockquote,.btn,.comment-reply-link,input[type="button"],input[type="submit"],input[type="reset"],button,.entry .read-more a,.portfolio-filters li a:hover,.portfolio-filters li a.selected,#paging a:hover,#paging .current'
				}
			]);
		});
	});

	wp.customize('site_text_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_text_color', [
				{
					property: 'color',
					value: to,
					selectors: 'body,.twitter-time,.widget_meta li a,.widget_pages li a,.widget_categories li a,.widget_archive li a,.widget_nav_menu li a,.widget_product_categories li a,.comment-author a,.comment-author a:hover,.comment-metadata a,.comment-metadata a:hover,.form-allowed-tags,.comment-notes',
				}
			]);
		});
	});

	wp.customize('site_header_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_header_color', [
				{
					property: 'color',
					value: to,
					selectors: 'h1, h2, h3, h4, h5, h6'
				}
			]);
		});
	});

	wp.customize('site_form_bg', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_form_bg', [
				{
					property: 'background-color',
					value: to,
					selectors: 'input[type=text], textarea'
				}
			]);
		});
	});

	wp.customize('site_form_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_form_color', [
				{
					property: 'color',
					value: to,
					selectors: 'input[type=text], textarea'
				}
			]);
		});
	});

	wp.customize('site_form_border', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_form_border', [
				{
					property: 'border-color',
					value: to,
					selectors: 'input[type=text], textarea'
				}
			]);
		});
	});

	wp.customize('site_button_bg', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_button_bg', [
				{
					property: 'background-color',
					value: to,
					selectors: '.btn,.button,input[type="submit"],input[type="reset"],button[type="submit"],a.comment-reply-link,.entry .read-more a',
				}
			]);
		});
	});

	wp.customize('site_button_bg_hover', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_button_bg_hover', [
				{
					property: 'background-color',
					value: to,
					selectors: '.btn:hover,.button:hover,input[type="submit"]:hover,input[type="reset"]:hover,button[type="submit"]:hover,a.comment-reply-link:hover,.entry .read-more a:hover',
				}
			]);
		});
	});

	wp.customize('site_button_text', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_button_text', [
				{
					property: 'color',
					value: to,
					selectors: '.btn,.button,input[type="submit"],input[type="reset"],button[type="submit"],a.comment-reply-link,#comment-list a.comment-reply-link,.entry .read-more a',
				}
			]);
		});
	});

	wp.customize('site_button_text_hover', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_button_text_hover', [
				{
					property: 'color',
					value: to,
					selectors: '.btn:hover,.button:hover,input[type="submit"]:hover,input[type="reset"]:hover,button[type="submit"]:hover,a.comment-reply-link:hover,#comment-list a.comment-reply-link:hover,.entry .read-more a:hover',
				}
			]);
		});
	});
	
	wp.customize('header_bg', function (value) {
		value.bind(function (to) {
			createStyleSheet('header_bg', [
				{
					property: 'background-color',
					value: to,
					selectors: '.nav-hold',
				}
			]);
		});
	});

	wp.customize('header_menu_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('header_menu_color', [
				{
					property: 'color',
					value: to,
					selectors: '.navigation a,.navigation > li ul a',
				}
			]);
		});
	});

	wp.customize('header_menu_color_hover', function (value) {
		value.bind(function (to) {
			createStyleSheet('header_menu_color_hover', [
				{
					property: 'color',
					value: to,
					selectors: '.navigation a:hover,.navigation a:focus,.navigation li .current-menu-item > a,.navigation li .current-menu-parent > a,.navigation li .current-menu-ancestor > a,.navigation > li ul a:hover',
				}
			]);
		});
	});

	wp.customize('header_menu_background', function (value) {
		value.bind(function (to) {
			createStyleSheet('header_menu_background', [
				{
					property: 'background-color',
					value: to,
					selectors: '.navigation > li ul,.navigation > li ul a',
				}
			]);
		});
	});

})(jQuery);
