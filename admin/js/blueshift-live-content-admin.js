(function( $ ) {
	'use strict';

	$( document ).ready( function () {
		// Enable fast select for publications
		$('.multiplePubSelect').fastselect();
		// Enable date picker for expiry date
		$('.liveContentExpiry').datepicker({
			dateFormat : "dd/mm/yy" 
		});
	});

})( jQuery );
