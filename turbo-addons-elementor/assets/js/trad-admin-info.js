(function($){
	$(document).ready(function(){
		$('.trad-dismiss').on('click', function(){
			const url = new URL(window.location.href);
			url.searchParams.set('traddismissed', '1');
			url.searchParams.set('trad_nonce', tradData.nonce); // ✅ Add nonce
			window.location.href = url.toString();
		});

		$('.tinfo-hide').on('click', function(){
			const url = new URL(window.location.href);
			url.searchParams.set('tinfohide', '1');
			url.searchParams.set('trad_nonce', tradData.nonce); // ✅ Add nonce
			window.location.href = url.toString();
		});
	});
})(jQuery);
