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
function print_text(){
	$(".ww-print_a").css("display", "none");
	print();
}

$(function() {
	
	$(".btnPrint").printPage();
	$(".ww-print_a").live("click", function(){
		print_text();
	});

	$("#ww-order ul.dropdown").each(function(){
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
					subs();
				});
				//$(this).next().next().css("display","block");
			});
			

	var dd = new DropDown( $('#ww-form_order .dd') );
	$(document).click(function() {
		// all dropdowns
		$('#ww-form_order .ww-rez_select').removeClass('active');
		//$('.ww-rez_select').toggleClass('active');
	});


$(".fancy").fancybox({
	
		prevEffect		: 'fade',
		nextEffect		: 'fade'
});


 //$('.jcarousel').jcarousel();
 

$('#slider').nivoSlider({
	effect: 'random',
	directionNav: true,
    controlNav: false,
    pauseTime: 10000,
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
			var activeTab = $(this).find("a").attr("href"); 
			$(activeTab).fadeIn();
			//$(this).show();
			return false;
		}
	});
	
	if(tab==='hid') {
			$(".tab_content").hide(); //Hide all content
			$("ul.tabs li:first").addClass("active").show(); //Activate first tab
			$(".tab_content:first").show(); //Show first tab content
	}
	//On Click Event
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content
		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active content
		return false;
	});

		$('#ww-form_order #up').live("click", function(){
			var ids = $(this).attr("class");
				$('.ww-input-count input.cnt'+ids).val(parseInt($('.ww-input-count input.cnt'+ids).val(),10)+1);
			});
		$('#ww-form_order #down').live("click", function(){
			var ids = $(this).attr("class");
				if(parseInt($('.ww-input-count input.cnt'+ids).val(),10)>1){
					$('.ww-input-count input.cnt'+ids).val(parseInt($('.ww-input-count input.cnt'+ids).val(),10)-1);
				}
				else {
					$('.ww-input-count input.cnt'+ids).val(1);
				}
		});

 
    var $form = $('#ww-form'),
        form_url = $form.attr('#'),
        $selects = $form.find('select, input:not([type=submit],[type=reset])'),
        $buttons = $form.find('input[type=submit], input[type=reset]'),
        $result = $('#ww-res'); 

    
    $form.find('input[type=submit]').on('click', function(e) {
    	var data = $form.serializeArray();       
        $.get(form_url, data, function(data) {
            $result.html(data);
        });	 
       // $('#ww-form_order').toggle(400);
       
        var coopd=$("#ww-main_bascket").offset();
 		//alert(coopd.top);
 		//alert(coopd.left);
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
	

				    $('#ww-order .ww-input-count a').live('click', function() {
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
				    
				    	$('#ww-order .ww_tab_nav label').live("click", function() {
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
						
});

function subs(){
	
	var $form = $('#basket_form'),
				        form_url = $form.attr('#'),
				        $selects = $form.find('.ww-input-count a'),
				        $buttons = $form.find('input[type=submit]'),
				        $result = $('#ww-bask'); 
				
    
					var datas = $form.serializeArray();
				    	datas.push({'name': 'ajax_call', 'value': 'Y'});        
				        $.get(form_url, datas, function(datas) {
				            $result.html(datas);
				        });

	//document.forms['basket_form'].submit();
}