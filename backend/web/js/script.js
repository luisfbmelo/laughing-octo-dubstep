$(document).ready(function(){
	function setFullHeight(parent,target){
		var upH = target.height();
		target.css('height' , parent.height());
	}

	$(window).resize(function() {
		setFullHeight($('.menuBox'),$('.menuContainer'));
	});

	$(window).scroll(function() {
		var documentHeight = $(document).height(); // put this line inside scroll
		setFullHeight($('.menuBox'),$('.menuContainer'));
	});

	setFullHeight($('.menuBox'),$('.menuContainer'));
});