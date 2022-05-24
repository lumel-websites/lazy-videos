(function( $ ) {
	'use strict';

	

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).ready(function(e){

		$('.lazy-overlay-hover, .lazy-play-icon').click(function(ee){

			var mode = $(this).parent().parent().data('mode');
			var provider = $(this).parent().parent().data('provider');
			var url = $(this).parent().parent().data('url');
			var video_code = '';
			var embed_code = '';
			var popup_code = '';
		

			if(provider=="youtube"){
				video_code = url.split('=')[1];
				embed_code = '<iframe loading="lazy" src="https://www.youtube.com/embed/' + video_code  + '?autoplay=1&feature=oembed" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>';
			}

			if(provider=="wistia"){
				video_code  = url.split('/').pop();
				embed_code = '<iframe loading="lazy" src="https://fast.wistia.net/embed/iframe/' + video_code  + '?autoPlay=true&volume=1" allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen></iframe>';
			}

			if(provider=="vimeo"){
				video_code  = url.split('/')[3];
				embed_code = '<iframe loading="lazy" src="https://player.vimeo.com/video/' + video_code  + '?autoplay=1&volume=1" allowtransparency="true" allow="autoplay" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen></iframe>';
			}

			if(mode=="inline"){
				$(this).parent().parent().find('.lazy-video-wrapper').html(embed_code);
				$(this).parent().hide();
			}else if(mode=="popup"){
				popup_code  = '<div class="lazy-videos-popup-overlay">';
				popup_code += '<div class="lazy-videos-popup">';
				popup_code += embed_code;
				popup_code += '<button class="lazy-videos-popup-close"><img alt="Click to close video" style="height: 34px;" src="data:image/gif;base64,R0lGODlhRABEAIABAP///////yH5BAEAAAEALAAAAABEAEQAAAKVjI+py+0Po5y02oszBPxyoGFfR41gWJlnpKJWu5muJzvw/NbLjefjruvRfgiecPg5GI/IzpLZfEKjyelMtbKisFoXltQVfcHhkkxaZtzQ6WIwwG4/42E03Rq/M+/6Xr9/RTTxVkc2aNiWqLjI2Oj4CBkpOUlZaXmJmam5ydnp+QkaKjpKWmp6ipqqusra6voKGyvbUwAAOw=="></button>';
				popup_code += '</div>';
				popup_code += '</div>';
				$('body').append(popup_code).on('click', '.lazy-videos-popup-overlay, .lazy-videos-popup-close', function(ee){
					$('.lazy-videos-popup-overlay').remove();
				});
			}

		});


	});

})( jQuery );
