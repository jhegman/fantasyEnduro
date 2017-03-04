export const NavIsScrolled = function() {
	const $ = jQuery;
	var scroll = $(window).scrollTop();
	if (scroll >= 50) {
		$("body").addClass("is-scrolled");
	} else {
		$("body").removeClass("is-scrolled");
	}
};