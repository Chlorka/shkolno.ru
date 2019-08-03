<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript" src="/bitrix/js/main/ajax.js"></script>

<h2>Заказ:&nbsp;<?=$arResult['ORDER_ID'];?>, <?=ConvertDateTime($arResult['ORDER_DATE'], "DD.MM.YYYY", "ru");?> </h2>

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
<div class="ww-make_order"> 
		<div style="text-align: left;">	
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 0 !important;">
		<?foreach($arResult["DISPLAY_PROPERTIES"] as $r => $arProp):?>
			<?if($arProp["SORT"]==1500):?>
				<?if($r=='POSHIV'):?>
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
						<tr>
							<td colspan="2">
								<?=$arProp["INPUT"]?>
							</td>
						</tr>
				<?endif;?>
			<?endif;?>
		<?endforeach;?>
		</table>	
		</div>
	</div>
		<p class="ww-make-h_blue ">Основной заказ</p>
<?//r($arResult["ITEMS"]);?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" id="main-table">
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
						<tr class="item">
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
			  
			  <a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>"><img src="<?=$path;?>" alt="" /></a></td>
			  <td><?=$arItem['DISPLAY_PROP']['ARTICLE'];?></td>
			  <td class="ww-td-dott"><a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>"><?=$arItem["FIELDS"]["NAME"]?></a></td>
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
						<input type="hidden" name="SIZE[<?=$k?>]" value="<?=$numSize;?>">
				<?endif;?>
			  </td>
			  <td class="ww-td-dott">
			  	<span class="price"><?=$arItem["MIN_PRICE"]?>
			  	<input type="hidden" value="<?=$arItem["MIN_PRICE"]?>">
			  		 <span class="rubl">р.</span>
			  	</span>
			  			
			  			<span  class="personal_price">Спец. цена:<br>
			  			<input type="text" value="<?=$arItem["PERSONAL_PRICE"]?>" name="personal_price[<?=$k?>]" id="PERSONAL_<?=$k?>">
			  			</span>
			  </td>
			  <td class="ys-ibcount ww-td-dott">
					<div class="ww-input-count">  	
			  			<input type="text" name="count[<?=$k?>]" id="QUANTITY_<?=$k?>" value="<?=$arItem["COUNT"]?>" class="cntval<?=$k?>" />
						<a <?/*?>onclick="$('#order').attr('name', 'no_order'); $('#calculate').attr('name', 'calculate'); setQuantity('#QUANTITY_<?=$k?>', '+'); return false;"<?*/?> id="up" class="val<?=$k?>"><span></span></a> 
						<a <?/*?>onclick="$('#order').attr('name', 'no_order'); $('#calculate').attr('name', 'calculate'); setQuantity('#QUANTITY_<?=$k?>', '-'); return false;"<?*/?> id="down" class="val<?=$k?>"><span></span></a>
					</div>
			</td>
			  
			  <td class="ww-itog-item ww-td-dott">
			  	<b>
			  	<?if($arItem["PERSONAL_PRICE"]>0) 
			  			echo $arItem["COUNT"]*$arItem["PERSONAL_PRICE"];
			  		else
						echo $arItem["COUNT"]*$arItem["MIN_PRICE"];
			  		?> 
			  	</b>	
			  		<span class="rubl">р.</span>
			  	<div>
			  		<?$link='/account/orders/detail/?ORDER='.$_REQUEST["ORDER"].'&del[]='.$k;?>
				<a alt="<?=$k;?>" href="<?=$link;?>" class="ww-del-item delete-item">Удалить<br>из корзины</a>  	
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
				<td colspan="3" class="ww-all-add"><input type="text" value="" placeholder="Введите артикул" name="articleNew"><a href="javascript:void(0)" id="ww-add-item">Добавить товар</a>
				</td>
				<td colspan="4" class="ww-all-sum"><span>Всего товаров <?=$cntitem;?> на сумму <?=$arResult["COMMON_PRICE"]?>р.</span>
					<input type="hidden" name="items_all_summ" id="items_all_summ" value="<?=$arResult["COMMON_PRICE"]?>">
				</td>
			</tr>
		</table>

					<div class="ww-make_order"> 

		<div style="text-align: left;">	
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<?$index = 0;?>	
		<?foreach($arResult["DISPLAY_PROPERTIES"] as $r => $arProp):?>
			<?if($r=='ADD_GOODS' && $arProp["SORT"]<4000):?>
				<tr>
					<th colspan="2">
						<div class="ww-make-h">
							<?=$arProp["NAME"];?>
						</div>
					</th>
				</tr>
				<tr>
					<td colspan="2">
						<div class="ww-add_goods">
							<table border="1" cellpadding="0" cellspacing="0" id="add_dop">
								<thead>
									<tr>
										<th>
											№<br>
											п/п
										</th>
										<th>
											Артикул
										</th>
										<th>
											Наименование
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
											Сумма
										</th>
									</tr>
								</thead>
								<tbody>
									<?if(count($arProp["MULTIPLE_VALUE"])>0) {?>
										
									<?
									$all_cnt = 0;
									$all_sum = 0;
									foreach($arProp["MULTIPLE_VALUE"] as $pid=>$cell) {
										$value = explode(";", $cell);
										?>
										<tr>
											<td class="ww-num">
												<?=$pid+1;?>
												<input name="new_goods[<?=$pid+1;?>][]" type="hidden" value="<?=$value[0]?>">
											</td>
											<td class="ww-article">
												<input name="new_goods[<?=$pid+1;?>][]" type="text" value="<?=$value[1]?>">
											</td>
											<td class="ww-name">
												<input name="new_goods[<?=$pid+1;?>][]" type="text" value="<?=$value[2]?>">
											</td>
											<td class="ww-size">
												<input name="new_goods[<?=$pid+1;?>][]" type="text" value="<?=$value[3]?>">
											</td>
											<td class="ww-price">
												<input name="new_goods[<?=$pid+1;?>][]" type="text" value="<?=$value[4]?>">
											</td>
											<td class="ww-quantity">
												<input name="new_goods[<?=$pid+1;?>][]" type="text" value="<?=$value[5]?>">
												<?$all_cnt = $all_cnt + $value[5];?>
											</td>
											<td class="ww-summ">
												<input name="new_goods[<?=$pid+1;?>][]" type="text" value="<?=$value[6]?>">
												<?$all_sum = $all_sum + $value[6];?>
											</td>
										</tr>
										<?}?>
									<?}
									else {?>
									<?for($cell=1; $cell<=3; $cell++) {?>
									<tr>
										<td class="ww-num">
											<?=$cell;?>
											<input name="new_goods[<?=$cell;?>][]" type="hidden" value="<?=$cell;?>">
										</td>
										<td class="ww-article">
											<input name="new_goods[<?=$cell;?>][]" type="text" value="">
										</td>
										<td class="ww-name">
											<input name="new_goods[<?=$cell;?>][]" type="text" value="">
										</td>
										<td class="ww-size">
											<input name="new_goods[<?=$cell;?>][]" type="text" value="">
										</td>
										<td class="ww-price">
											<input name="new_goods[<?=$cell;?>][]" type="text" value="">
										</td>
										<td class="ww-quantity">
											<input name="new_goods[<?=$cell;?>][]" type="text" value="">
										</td>
										<td class="ww-summ">
											<input name="new_goods[<?=$cell;?>][]" type="text" value="">
										</td>
									</tr>
										<?}?>
									<?}?>
								</tbody>
								<tfoot>
								</tfoot>
							</table>
							
							<a href="javascript:void(0)" id="add_cell">Добавить строчку</a>
							<p class="ww-cell_itog">
								Итого дополнительных товаров <?=$all_cnt;?> на сумму <?=$all_sum;?> р.
							</p>
							<input type="hidden" name="add_all_summ" id="add_all_summ" value="<?=$all_sum;?>">
						</div>
					</td>
				</tr>
			<?elseif($arProp["SORT"]>=4000 && $arProp["SORT"]<5000):?>
				<?if($r=='FIO'):?>	
				<tr>
					<th colspan="2">
						<div class="ww-make-h">
							Личные данные
						</div>
					</th>
				</tr>
				<?endif;?>
				<?$index++;?>
					<?if($index%2!=0):?>
						<tr>
					<?endif;?>
						<td class="ww-td_2col">
							<span><?=$arProp["NAME"]?>:</span><?=$arProp["INPUT"]?>
						</td>
					<?if($index%2==0):?>
						</tr>
					<?endif;?>
			<?elseif($arProp["SORT"]>=5000 && $arProp["SORT"]<6000):?>
				<?if($r=='DELIVERY_E'):?>	
				<tr>
					<th colspan="2">
						<div class="ww-make-h">
							Доставка
						</div>
					</th>
				</tr>
				<?endif;?>
				<?//if($n_line > 0) echo '<br/><br/>';
					$n_line ++ ;
					//r( $arProp["INPUT"]);
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
				
					<?if($r=="DELIVERY_PRICE"):?>
						<tr>
							<td colspan="2" class="ww-delivery_price ww-make-name">
								<span><?=$arProp["NAME"]?>:</span><?=$arProp["INPUT"]?>
								
							</td>
						</tr>
						<tr>
							<td colspan="2" class="ww-orange_td">
								<span>Итого заказ на сумму: <?=$arResult["COMMON_PRICE"]+$all_sum+$arProp["VALUE"];?> руб.</span>
								<input type="hidden" id="all_order_price" name="all_order_price" value="<?=$arResult["COMMON_PRICE"]+$all_sum+$arProp["VALUE"];?>">
							</td>
						</tr>
						
					<?else:?>
						<tr>
							<td colspan="2" class="ww-make-name">
								<?if($r=="ABOUT"):?>
									<div style="padding: 0 0 10px 30px;">Адрес доставки:</div>
								<?else:?>
								<?endif;?>
								<?=$arProp["INPUT"]?>
							<?//r($arProp);?>
							</td>
						</tr>
					<?endif;?>
				
				
				<?elseif($arProp["SORT"]==6000):?>
					<?if($r=='PAYMENT_E'):?>
					<tr>
						<th colspan="2">
							<div class="ww-make-h">
								Оплата
							</div>
						</th>
					</tr>
					<?endif;?>
					<?
					$n_line ++;
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
					<tr>
						<td colspan="2">
							<?=$arProp["INPUT"]?>
						</td>
					</tr>				
				<?elseif($arProp["SORT"]>=6100 && $arProp["SORT"]<7000):?>
					<?if($r=='PAY_STATYS'):?>
						<tr>
							<th colspan="2">
								<div class="ww-make-h">
									Статус оплаты
								</div>
							</th>
						</tr>
					
					<?
					$n_line ++;
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
					<tr>
						<td colspan="2">
							<?=$arProp["INPUT"]?>
						</td>
					</tr>
					<?elseif($r=='OPLATA'):?>
					<tr>
						<td colspan="2">
							<div class="ww-add_pay">
							<table border="1" cellpadding="0" cellspacing="0">
								<thead>
									<tr>
										<th>
											
										</th>
										<th>
											Аванс
										</th>
										<th>
											К доплате
										</th>
										<th>
											Окончательный расчет
										</th>
									</tr>
								</thead>
									<?/*foreach($arProp["MULTIPLE_VALUE"] as $pid=>$cell) {
										$value_price = explode(";", $arProp["MULTIPLE_VALUE"][0]);
										?>
									<?}*/
									$value_price = explode(";", $arProp["MULTIPLE_VALUE"][0]);
									$value_date = explode(";", $arProp["MULTIPLE_VALUE"][1]);?>
								<tbody>
									<tr>
										<td class="ww-first">
											Сумма, руб.
										</td>
										<td class="ww-name">
											<input name="new_price[1]" type="text" value="<?=$value_price[0]?>">
										</td>
										<td class="ww-size">
											<input name="new_price[2]" type="text" value="<?=$value_price[1]?>">
										</td>
										<td class="ww-price">
											<input name="new_price[3]" type="text" value="<?=$value_price[2]?>">
										</td>
									</tr>
									<tr>
										<td class="ww-first">
											Дата
										</td>
										<td class="ww-name">
											<input name="new_date[1]" type="text" value="<?=$value_date[0]?>">
										</td>
										<td class="ww-size">
											<input name="new_date[2]" type="text" value="<?=$value_date[1]?>">
										</td>
										<td class="ww-price">
											<input name="new_date[3]" type="text" value="<?=$value_date[2]?>">
										</td>
									</tr>
								</tbody>
								<tfoot>
								</tfoot>
							</table>
						</div>
						</td>
					</tr>
					<?endif;?>
					
				<?elseif($arProp["SORT"]>=7000 && $arProp["SORT"]<8000):?>	
					<?if($r=='STATUS'):?>
						<tr>
							<th colspan="2">
								<div class="ww-make-h">
									Дополнительная информация о заказе
								</div>
							</th>
						</tr>
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
					<tr>
						<td colspan="2" class="ww-make-name">
							<?if($r=='STATUS'):?>
							<?else:?>
								<div style="width: 300px; float: left;"><?=$arProp["NAME"];?>:</div>
							<?endif;?>
							<?=$arProp["INPUT"]?>
						</td>
					</tr>
										
				<?/*else:?>
				<tr>
					<th colspan="2">
						<div class="ww-make-h">
							<?=$arProp["NAME"];?>
						</div>
					</th>
				</tr>
				<tr>
					<td colspan="2">
						<?//r($arProp);?>
					</td>
				</tr>
			<?*/endif;?>
		<?endforeach;?>	
		</table>	
			
		<br/><b>*</b><span class="req_message"><?=GetMessage('REQUIRED');?></span>
		</div>
<p style="text-align: center;">
	<?/*?><input type="hidden" name="ajax_call" value="Y"><?*/?>
	<input type="submit" value="Сохранить" name="update" id="ww-send">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?if(strlen($_REQUEST["PROPERTY"]["EMAIL"])>0) {
		$user_mail = $_REQUEST["PROPERTY"]["EMAIL"];
	}
	else {
		$user_mail = $arResult["DISPLAY_PROPERTIES"]["EMAIL"]["VALUE"];
	}
	?>
	<a href="/account/orders/detail_user/?ORDER=<?=$_REQUEST['ORDER']?>&print=Y" class="ww-button"  target="_blank" >Печать</a>
	<?/*?>
	<a href="/account/orders/send_user/?ORDER=<?=$_REQUEST['ORDER']?>&print=Y" onclick="jsAjaxUtil.InsertDataToNode('/account/orders/send_user/?ORDER=<?=$_REQUEST[ORDER];?>&print=Y&MAIL=<?=$user_mail;?>&ajax_call=Y','ww-send_yes', true); return false;" class="ww-button"  target="_blank" >Отправить клиенту</a>
	
	<div id="ww-send_yes" style="text-align: center; color: green; font-weight: bold;"></div>
	<?*/?>
	
</p>
<p style="text-align: center;">
	<?/*?><a href="/account/orders/detail/?ORDER=<?=$_REQUEST['ORDER']?>&print=Y" class="ww-button"  target="_blank" >Печать для производства</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?*/?>
	<?/*?><a href="/account/orders/detail_user/?ORDER=<?=$_REQUEST['ORDER']?>&print=Y" class="ww-button"  target="_blank" >Печать</a><?*/?>
	<?/*?>
	<input type="submit" value="Печать для клиента" name="printuser">
	<?*/?>
</p>
	</form> 
								  <!--.make_order-->
<?else:?>
<?=GetMessage("YENISITE_BASKET_EMPTY")?>
<?endif;?>
                 
                </div><!--.user_basket-->
<?//r($arResult[ITEMS]);?>
