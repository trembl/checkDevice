jQuery(document).ready(function(){
	updateWidth();
});

jQuery(window).resize(function() {
	updateWidth();	
});

var updateWidth = function() {
	document.cookie = "windowWidth=" + jQuery(window).width();
}
