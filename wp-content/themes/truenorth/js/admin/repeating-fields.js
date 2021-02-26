var triggerFieldChange = function ( $field ) {
	var $wrapper = $field.closest('.widget-content');
	$wrapper.find('input').trigger('change');
};

var truenorth_repeating_sortable_init = function ( selector ) {
	if ( typeof selector === 'undefined' ) {
		jQuery( '.ci-repeating-fields .inner' ).sortable( {
			placeholder: 'ui-state-highlight',
			stop: function(event, ui) {
				triggerFieldChange(jQuery(ui.item));
			}
		} );
	} else {
		jQuery( '.ci-repeating-fields .inner', selector ).sortable( {
			placeholder: 'ui-state-highlight',
			stop: function(event, ui) {
				triggerFieldChange(jQuery(ui.item));
			}
		} );
	}
};

var truenorth_repeating_colorpicker_init = function ( selector ) {
	if ( typeof selector === 'undefined' ) {
		var ciColorPicker = jQuery( '#widgets-right .colorpckr, #wp_inactive_widgets .colorpckr' ).filter( function () {
			return ! jQuery( this ).parents( '.field-prototype' ).length;
		} );

		ciColorPicker.wpColorPicker();
	} else {
		jQuery( '.colorpckr', selector ).wpColorPicker();
	}
};

jQuery( document ).ready( function ( $ ) {
	"use strict";
	var $body = $( 'body' );

	// Repeating fields
	truenorth_repeating_sortable_init();

	$body.on( 'click', '.ci-repeating-add-field', function ( e ) {
		var repeatable_area = $( this ).siblings( '.inner' );
		var prototype       = repeatable_area.find( '.field-prototype' );
		var fields          = prototype
			.clone()
			.removeClass( 'field-prototype' )
			.removeAttr( 'style' );

		fields.find( 'input, select, textarea' ).attr( 'disabled', false );
		fields.insertBefore( prototype );

		truenorth_repeating_sortable_init();
		truenorth_repeating_colorpicker_init();
		e.preventDefault();
	} );

	$body.on( 'click', '.ci-repeating-remove-field', function ( e ) {
		var $field = $( this ).parents( '.post-field' );
		triggerFieldChange( $field );
		$field.remove();

		e.preventDefault();
	} );
} );
