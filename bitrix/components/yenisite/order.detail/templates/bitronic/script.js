$(function(){
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
		
		
		
});

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
