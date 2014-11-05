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

	$('.accordion').on('shown.bs.collapse', function(e){ 
		$(e.target).prev('.accordion-heading').find('.glyphicon-plus').toggleClass("glyphicon-plus glyphicon-minus");
	});

	$('.accordion').on('hide.bs.collapse', function(e){ 
		$(e.target).prev('.accordion-heading').find('.glyphicon-minus').toggleClass("glyphicon-minus glyphicon-plus");
	});

	$("*").on("focus",function(){
		if ($(this).parent().hasClass("has-error")){
			$(this).parent().removeClass("has-error");
			$(this).parent().find(".help-block").empty();
		}
	});
});