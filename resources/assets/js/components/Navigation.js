export default class Navigation {

	NavIsScrolled() {
		var scroll = $(window).scrollTop();
		if (scroll >= 50) {
			$("body").addClass("is-scrolled");
		} else {
			$("body").removeClass("is-scrolled");
		}
	}

	OffCanvasToggle() {
		$('.hamburger').click(function() {
			if ($('body').hasClass('off-canvas-open')) {
				$('body').removeClass('off-canvas-open');
			} else {
				$('body').addClass('off-canvas-open');
			}
		});
	}
}