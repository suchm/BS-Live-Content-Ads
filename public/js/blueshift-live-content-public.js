jQuery(document).ready(function($) {

	var showPopup = true;
	var hasPopup = false;

	var sidebarSpeed = 800;
	var fadeInSpeed = 500;
	var slideDownSpeed = 200;
	var slideUpSpeed = 300;

	var popupRemoveSpeed = 300;

	var mobileWidth = 960;

	// Get preview content
	if ($(window).width() > mobileWidth) {
		var preview_id = get_uri_component('live_content_preview');
		if (preview_id != null) {
			var type     = 'preview';
			var preview  = $("#lc-" + preview_id);
			if (preview.length > 0) {
				var action   = preview.data('action');
				var position = preview.data('position');
				if ( position === 'popup' ) { hasPopup = true }
				lc_ajax_request(preview,preview_id,type,action,position);
			}
		}
	}

	// Get sidebar content
	if ($(window).width() > mobileWidth) {
		$('.lc-sidebar').each(function(){
			var type     = 'live';
			var post_id  = $(this).data('postid');
			var action   = $(this).data('action');
			var position = $(this).data('position');
			lc_ajax_request($(this),post_id,type,action,position);
		});
	}

	// Get popup content
	if ($(window).width() > mobileWidth) {
		$('.lc-popup').each(function(){
			if ( showPopup == true && hasPopup == false ) {
				showPopup = false;
				var type     = 'live';
				var post_id  = $(this).data('postid');
				var action   = $(this).data('action');
				var position = $(this).data('position');
				lc_ajax_request($(this),post_id,type,action,position);
			}
		});
	}

	// Content ajax request
	function lc_ajax_request(el,post_id,type,action,position) {
		$.ajax({
			type: "POST",
			url: lc_ajax_object.ajaxurl,
			data: {
				'action': 'live_content',
				'post_id': post_id,
				'type': type,
				'position': position,
			},
			dataType: "HTML",
			success: function (response) {
				response = response.trim();
				if (response != '') {
					showPreview = true;
					if ( el.hasClass( 'lc-display' ) ){
						el.append(response);
					} else {
						el.find('.lc-display').append(response);
					} 
					if ( el.hasClass('lc-popup') ) { hasPopup = true; }
					if ( action == 'sidebar' ) { live_content_sidebar(el); }
					if ( action == 'fade-in' ) { live_content_fade_in(el); }
					if ( action == 'slide-down' ) { live_content_slide_down(el); }
					if ( action == 'slide-up' ) { live_content_slide_up(el); }
					
				} else {
					if ( el.hasClass('lc-popup') ) { showPopup = true }
				}
			}
		});
	}

	function live_content_sidebar(el){
		el.fadeIn(sidebarSpeed);
		el.css('display', 'flex');
	}

	function live_content_fade_in(el){
		el.fadeIn(fadeInSpeed);
		el.css('display', 'flex');
	}

	function live_content_slide_down(el){
		el.slideDown(slideDownSpeed);
		el.css('display', 'flex');
	}

	function live_content_slide_up(el){
		var slideUpHeight = el.outerHeight();
		el.css('bottom', '-' + slideUpHeight + 'px');
		el.animate({bottom:'0px'},slideUpSpeed);
		el.css('display', 'flex');
	}

	// Close button script

	var popupFadeIn    = $(".lc-popup.lc-popup-fade-in");
	var popupSlideDown = $(".lc-popup.lc-popup-slide-down");
	var popupSlideUp   = $(".lc-popup.lc-popup-slide-up");

	var popupFadeInPreview    = $(".lc-popup-preview.lc-popup-fade-in");
	var popupSlideDownPreview = $(".lc-popup-preview.lc-popup-slide-down");
	var popupSlideUpPreview   = $(".lc-popup-preview.lc-popup-slide-up");

	popupFadeInPreview.find('.exit').click(function(){
		popupFadeInPreview.fadeOut(popupRemoveSpeed);
	});

	// Close the slide down popup
	popupSlideDownPreview.find('.exit').click(function(){
		popupSlideDownPreview.slideUp(slideDownSpeed);
	});

	// Close the slide up popup
	popupSlideUpPreview.find('.exit').click(function(){
		var slideUpPreviewHeight = popupSlideUpPreview.outerHeight();
		popupSlideUpPreview.animate({bottom:'-' + slideUpPreviewHeight + 'px'},popupRemoveSpeed);
	});

	// Close the fade in popup
	popupFadeIn.find('.exit').click(function(){
		popupFadeIn.fadeOut(popupRemoveSpeed);
	});

	// Close the slide down popup
	popupSlideDown.find('.exit').click(function(){
		popupSlideDown.slideUp(slideDownSpeed);
	});

	// Close the slide up popup
	popupSlideUp.find('.exit').click(function(){
		var slideUpHeight = popupSlideUp.outerHeight();
		popupSlideUp.animate({bottom:'-' + slideUpHeight + 'px'},popupRemoveSpeed);
	});

	function setCookie(cname, cvalue) {
		var d = new Date();
		// Cookie expires in 30 days
		d.setTime(d.getTime() + (30*24*60*60*1000));
		var expires = "expires="+ d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	function get_uri_component(name, url) {
        if (!url) url = location.href;
        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regexS = "[\\?&]" + name + "=([^&#]*)";
        var regex = new RegExp(regexS);
        var results = regex.exec(url);
        return results == null ? null : results[1];
    }

});