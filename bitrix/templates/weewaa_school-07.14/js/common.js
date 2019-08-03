function DropDown(el) {
	this.dd = el;
	this.initEvents();
}
DropDown.prototype = {
	initEvents : function() {
		var obj = this;

		obj.dd.on('click', function(event){
			//console.log(obj);
			var ids = $(this).attr("id");
			$(this).addClass('active');
			if($("#ww-form_order .dd input:radio:checked").val() > 0){
				$("#"+ids+' .text_head').html($("#"+ids+" input:radio:checked").attr("alt"));
				
				$("#"+ids+' input').bind("change",function(){
					$("#"+ids).removeClass('active');
				});
				/*$("#"+ids+' input').live("click",function(){
					alert('nn');
				});*/
				if($("#"+ids).hasClass("active"))
				{
					//alert('jj');
					//	$(this).removeClass('active');
				}
			}
			//$(this).toggleClass('active');
			event.stopPropagation();
		});
	}
}

function summTr() {
		var all_count = 0;
		var all_summ = 0;
		$("#add_dop > tbody tr").each(function(){

			all_count = all_count + parseInt($(this).find('.ww-quantity input').val()*1);
			var summ_str = $(this).find('.ww-price input').val()*$(this).find('.ww-quantity input').val();	
			
			$(this).find('.ww-summ input').val(summ_str);
			all_summ = all_summ + summ_str;
			
			$('p.ww-cell_itog').text('Итого дополнительных товаров '+all_count+' на сумму  '+all_summ+'р.');
			$('#add_all_summ').val(all_summ);
			
			$('.ww-orange_td span').html('Итого заказ на сумму: ' + parseInt($('.ww-delivery_price input').val()*1+$('#items_all_summ').val()*1+all_summ) + ' руб.');
			$('#all_order_price').val(parseInt($('.ww-delivery_price input').val()*1+$('#items_all_summ').val()*1+all_summ));
		});
}

function summTable() {
	
	var all_cnt = 0;
	var all_summ = 0;
	$("#main-table > tbody tr.item").each(function(){
		var tableOb = $(this); 
		var tr_summ = 0;
//	alert(tableOb.find(".ww-input-count input").val());
	
		if((tableOb.find(".personal_price input").val()*1)>0) {
		 	tr_summ = (tableOb.find(".ww-input-count input").val()*1)*(tableOb.find(".personal_price input").val()*1);
			all_summ = all_summ + tr_summ;
		}
		else {
			tr_summ = (tableOb.find(".ww-input-count input").val()*1)*(tableOb.find(".price input").val()*1);
			all_summ = all_summ + tr_summ;
		} 
	 	all_cnt = all_cnt + (tableOb.find(".ww-input-count input").val()*1);
	});
	//alert(all_cnt); 
	$("#items_all_summ").val(all_summ);
	$(".ww-all-sum span").html('Всего товаров '+all_cnt+' на сумму '+all_summ+'р.');
	summTr();
}
$(function() {
	$("#ww-slider-main footer a").live("mouseover", function(){
		var oldHref = $(".nivo-main-image").attr("src");
			$('#slider img').each(function() {
				if($(this).attr('src') === oldHref) {
					$("#ww-slider-main footer a").attr("href",$(this).attr('data-href'));
				}
		});
		
	});
	$("#ww-order ul.dropdown, #ww-order_new ul.dropdown").each(function(){
		$(this).addClass("no-show");
		//$(this).removeClass('ww-active'); 	
	});
			
	$(".ww-ul-size").live("click", function(){
		var idul = $(this).attr('id');
		$('#'+idul+' ul').toggleClass("yes-show no-show");
		$('#'+idul+' ul label').click(function(){
			//alert($(this).children().attr('alt'));
			$("#"+idul+' .text_head').html($(this).children().attr('alt'));
			$('#'+idul+' ul').toggleClass("yes-show no-show");
			$('#'+idul).next().val($(this).children().val());
			/*alert($(this).children().val());
			alert(idul);*/
			subs();
		});
				//$(this).next().next().css("display","block");
	});
	
			
	$(".ww-add_goods #add_cell").live("click", function(){
		//alert($('#add_dop tr').size());
		var countTr = $('#add_dop tr').size();
		$('#add_dop > tbody:last').append('<tr><td class="ww-num">'+countTr+'<input type="hidden" value="'+countTr+'" name="new_goods['+countTr+'][]"></td><td class="ww-article"><input name="new_goods['+countTr+'][]" type="text" value=""></td><td class="ww-name"><input type="text" value="" name="new_goods['+countTr+'][]"></td><td class="ww-size"><input type="text" value="" name="new_goods['+countTr+'][]"></td><td class="ww-price"><input type="text" value="" name="new_goods['+countTr+'][]"></td><td class="ww-quantity"><input type="text" value="" name="new_goods['+countTr+'][]"></td><td class="ww-summ"><input type="text" value="" name="new_goods['+countTr+'][]"></td></tr>');
	});
	
	$('.ww-add_goods input, .ww-delivery_price input').live('change keyup', function( event ){
		summTr();
	});
	
$('.personal_price input').live('change keyup', function( event ){
	var trOb = $(this).closest("tr");

	if($(this).val()>0) {
	 	trOb.find(".ww-itog-item b").text(trOb.find(".ww-input-count input").val()*$(this).val());
	}
	else {
		trOb.find(".ww-itog-item b").text(trOb.find(".ww-input-count input").val()*trOb.find(".price input").val());
	}
	summTable();
//	subs();
});
	
	
	
	var dd = new DropDown( $('#ww-form_order .dd') );
	$(document).click(function() {
		// all dropdowns
		$('#ww-form_order .ww-rez_select').removeClass('active');
		//$('.ww-rez_select').toggleClass('active');
	});

/*
$(".fancy").fancybox({
	
		prevEffect		: 'fade',
		nextEffect		: 'fade'
});
*/
$('.fancy').on("click", function(){
			/*if( $( this ).attr("id") === 'prev_pict') {
				
				$('#prev_pict').attr("rel", "imgs");
				$( "#ww-catalog_item-detail_photos a" ).each(function() {
					if( $( this ).attr("id") !== 'img0') {
						$( this ).attr('rel', 'imgs');
					}
					else {
						$( "#img0" ).attr('rel', 'imges');
					}
				});
			}
			else 
			{
				$('#prev_pict').attr("rel", "imges");
				$( "#ww-catalog_item-detail_photos a" ).each(function() {
						$( this ).attr('rel', 'imgs');
				});
			}	*/
		})
		.fancybox({
			prevEffect	: 'none',
			nextEffect	: 'none',
			helpers	: {
				title	: {
					type: 'outside'
				},
				thumbs	: {
					width	: 68,
					height	: 48
				} 
			}
		});
	
	
 //$('.jcarousel').jcarousel();
$('.fancybox').fancybox();

	$(".various").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
	
$('#slider').nivoSlider({
	effect: 'fade',
	directionNav: true,
    controlNav: false,
    pauseTime: 6000,
    controlNavThumbs: false 
});
$('.jcarousel').jcarousel().jcarouselAutoscroll({
            interval: 2000,
            target: '+=1',
            autostart: true
        });

        $('.jcarousel-control-prev')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });

        $('.jcarousel-pagination')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .jcarouselPagination();
            
    //Default Action

	var tab = 'hid';
	$("ul.tabs li").each(function(){
		if($(this).children().hasClass("root-item-selected")) {
			$(this).addClass("active").show();
			tab = 'sho';
			var activeTab = $(this).find("a").attr("alt"); 
			$(activeTab).fadeIn();
			//$(this).show();
			return false;
		}
	});
	/*if(tab==='hid') {
			$("ul.tabs li:first").addClass("active").show(); //Activate first tab
			$(".tab_content:first").show(); //Show first tab content
	}*/
	
	if(tab==='hid') {
			$(".tab_content").hide(); //Hide all content
			$("ul.tabs li:first").addClass("active").show(); //Activate first tab
			$(".tab_content:first").show(); //Show first tab content
	}
	//On Click Event
	$("ul.tabs li").mouseover(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content
		var activeTab = $(this).find("a").attr("alt"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active content
		return false;
	});


$('#ww-form .ww-input-count a').live("click", function(){
	var ids = $(this).attr("class");
		if($(this).attr("id")==='up'){
			if(parseInt($(this).prev().val(),10)<7) {
					$(this).prev().val(parseInt($(this).prev().val(),10)+1);
				}
		}
		else if($(this).attr("id")==='down') {
			if(parseInt($(this).prev().prev().val(),10)>1){
					$(this).prev().prev().val(parseInt($(this).prev().prev().val(),10)-1);
				}
				else {
					$(this).prev().prev().val(1);
				}
		}
		
		var $form = $('#ww-form'),
	        form_url = $form.attr('#'),
	        $result = $('#ww-res_add'); 
	        
		var data = $form.serializeArray();       
	        data.push({'name': 'ajax_add', 'value': 'Y'});   
	        $.get(form_url, data, function(data) {
	            $result.html(data);
	        });
		
});

	
 $(".ww-pict-no").parent("div").next("div").children("#ww-filter_school").addClass("no-img");
 $('#ww-sub_bye').live('click', function(e) {
  
      var $form = $('#ww-form'),
        form_url = $form.attr('#'),
        $selects = $form.find('select, input:not([type=submit],[type=reset])'),
        $buttons = $form.find('input[type=submit], input[type=reset]'),
        $result = $('#ww-res'); 

       var cnt ='?';
       $(".item_cnt").each(function() {
       		cnt = cnt + $(this).attr("name")+"=1&";
       });
       
       var size ='';
       var num = 1;
       $(".item-size").each(function() {
       		size = size + "suz[" + num + "]=" +$(this).val() + "&";
       		num = num + 1;
       });
       
       var form_urls = cnt+size+"ajax_bt=Y"; 
    	var data = $form.serializeArray();
    	data.push({'name': 'actionADD2BASKET', 'value': 'Y'});        
        $.get(form_urls, data, function(data) {
            $result.html(data);
        });	
        
        var coopd=$("#ww-main_bascket").offset();
		$('#ww-form_order').animate({ 
	        opacity: 0,
	        left: coopd.left-620,
	        top: coopd.top-1180
	      }, 600).toggle(400);      
	   e.preventDefault();
          
    });

	$('#ww-in-bask').live('click', function() {
		$('#ww-form_order').css({
			left: "234px",
    		top: "-60px",
    		opacity: 1
  		});
		$('#ww-form_order').toggle(400);
	});
	$('#ww-chancel').live('click', function(e) {
		$('#ww-form_order').toggle(400);
	});
	

    $('#ww-order .ww-input-count a, #ww-order_new .ww-input-count a').live('click', function() {
    	var idclass = $(this).attr("class");
    	var id = $(this).attr("id");
		
		if(id==='up'){
			$('.ww-input-count input.cnt'+idclass).val(parseInt($('.ww-input-count input.cnt'+idclass).val(),10)+1);
			//	document.forms['basket_form'].submit();
    	}
    	else if(id==='down') {
    		if(parseInt($('.ww-input-count input.cnt'+idclass).val(),10)>1){
						$('.ww-input-count input.cnt'+idclass).val(parseInt($('.ww-input-count input.cnt'+idclass).val(),10)-1);
					}
					else {
						$('.ww-input-count input.cnt'+idclass).val(1);
					}
    	}
    	subs();
    	
    });
				    
    $('#ww-add-item').live('click', function() {
    	subs();
    });
    $('.delete-item').live("click", function(e) {
    	e.preventDefault();
    	subs($(this).attr("alt"));
    });
				    
	$('#ww-order .ww_tab_nav label, #ww-order_new .ww_tab_nav label').live("click", function() {
		var ids = $(this).parent().parent().attr("id");
		$('#'+ids+" label").each(function(){
			$(this).removeClass('ww-active'); 	
		});
		$(this).addClass('ww-active');
	});
				       

  $('#licenz input[type="radio"]').live("change", function () {
   	if ($(this).is(":checked"))
    	{
        	$('#ww-send').attr("disabled", false);
    		$('#ww-send').removeClass("ww-disabled");
    		$(this).parent().addClass('ww-active');
    	}
    	else
    	{
        	$('#ww-send').attr("disabled", true);
    	}
	});


/* CATALOG - FILTER */							

	$('#ww-filter_school label input').each(function() {
		if($(this).is(':checked')) {
			$(this).parent().addClass("select");
		}
	});
	
	$('#ww-filter_school label').click(function() {
		$('#ww-filter_school label').each(function() {
				$(this).removeClass("select");
				$(this).children().attr('checked',false);
		});
		$(this).addClass("select");
		$(this).children().attr('checked',true);
	});
	
//	$('#ww-filter_school').parent("#ww-section_area").css("padding-bottom", "70px");

  var $form = $('#ww-filter_school form'),
        form_url = $form.attr('action'),
        $selects = $form.find('select, input:not([type=submit],[type=reset])'),
        $buttons = $form.find('input[type=submit], input[type=reset]'),
        $label = $form.find('label'),
        $result = $('#ww-filter_result'),
        $blocks = $form.find('fieldset');
       
   		$selects.on('change', function() {
        	$form.trigger('submit_ajax');
     	}); 
  		
  		$label.on('click', function() {
        	$form.trigger('submit_ajax');
     	}); 
     	
  $form.on('submit_ajax', function() {
        var data = $form.serializeArray();
       
        data.push({'name': 'ajax', 'value': 'y'});
       
        $.get(form_url, data, function(data) {
            $result.html(data);    
        });
        return false; 
   });
/* CATALOG - FILTER - END */	
						
});

function subs(els){
	
	var $form = $('#basket_form'),
        form_url = $form.attr('#'),
        $selects = $form.find('.ww-input-count a'),
        $buttons = $form.find('input[type=submit]'),
        $result = $('#ww-bask'); 

	var datas = $form.serializeArray();
    	datas.push({'name': 'ajax_call', 'value': 'Y'});   
    	if(els>0) {
    	//alert(els);
    	datas.push({'name': 'del', 'value': els});   
    	}     
        $.get(form_url, datas, function(datas) {
            $result.html(datas);
        });

	//document.forms['basket_form'].submit();
}