/*function DropDowns(el) {
	this.dd = el;
	this.initEvents();
}
DropDowns.prototype = {
	initEvents : function() {
		var obj = this;

		obj.dd.on('click', function(event){
			//console.log(obj);
			var ids = $(this).attr("id");
			if($("#ww-order .dd input:radio:checked").val() > 0){
				
				$("#"+ids+' .text_head').html($("#"+ids+" input:radio:checked").attr("alt"));
				if($("#"+ids).hasClass("active"))
				{
					
					if($("#"+ids).attr('tabindex')=="1") {
						$("#"+ids).attr("tabindex","2")
						$(this).toggleClass('active');
					}
					else if($("#"+ids).attr('tabindex')=="2") {
						$("#"+ids).attr("tabindex","1")
					}
				}
		
			$(this).next().val($("#"+ids+" input:radio:checked").attr("alt"));
			}
			//sub();
			$(this).toggleClass('active');
			
			event.stopPropagation();
			
		});
	}
}
*/
$(function(){
	/*
	$('.ww_tab_nav label').click(function() {
		var ids = $(this).parent().parent().attr("id");
		$('#'+ids+" label").each(function(){
			$(this).removeClass('ww-active'); 	
		});
		$(this).addClass('ww-active');
	});
*/
	/*var dd = new DropDowns( $('#ww-order .dd') );
	$(document).click(function() {
		// all dropdowns
		$('#ww-order .ww-rez_select').removeClass('active');
		//$('.ww-rez_select').toggleClass('active');
	});
	*/
	
	
 /*
$(".dd ul").hide();
$(".h3_arr_bg span").click(function(){
$(this).parent().next().slideToggle();
});*/
				  /*  
				    $('.ww-input-count a').live('click', function() {
				    	var ids = $(this).attr("class");
						$('.ww-input-count input.cnt'+ids).val(parseInt($('.ww-input-count input.cnt'+ids).val(),10)+1);
						//	document.forms['basket_form'].submit();
				    	subs();
				    	
				    });    */
 		/*$('#ww-order #up').live("click", function(){
			var ids = $(this).attr("class");
				$('.ww-input-count input.cnt'+ids).val(parseInt($('.ww-input-count input.cnt'+ids).val(),10)+1);
				
				
				        
			});*/
	/*	$('#ww-order #down').live("click", function(){
			var ids = $(this).attr("class");
				if(parseInt($('.ww-input-count input.cnt'+ids).val(),10)>1){
					$('.ww-input-count input.cnt'+ids).val(parseInt($('.ww-input-count input.cnt'+ids).val(),10)-1);
				}
				else {
					$('.ww-input-count input.cnt'+ids).val(1);
				}
			subs();
		});

*/
/*	
	var tabContainers = $('div.ys_tv_tab');
	var initialCost = $('.ys-sum').find("strong").text().replace(/\D+/,'');
	//console.log(initialCost); 
	tabContainers.hide().filter(':first').show();
	$('.ys_tab_nav a').click(function () {
			tabContainers.hide().filter(this.hash).show();
			//$('.ys_tab_nav a').removeClass('ys_active');
			$(this).parent().parent().find("a").removeClass('ys_active');
			$(this).addClass('ys_active');			
			$(this).parent().find('input').attr("checked", "checked"); 			
			$('.ys_tab_nav a[href='+$(this).attr("href")+']').addClass('ys_active');
			
			setDelivery(initialCost);
					
			return false;
		});
		
	setDelivery(initialCost);
		
	*/	
		
});
/*
function subs(){
	
	var $form = $('#basket_form'),
				        form_url = $form.attr('#'),
				        $selects = $form.find('.ww-input-count a'),
				        $buttons = $form.find('input[type=submit]'),
				        $result = $('#ww-bask'); 
				
    
					var datas = $form.serializeArray();
				    	//datas.push({'name': 'ajax_call', 'value': 'Y'});        
				        $.get(form_url, datas, function(datas) {
				            $result.html(datas);
				        });

	//document.forms['basket_form'].submit();
}

function setDelivery(initialCost)
{
	var activeButton = $('a.ys_active');
	if(activeButton.find("[name = 'PROPERTY[DELIVERY_E]']").attr('placeholder')>0)
	{
		$('.ys-delivery').show();
		if(/\d+/.test($('.ys-delivery').find("strong").text()))
		{	
			var newDeliveryCost = $('.ys-delivery').find("strong").html().replace(/\d+/, activeButton.find("[name = 'PROPERTY[DELIVERY_E]']").attr('placeholder'));
			$('.ys-delivery').find("strong").replaceWith('<strong>'+newDeliveryCost+'</strong>');
			
			var newCost = $('.ys-sum').find("strong").html().replace(/\d+/, parseFloat(initialCost,10) + parseFloat(activeButton.find("[name = 'PROPERTY[DELIVERY_E]']").attr('placeholder'),10));
			$('.ys-sum').find("strong").replaceWith('<strong>'+newCost+'</strong>');
		}
	}
	else
	{
		$('.ys-delivery').hide();
		
		var newCost = $('.ys-sum').find("strong").html().replace(/\d+/, initialCost);
		$('.ys-sum').find("strong").replaceWith('<strong>'+newCost+'</strong>');
		
	}
}

function setQuantity(id, operation){
	var q = $(id).attr('value');
	if(operation == '-' && q > 1)
		q --;
	if(operation == '+' )
		q++;	
	 $(id).attr('value', q);	
	 $('#BasketRefresh').attr('value', 'Y');
	
	document.forms['basket_form'].submit();
}
*/