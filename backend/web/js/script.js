$(document).ready(function(){
	/*Ajust menu size*/
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

	/*End of ajustment*/

	//change icon for accordion change
	$('.accordion').on('shown.bs.collapse', function(e){ 
		$(e.target).prev('.accordion-heading').find('.glyphicon-plus').toggleClass("glyphicon-plus glyphicon-minus");
	});

	$('.accordion').on('hide.bs.collapse', function(e){ 
		$(e.target).prev('.accordion-heading').find('.glyphicon-minus').toggleClass("glyphicon-minus glyphicon-plus");
	});

	//removes error message on each interaction
	$("*").on("focus",function(){
		if ($(this).parent().hasClass("has-error")){
			$(this).parent().removeClass("has-error");
			$(this).parent().find(".help-block").empty();
		}
	});

	//add new item to parts grid
	$(".addButton").on("click",function(){
		var lastLineId = $(".partsInsert tr:last").attr("id");
		lastLineId = lastLineId.split("_").pop();
		console.log(lastLineId);
		lastLineId++;

		var content = '<tr id="line_'+lastLineId+'">'+
		'<th>'+
			'<div class="form-group field-parts-'+lastLineId+'-partcode"><input type="text" id="parts-'+lastLineId+'-partcode" class="form-control" name="Parts['+lastLineId+'][partCode]"><div class="help-block"></div></div>'+
		'</th>'+
		'<th>'+
			'<div class="form-group field-parts-'+lastLineId+'-partquant"><input type="text" id="parts-'+lastLineId+'-partquant" class="form-control" name="Parts['+lastLineId+'][partQuant]"><div class="help-block"></div></div>'+
		'</th>'+
		'<th>'+
			'<div class="form-group field-parts-'+lastLineId+'-partdesc required"><input type="text" id="parts-'+lastLineId+'-partdesc" class="form-control" name="Parts['+lastLineId+'][partDesc]"><div class="help-block"></div></div>'+
		'</th>'+
		'<th>'+
			'<div class="form-group field-parts-'+lastLineId+'-partprice required"><input type="text" id="parts-'+lastLineId+'-partprice" class="form-control" name="Parts['+lastLineId+'][partPrice]"><div class="help-block"></div></div>'+
		'</th>'+
		'</tr>';
		$(".partsInsert tbody tr:last").after(content);
	});
});