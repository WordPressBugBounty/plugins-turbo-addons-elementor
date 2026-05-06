(function($){
	$(document).ready(function(){
		// Function to handle dismiss action
		function dismissNotice() {
			const url = new URL(window.location.href);
			url.searchParams.set('traddismissed', '1');
			url.searchParams.set('trad_nonce', tradData.nonce); // ✅ Add nonce
			window.location.href = url.toString();
		}

		// Close Notice button click handler
		$('.trad-dismiss').on('click', function(){
			dismissNotice();
		});

		// X close button click handler (WordPress default dismiss button)
		$('.trad-notice .notice-dismiss').on('click', function(e){
			e.preventDefault();
			dismissNotice();
		});

		$('.tinfo-hide').on('click', function(){
			const url = new URL(window.location.href);
			url.searchParams.set('tinfohide', '1');
			url.searchParams.set('trad_nonce', tradData.nonce); // ✅ Add nonce
			window.location.href = url.toString();
		});
	});
})(jQuery);
