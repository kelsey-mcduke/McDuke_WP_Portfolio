jQuery(document).ready(function($) {
	// Based on https://gist.github.com/4283059
	// also based on the original CSSIgniter script

	var ci_orig = new Object();
	window.ci_orig = ci_orig;

	// All elements with class .ci-upload become buttons.
	// Use the '.uploaded' class in a *sibling* element to indicate the target field for the image URL.
	// Similarly, '.uploaded-id' is the target for the image ID
	// I.e. button: class="ci-upload" and input: class="uploaded"
	$( 'body' ).on( 'click', '.ci-upload', function( e ) {
		e.preventDefault();

		var ciButton = $( this );

		var target_id      = ciButton.siblings( '.uploaded-id' );
		var target_url     = ciButton.siblings( '.uploaded' );
		var target_preview = ciButton.siblings( '.up-preview' );

		var bMulti = ciButton.data( 'multi' ); // Although data-multi="true" works, it's not handled.
		var bFrame = ciButton.data( 'frame' );

		if( typeof bMulti == 'undefined' ) {
			bMulti = false;
		}
		if( typeof bFrame == 'undefined' ) {
			// 'post' allows selection of image size etc, handled by on('insert').
			// 'select' is best when we need only the id, handled by on('select').
			bFrame = 'post';
		}

		var ciMediaUpload = wp.media( {
			frame: bFrame, // Only 'post' and 'select' seem to work with the set of options below.
			title: bMulti == true ? ciMediaManager.tSelectFiles : ciMediaManager.tSelectFile,
			button: {
				text: bMulti == true ? ciMediaManager.tUseTheseFiles : ciMediaManager.tUseThisFile
			},
			multiple: bMulti
		} ).on( 'select', function(){
			// grab the selected images object
			var selection = ciMediaUpload.state().get( 'selection' );

			// grab object properties for each image
			selection.map( function( attachment ){
				var attachment = attachment.toJSON();

				if( bMulti == false ) {
					if( target_id.length > 0 ) {
						target_id.val( attachment.id ).trigger( 'change' );
					}
					if( target_url.length > 0 ) {
						target_url.val( attachment.url ).trigger( 'change' );
					}

					// For some reason, attachment.sizes doesn't include additional image sizes.
					var preview_url = attachment.sizes.full.url;
					if ( typeof attachment.sizes.thumbnail !== 'undefined' ) {
						preview_url = attachment.sizes.thumbnail.url;
					}

					if( target_preview.length > 0 ) {
						var html = '<img src="' + preview_url + '" /><a href="#" class="close media-modal-icon" title="' + ciMediaManager.tRemoveImage + '"></a>';
						target_preview.html( html );
					}
				}
			});
		} ).on( 'insert', function(){
			// grab the selected images object
			var selection = ciMediaUpload.state().get( 'selection' );

			// grab object properties for each image
			selection.map( function( attachment ){
				var display = ciMediaUpload.state().display( attachment ).toJSON();

				var attachment = attachment.toJSON();

				if( bMulti == false ) {
					if( target_id.length > 0 ) {
						target_id.val( attachment.id ).trigger( 'change' );
					}
					if( target_url.length > 0 ) {
						target_url.val( attachment.sizes[display.size].url ).trigger( 'change' );
					}
					if( target_preview.length > 0 ) {
						// Show the size the user selected.
						var html = '<img src="' + attachment.sizes[display.size].url + '" /><a href="#" class="close media-modal-icon" title="' + ciMediaManager.tRemoveImage + '"></a>';
						target_preview.html( html );
					}
				}
			});
		} ).open();


	}); // on click


	$( 'body' ).on( 'click', '.up-preview a.close', function ( e ) {
		e.preventDefault();
		$( this ).parent().html( '' ).siblings( '.uploaded, .uploaded-id' ).val( '' );
	} );



	//
	// CSSIgniter Featured Galleries
	//
	function ci_featgal_backup_functions(){
		window.ci_orig.wp_media_editor_add = wp.media.editor.add;
		window.ci_orig.wp_media_view_l10n_createNewGallery = wp.media.view.l10n.createNewGallery;
		window.ci_orig.wp_media_view_l10n_insertGallery = wp.media.view.l10n.insertGallery;
	}
	function ci_featgal_restore_functions(){
		wp.media.editor.add = window.ci_orig.wp_media_editor_add;
		wp.media.view.l10n.createNewGallery = window.ci_orig.wp_media_view_l10n_createNewGallery;
		wp.media.view.l10n.insertGallery = window.ci_orig.wp_media_view_l10n_insertGallery;
	}

	// Constructs a comma separated list of image IDs, from the currently visible images within the preview area.
	// Also updates the hidden input with the list.
	// Useful for when the user removes or re-arranges images.
	function ci_featgal_UpdateIDs( preview_element )
	{
		var ids = [];
		$(preview_element).children('.thumb').children('img').each(function(){
			ids.push( $(this).data('img-id') );
		});
		
		preview_element.siblings('.ci-upload-to-gallery-ids').val( ids.join(',') );
	}

	// Retrieves a JSON list of IDs and URLs via AJAX, and updates the preview area of the passed gallery container element. 
	function ci_featgal_AJAXUpdate( gallery_container )
	{
		var target_ids = gallery_container.children('.ci-upload-to-gallery-ids');
		var target_preview = gallery_container.children('.ci-upload-to-gallery-preview');

		$.ajax({
			type: "post",
			url: ciMediaManager.ajaxurl,
			data: {
				action: 'ci_featgal_AJAXPreview',
				ids: target_ids.val(),
			},
			dataType: "text",
			beforeSend: function() {
				target_preview.empty().html('<p>'+ ciMediaManager.tLoading +'</p>');
			}, 
			success: function(response){ 

				if(response == 'FAIL')
				{
					target_preview.empty().html('<p>'+ ciMediaManager.tPreviewUnavailable +'</p>');
				}
				else
				{
					// Our response is an object whose properties are key-value pairs.
					// Since JSON doesn't support named keys in arrays, we can't get an
					// array whose keys are IDs and values are URLS.
					// If we do, the keys are sorted numerically and original ordering is lost.
					response = $.parseJSON( response );

					target_preview.empty();
					$.each(response, function(key, value){
						$('<div class="thumb"><img src="'+value.url+'" data-img-id="'+value.id+'"><a href="#" class="close media-modal-icon" title="'+ ciMediaManager.tRemoveFromGallery +'"></a></div>').appendTo( target_preview );
					});
				}
			}//success	
		});//ajax		
		
	}

	// Handle removal of images from the preview area.
	$('body').on('click', '.ci-media-manager-gallery .thumb a.close', function(event){
		event.preventDefault();

		// Store a reference to .ci-media-manager-gallery as we'll not be able to find it later
		// since we are deleting the parent .thumb and we are be able to traverse upwards.
		var container = $(this).parent().parent();

		$(this).parent().remove();

		ci_featgal_UpdateIDs( container );
	});
	
	// Handle re-arranging of images in preview areas.
	var preview_areas = $('.ci-upload-to-gallery-preview');
	if( preview_areas.length > 0 )
	{
		preview_areas.sortable({
			update: function(event, ui){
				ci_featgal_UpdateIDs( $(this) );
			}
		});
	}

	// This is the workhorse function of the featured galleries.
	// Exploits the functionality already provided by the WordPress media manager,
	// by fooling it into thinking that our gallery is a native gallery shortcode.
	$('body').on('click', '.ci-upload-to-gallery', function(event){
		event.preventDefault();

		ci_featgal_backup_functions();
	
		var button = $(this);
		var target_parent = button.parents('.ci-media-manager-gallery');
		var target_ids = button.siblings('.ci-upload-to-gallery-ids');
		var target_rand = button.siblings('p').find('.ci-upload-to-gallery-random > input[type="checkbox"]');

		// Replace the create/update gallery button texts.
		wp.media.view.l10n.insertGallery = ciMediaManager.tUpdateGallery;


		// Check if the `wp.media.gallery` API exists.
		if ( typeof wp === 'undefined' || ! wp.media || ! wp.media.gallery )
			return;

		var gallery = wp.media.gallery,
			frame;

		// If there are no IDs, set to 0 so that the built-in WordPress shortcode won't complain.
		var ids = target_ids.val();
		if( ids.length == 0 )
			ids = '0';

		var rand = target_rand.prop("checked") == true ? 'orderby="rand"' : '';

		// Construct the shortcode that the media manager will read.
		frame = gallery.edit( '[gallery ids="' + ids + '" ' + rand + ' ]' );

		// Handle what happens when the media manager's "Update gallery" button is pressed.
		frame.state('gallery-edit').on( 'update', function( attachments ) {

			var props = attachments.props.toJSON(),
				attrs = _.pick( props, 'orderby', 'order' ),
				shortcode, clone;

			if ( attachments.gallery )
				_.extend( attrs, attachments.gallery.toJSON() );

			// Convert all gallery shortcodes to use the `ids` property.
			// Ignore `post__in` and `post__not_in`; the attachments in
			// the collection will already reflect those properties.
			attrs.ids = attachments.pluck('id');

			// Check if the gallery is randomly ordered.
			if ( attrs._orderbyRandom )
			{
				attrs.orderby = 'rand';
				target_rand.prop("checked", true);
			}
			else
			{
				target_rand.removeProp("checked");
			}
			delete attrs._orderbyRandom;

			// Create a csv list of image IDs into the hidden input.
			target_ids.val( attrs.ids.join(',') );

			// Update the preview area.
			ci_featgal_AJAXUpdate( target_parent );

		}, this );

		// It's important to restore original functionality.
		// Don't return anything other than implied void, otherwise it will get
		// appended in the editor. Even boolean false, gets added as string into the editor.
		ci_featgal_restore_functions();

	});

});
