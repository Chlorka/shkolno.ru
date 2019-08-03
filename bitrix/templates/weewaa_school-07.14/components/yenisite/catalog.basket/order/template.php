<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if($arParams["COLOR_SCHEME"] == "green")
	$GLOBALS["APPLICATION"]->SetAdditionalCSS(str_replace($_SERVER["DOCUMENT_ROOT"], "", dirname(__FILE__)."/green.css"));
elseif($arParams["COLOR_SCHEME"] == "blue")
	$GLOBALS["APPLICATION"]->SetAdditionalCSS(str_replace($_SERVER["DOCUMENT_ROOT"], "", dirname(__FILE__)."/blue.css"));
elseif($arParams["COLOR_SCHEME"] == "yellow")
	$GLOBALS["APPLICATION"]->SetAdditionalCSS(str_replace($_SERVER["DOCUMENT_ROOT"], "", dirname(__FILE__)."/yellow.css"));
elseif($arParams["COLOR_SCHEME"] == "metal")
	$GLOBALS["APPLICATION"]->SetAdditionalCSS(str_replace($_SERVER["DOCUMENT_ROOT"], "", dirname(__FILE__)."/metal.css"));
elseif($arParams["COLOR_SCHEME"] == "pink")
	$GLOBALS["APPLICATION"]->SetAdditionalCSS(str_replace($_SERVER["DOCUMENT_ROOT"], "", dirname(__FILE__)."/pink.css"));
else{	
	$cs = COption::GetOptionString("yenisite.market", "color_scheme")=="ice"?"blue":COption::GetOptionString("yenisite.market", "color_scheme");
	if($cs && !$arParams["COLOR_SCHEME"] )
		$GLOBALS["APPLICATION"]->SetAdditionalCSS(str_replace($_SERVER["DOCUMENT_ROOT"], "", dirname(__FILE__)."/".$cs.".css"));
	else
		$GLOBALS["APPLICATION"]->SetAdditionalCSS(str_replace($_SERVER["DOCUMENT_ROOT"], "", dirname(__FILE__)."/red.css"));
}

?>
<h2>Ваш заказ</h2>
<div style='color: red;'>
<? if(count($arResult['ERROR']) > 0) foreach($arResult['ERROR'] as $err) echo GetMessage("ERROR").$err.'<br/>'; ?>
<br/>
</div>

	<div class="ys-user-basket" id="ww-order_new">

<?if(isset($arResult["ITEMS"])):?> 
<?$resizer = CModule::IncludeModule('yenisite.resizer2');?>	 
<form id="basket_form"
	method="POST" enctype="multipart/form-data"
	action=""
	onsubmit="return MyFormCheck() && jsAjaxUtil.InsertFormDataToNode(this, 'ww-bask', true);"
>
<input type="hidden" name="calculate_no" id="calculate"  value="Y" />
<input type="hidden" name="order_no" id="order" value="<?=GetMessage("ORDER");?>" />
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<th class="ww-basket_photo">
						Фото
					</th>
					<th>
						Артикул
					</th>
					<th>
						Название
					</th>
					<th>
						Размер
					</th>
					<th>
						Цена
					</th>
					<th>
						Количество
					</th>
					<th>
						Итог
					</th>
				</tr>
		<?$cntitem=0;?>		
       <?foreach($arResult["ITEMS"] as $k=>$arItem):?>
						<tr>
			  <td class="ww-basket_photo">
			 <input type="hidden" class="no_del" name="no_del[]" id="del_<?=$k?>" value="<?=$arItem["KEY"]?>" />
			 <? 
				$photo = CIBlockElement::GetProperty($arItem["FIELDS"]["IBLOCK_ID"], $arItem["FIELDS"]["ID"], array("sort" => "asc"), Array("CODE"=>"MORE_PHOTO"))->Fetch(); 
				$path = CFile::GetPath($photo["VALUE"]);
				$pathid = $photo["VALUE"];

				if(!$path){
					$path = CFile::GetPath($arItem["FIELDS"]["PREVIEW_PICTURE"]);
					$pathid = $arItem["FIELDS"]["PREVIEW_PICTURE"];
					
				}
				if($resizer)
					$path = CResizer2Resize::ResizeGD2($path, $arParams["BASKET_PHOTO"]?$arParams["BASKET_PHOTO"]:5);
				else{
					$ResizeParams = array('width' => 90, 'height' => 135);
					$path = CFile::ResizeImageGet($pathid, $ResizeParams,  BX_RESIZE_IMAGE_PROPORTIONAL, true);
					$path = $path['src'];
				}
				
			 ?>
			  <a class="fancybox" href="<?=CFile::GetPath($arItem["FIELDS"]["DETAIL_PICTURE"])?>"><img src="<?=$path;?>" alt="" /></a></td>
			  <td class="ww-item-article"><?=$arItem['DISPLAY_PROP']['ARTICLE'];?></td>
			  <td class="ww-td-dott ww-item-name"><a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>"><?=$arItem["FIELDS"]["NAME"]?></a></td>
			  <td class="ww-td-dott ww-td-size">
			  	<?//r($arItem);?>
			  	<?if(count($arItem['DISPLAY_PROP']['SIZE'])>0):?>
<?/*?><div style="position: relative;">			  	
<div class="ww-ul-size"> 
<span class="h3_arr_bg"><?if(strlen($arItem['PROPERTIES']['SIZE']['VALUE'])>0) echo $arItem['PROPERTIES']['SIZE']['VALUE']; else '(размеры)';?><span class="expand">+</span></span>
<ul>
<?foreach($arItem['DISPLAY_PROP']['SIZE'] as $l=>$val) {?>
	<li><label><input type="radio" <?if($val==$arItem['PROPERTIES']['SIZE']['VALUE']):?>checked="checked"<?endif;?> value="<?=$l;?>" name="prop[SIZE]" alt="<?=$val;?>"><?=$val;?></label></li>
<?}?>
</ul>
</div>
</div><?*/?>

						<div class="ww-ul-size" id="size<?=$k?>">
							<span class="arr_bg"></span>
							<span class="text_head"><?if(strlen($arItem['PROPERTIES']['SIZE']['VALUE'])>0) echo $arItem['PROPERTIES']['SIZE']['VALUE']; else '(размеры)';?></span>
							<ul class="dropdown no-show">
							<?foreach($arItem['DISPLAY_PROP']['SIZE'] as $l=>$val) {?>
								<li><label><input type="radio" <?if($val==$arItem['PROPERTIES']['SIZE']['VALUE']): $numSize=$l;?>checked="checked"<?endif;?> value="<?=$l;?>" name="prop[SIZE]" alt="<?=$val;?>"><?=$val;?></label></li>
							<?}?>
							</ul>
						</div>
			  <?/*?>	<div tabindex="1" class="ww-rez_select dd" id="dd<?=$k?>">
							<span class="arr_bg"></span>
							<span class="text_head"><?if(strlen($arItem['PROPERTIES']['SIZE']['VALUE'])>0) echo $arItem['PROPERTIES']['SIZE']['VALUE']; else '(размеры)';?></span>
							<ul class="dropdown">
							<?foreach($arItem['DISPLAY_PROP']['SIZE'] as $l=>$val) {?>
								<li><label><input type="radio" <?if($val==$arItem['PROPERTIES']['SIZE']['VALUE']):?>checked="checked"<?endif;?> value="<?=$l;?>" name="prop[SIZE]" alt="<?=$val;?>"><?=$val;?></label></li>
							<?}?>
							</ul>
						</div>
					<?*/?>	<?//r($arItem);?>
						<input type="hidden" name="SIZE[<?=$arItem["KEY"]?>]" value="<?=$numSize;?>">
				<?endif;?>
			  </td>
			  <td class="ww-td-dott ww-item-price"><span class="price"><?=$arItem["MIN_PRICE"]?> <span class="rubl">р.</span></span></td>
			  <td class="ys-ibcount ww-td-dott">
					<div class="ww-input-count">  	
			  			<input type="text" name="count[<?=$arItem["KEY"]?>]" id="QUANTITY_<?=$k?>" value="<?=$arItem["COUNT"]?>" class="cntval<?=$k?>" />
						<a <?/*?>onclick="$('#order').attr('name', 'no_order'); $('#calculate').attr('name', 'calculate'); setQuantity('#QUANTITY_<?=$k?>', '+'); return false;"<?*/?> id="up" class="val<?=$k?>"><span></span></a> 
						<a <?/*?>onclick="$('#order').attr('name', 'no_order'); $('#calculate').attr('name', 'calculate'); setQuantity('#QUANTITY_<?=$k?>', '-'); return false;"<?*/?> id="down" class="val<?=$k?>"><span></span></a>
					</div>
			</td>
			  
			  <td class="ww-itog-item ww-td-dott">
			  	<?=$arItem["COUNT"]*$arItem["MIN_PRICE"];?> <span class="rubl">р.</span>
			  	<div>
			  		<?$link='?del[]='.$arItem["KEY"].'&ajax_call=Y';?>
				<a onclick="jsAjaxUtil.InsertDataToNode('<?=$link;?>', 'ww-bask', true); return false;" <?/*?>onclick="$('#order').attr('name', 'no_order'); $('#calculate').attr('name', 'calculate'); $('#del_<?=$k?>').attr('name', 'del[]');" <?*/?> href="?del[]=<?=$arItem["KEY"]?>" class="ww-del-item">Удалить<br>из корзины</a>  	
			  	</div>
			  </td>
			</tr>
			<tr>
			<td colspan="7" class="ww-link-hr">
			  	<hr>
			  </td>
			</tr>
			<?$cntitem=$cntitem+$arItem["COUNT"];?>
			<?endforeach;?>
			<tr>
				<td colspan="2" class="ww-all-dell"><a href="?del_all=Y" onclick="jsAjaxUtil.InsertDataToNode('?del_all=Y&ajax_call=Y',
'ww-bask', true); return false;">Очистить корзину</a></td>
				<td colspan="5" class="ww-all-sum"><span>Всего товаров <?=$cntitem;?> на сумму <?=$arResult["COMMON_PRICE"]?>р.</span></td>
			</tr>
		</table>

					<div class="ww-make_order"> 
<h2>Оформление заказа</h2>				
<p class="ww-make_text">
Ориентировочный срок готовности товара - 2 недели с момента размещения заказа. О готовности товара мы Вас
проинформируем по указанному Вами телефону и электронному адресу. Самостоятельно о готовности Вы можете
узнать по телефонам: 8 (391) 278-82-10</p>	

		<div style="text-align: left;">	
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <?
		$n_line = 0 ;
		foreach($arResult["DISPLAY_PROPERTIES"] as $r => $arProp):?>
			<?if($r=='FIO'):
				$index = 0;
			?>
			<tr>
				<th colspan="2">
					<div class="ww-make-h">
						Личные данные
					</div>
				</th>
			</tr>
			<?elseif($r=='PAYMENT_E'):?>
			<tr>
				<th colspan="2">
					<div class="ww-make-h">
						Оплата
					</div>
				</th>
			</tr>
			<?/*?><tr>
				<td colspan="2" class="ww-make-footer">
					Размещение заказа физическим лицом происходит при 100% предоплате стоимости заказа.
				</td>
			</tr>
			 <?*/?>
			<?elseif($r=='DELIVERY_E'):?>
			<tr>
				<th colspan="2">
					<div class="ww-make-h">
						Доставка
					</div>
				</th>
			</tr>
			<?endif;?>
			 
			 <?if($arProp["SORT"]>=4000 && $arProp["SORT"]<5000):?>
				<?$index++;?>
					<?if($index%2!=0):?>
						<tr>
					<?endif;?>
						<td class="ww-td_2col ww-make-name">
							<span><?=$arProp["NAME"]?>:</span><?=$arProp["INPUT"]?>	
						</td>
					<?if($index%2==0):?>
						</tr>
					<?endif;?>
			<?endif;?>
			        
			<?//if($n_line > 0) echo '<br/><br/>';
			$n_line ++ ;
			if(substr_count($arProp["INPUT"], "radio") > 0){
				$arr = explode("<br/>", $arProp["INPUT"]);?>
				<?foreach($arr as $k=>&$ar){
					if($ar){
						if(substr_count($ar, "checked") > 0)
							$ar = '<li><label class="ww-active" class="">&nbsp;&nbsp;&nbsp&nbsp;&nbsp'.$ar.'</label></li>';					
						else
							$ar = '<li><label class="" >&nbsp;&nbsp;&nbsp&nbsp;&nbsp'.$ar.'</label></li>';					
					}
				}

				
				$arProp["INPUT"] = '<ul class="ww_tab_nav" id="'.$r.'">'.implode(" ", $arr)."</ul>";
			}
		?>
				<?
					if(substr_count($arProp["INPUT"], 'text')) $arProp["INPUT"] = str_replace("<input ", "<input class='ww-text' ", $arProp["INPUT"]) ;
				?>
			<?if($r=='DELIVERY_E' || $r=='PAYMENT_E'):?>
            	<tr>
            		<td colspan="2"> 
                		<?=$arProp["INPUT"]?>
                	</td>
                </tr>
            <?elseif($r=='ABOUT'):?>
            	<tr>
	            	<td colspan="2" class="ww-make-about"> 
	            		<span>Точный адрес доставки. Дополнительные пожелания по условиям доставки:</span>
	                	<textarea class="ww-basket_text" name="PROPERTY[ABOUT]" placeholder="<?=$arProp['DEFAULT_VALUE']['TEXT']?>"></textarea>
	                </td>
                </tr>
                <tr>	
           		<td colspan="2" class="ww-post-text">
           			<?$APPLICATION->IncludeFile(SITE_DIR . ".inc/post.php", array(), array("MODE"=>"html"));?>
           		</td>
           		</tr>
              <?elseif($r=='COUNT'):?>
            	<tr>
	            	<td colspan="2" class="ww-make-about"> 
	            		<input type="hidden" value="<?=$cntitem;?>" name="PROPERTY[COUNT]">
	            	</td>
	            </tr>
             <?else:?>
		
		
            <?/*?> <td class="ww-make-name">
                	<?=$arProp["NAME"]?> <?if($arProp['IS_REQUIRED'] == "Y"):?>*<?endif?>: 
                </td>
                <td> 
                	<?=$arProp["INPUT"]?>
                </td>
			 <?*/?>
            <?endif;?>
           
           <?if($r=='DELIVERY_E'):?>

           <?endif;?>
        <?endforeach?>
        <tr>
        	<td colspan="2">
        	<ul class="ww_tab_nav ww-licenz" id="licenz">
			<li>
				<label>
					<input type="radio" placeholder="" value="Y" name="LICENZ">
				</label>	<a href="#licenz_block" class="various">Я принимаю условия Пользовательского соглашения</a>
				
				<span>Для оформления заказа необходимо принять условия пользовательского соглашения</span>
			</li>
			
		</ul>
		</td>
        </tr>
		</table>
		<br/><?/*?><b>*</b><span class="req_message"><?=GetMessage('REQUIRED');?></span><?*/?>
		</div>
<p style="text-align: center;">
	<?/*?><input type="hidden" name="ajax_call" value="Y"><?*/?>
	<input type="submit" value="Отправить!" name="order" disabled="disabled" class="ww-disabled" id="ww-send"></div>
</p>
	</form>					
								  <!--.make_order-->
								  <div id="licenz_block" style="display:none;"><?$APPLICATION->IncludeFile(SITE_DIR . ".inc/licenziya.php", array(), array("MODE"=>"html"));?></div>
<?else:?>
<?=GetMessage("YENISITE_BASKET_EMPTY")?>
<?endif;?>
                 
                </div><!--.user_basket-->
