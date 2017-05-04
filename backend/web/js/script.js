var globalFuncs = {};

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
		lastLineId++;

		var content = '<tr id="line_'+lastLineId+'">'+
		'<td class="partRemove"><div class="glyphicon glyphicon-remove"></div></td>'+
		'<td>'+
			'<div class="form-group field-parts-'+lastLineId+'-partcode"><input type="text" id="parts-'+lastLineId+'-partcode" class="form-control" name="Parts['+lastLineId+'][partCode]"><div class="help-block"></div></div>'+
		'</td>'+
		'<td>'+
			'<div class="form-group field-parts-'+lastLineId+'-partquant"><input type="text" id="parts-'+lastLineId+'-partquant" class="form-control partInput" name="Parts['+lastLineId+'][partQuant]"><div class="help-block"></div></div>'+
		'</td>'+
		'<td>'+
			'<div class="form-group field-parts-'+lastLineId+'-partdesc required"><input type="text" id="parts-'+lastLineId+'-partdesc" class="form-control" name="Parts['+lastLineId+'][partDesc]"><div class="help-block"></div></div>'+
		'</td>'+
		'<td>'+
			'<div class="form-group field-parts-'+lastLineId+'-partprice required"><input type="text" id="parts-'+lastLineId+'-partprice" class="form-control partInput" name="Parts['+lastLineId+'][partPrice]"><div class="help-block"></div></div>'+
		'</td>'+
		'</tr>';
		$(".partsInsert tbody tr:last").after(content);
	});

	/**
	 * CHECK IF IT IS GOING TO BE NEW OR NOT
	 */	
	globalFuncs.setIfNew = function(el, destEl){
		var val = el.val();

		if (!el.data('last') && el.parent().data('last')){
			el.data('last', el.parent().data('last'));
		}

        //if value change
        if(el.data('last') && el.data('last') != val ){
            destEl.val("new");
        }

        el.data('last',val);
        el.parent().data('last', val);
	}
});