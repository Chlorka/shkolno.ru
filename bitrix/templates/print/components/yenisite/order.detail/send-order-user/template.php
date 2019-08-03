<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<h2 style="color: #282828;
    font-family: 'cyrthin';
    font-size: 32px;
    font-weight: normal;
    margin: 10px 0 22px;
    text-align: center;
    text-transform: uppercase;">ЗАКАЗ № <?=$_REQUEST["ORDER"]?></h2>
<?//r($arResult);?>
<div style='color: red;'>
<? if(count($arResult['ERROR']) > 0) foreach($arResult['ERROR'] as $err) echo GetMessage("ERROR").$err.'<br/>'; ?>
<br/>
</div>

	<div class="ys-user-basket" id="ww-order">

<?if(isset($arResult["ITEMS"])):?> 
<?$resizer = CModule::IncludeModule('yenisite.resizer2');?>	 
<form id="basket_form"
	method="POST" enctype="multipart/form-data"
	action="">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border: medium none; font-family: Helvetica; width: 100%;">
				<tr>
					<th class="ww-basket_photo" style="background: none repeat scroll 0 0 #ededed; font-family: Arial; font-size: 15px; padding: 8px 0; padding-left: 35px; padding-right: 0 !important; text-align: center; width: 115px;">
						Фото
					</th>
					<th style="background: none repeat scroll 0 0 #ededed; font-family: Arial; font-size: 15px; padding: 8px 0;">
						Артикул
					</th>
					<th style="background: none repeat scroll 0 0 #ededed; font-family: Arial; font-size: 15px; padding: 8px 0;">
						Название
					</th>
					<th style="background: none repeat scroll 0 0 #ededed; font-family: Arial; font-size: 15px; padding: 8px 0;">
						Размер
					</th>
					<th style="background: none repeat scroll 0 0 #ededed; font-family: Arial; font-size: 15px; padding: 8px 0;">
						Цена
					</th>
					<th style="background: none repeat scroll 0 0 #ededed; font-family: Arial; font-size: 15px; padding: 8px 0;">
						Количество
					</th>
					<th style="background: none repeat scroll 0 0 #ededed; font-family: Arial; font-size: 15px; padding: 8px 0;">
						Итог
					</th>
				</tr>
		<?$cntitem=0;?>		
       <?foreach($arResult["ITEMS"] as $k=>$arItem):?>
						<tr>
			  <td class="ww-basket_photo" style=" font-size: 16px; padding: 35px 15px 0 !important; text-align: center; vertical-align: middle; padding-left: 35px; padding-right: 0 !important; text-align: center; width: 115px;">
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
				$path='http://shool.wwall.tmweb.ru'.$path;
			 ?>
			  
			  <a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>" style="display: block; width:90px; height: 140px; background: url(<?=$path;?>) left top no-repeat;"></a></td>
			  <td style=" font-size: 16px; padding: 35px 15px 0 !important; text-align: center; vertical-align: middle;"><?=$arItem['DISPLAY_PROP']['ARTICLE'];?></td>
			  <td class="ww-td-dott" style=" font-size: 16px; padding: 35px 15px 0 !important; text-align: center; vertical-align: middle;"><a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>"><?=$arItem["FIELDS"]["NAME"]?></a></td>
			  <td class="ww-td-dott ww-td-size" style=" font-size: 16px; padding: 35px 15px 0 !important; text-align: center; vertical-align: middle; width: 128px;">
			  	<?//r($arItem);?>
			  	<?if(count($arItem['DISPLAY_PROP']['SIZE'])>0):?>
						<div class="ww-ul-size" id="size<?=$k?>">
							<span class="text_head"><?if(strlen($arItem['PROPERTIES']['SIZE']['VALUE'])>0) echo $arItem['PROPERTIES']['SIZE']['VALUE']; else '(размеры)';?></span>
						</div>
						<input type="hidden" name="SIZE[<?=$arItem["KEY"]?>]" value="<?=$numSize;?>">
				<?endif;?>
			  </td>
			  <td class="ww-td-dott" style=" font-size: 16px; padding: 35px 15px 0 !important; text-align: center; vertical-align: middle;"><span class="price"><?=$arItem["MIN_PRICE"]?> <span class="rubl">р.</span></span></td>
			  <td class="ys-ibcount ww-td-dott" style=" font-size: 16px; padding: 35px 15px 0 !important; text-align: center; vertical-align: middle;">
					<div class="ww-input-count" style="height: 35px; position: relative; text-align: left; width: 100px;">  	
			  			<input type="text" name="count[<?=$arItem["KEY"]?>]" id="QUANTITY_<?=$k?>" value="<?=$arItem["COUNT"]?>" class="cntval<?=$k?>" style="background: none repeat scroll 0 0 #fff; border: 1px solid #bababa; color: #fe8d03; font-size: 22px !important; font-weight: bold; line-height: 16px !important; margin-top: 5px; padding: 0 3px; text-align: center; width: 58px;" />
					</div>
			</td>
			  
			  <td class="ww-itog-item ww-td-dott" style=" font-size: 16px; padding: 35px 15px 0 !important; text-align: center; vertical-align: middle; font-size: 25px; font-weight: bold; position: relative; width: 110px;">
			  	<?=$arItem["COUNT"]*$arItem["MIN_PRICE"];?> <span class="rubl">р.</span>
			  </td>
			</tr>
			<tr>
			<td colspan="7" class="ww-link-hr" style=" font-size: 16px; padding: 35px 15px 0 !important; text-align: center; vertical-align: middle; padding: 0 !important;  text-align: center;">
			  	<hr style=" display: block; height: 1px; margin: 0 auto; position: relative; top: 16px; width: 705px;">
			  </td>
			</tr>
			<?$cntitem=$cntitem+$arItem["COUNT"];?>
			<?endforeach;?>
			<tr>
				<td colspan="2" class="ww-all-dell" style=" font-size: 16px; padding: 35px 15px 0 !important; text-align: center; vertical-align: middle;"></td>
				<td colspan="5" class="ww-all-sum" style=" font-size: 16px; padding: 35px 15px 0 !important; text-align: center; vertical-align: middle; font-size: 25px; font-weight: bold; padding-top: 60px !important; text-align: right;"><span>Всего товаров <?=$cntitem;?> на сумму <?=$arResult["COMMON_PRICE"]?>р.</span></td>
			</tr>
		</table>

					<div class="ww-make_order"> 

		<div style="text-align: left;">	
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <?
		$n_line = 0 ;
		foreach($arResult["DISPLAY_PROPERTIES"] as $r => $arProp):?>
			<?if($r=='FIO'):?>
			<tr>
				<th colspan="2" style="background: none repeat scroll 0 0 rgba(0, 0, 0, 0); padding-bottom: 22px; padding-top: 22px;">
					<div class="ww-make-h" style="background: none repeat scroll 0 0 #3685b7; color: #fff; font-size: 17px; font-weight: bold; padding: 10px 0 8px 70px;">
						Личные данные
					</div>
				</th>
			</tr>
			<?elseif($r=='PAYMENT_E'):?>
			<tr>
				<th colspan="2"  style="background: none repeat scroll 0 0 rgba(0, 0, 0, 0); padding-bottom: 22px; padding-top: 22px;">
					<div class="ww-make-h"  style="background: none repeat scroll 0 0 #3685b7; color: #fff; font-size: 17px; font-weight: bold; padding: 10px 0 8px 70px;">
						Оплата
					</div>
				</th>
			</tr>
			<?elseif($r=='PAY_STATYS'):?>
			<tr>
				<th colspan="2"  style="background: none repeat scroll 0 0 rgba(0, 0, 0, 0); padding-bottom: 22px; padding-top: 22px;">
					<div class="ww-make-h"  style="background: none repeat scroll 0 0 #3685b7; color: #fff; font-size: 17px; font-weight: bold; padding: 10px 0 8px 70px;">
						Статус оплаты
					</div>
				</th>
			</tr>
			<?elseif($r=='DELIVERY_E'):?>
			<tr>
				<th colspan="2"  style="background: none repeat scroll 0 0 rgba(0, 0, 0, 0); padding-bottom: 22px; padding-top: 22px;">
					<div class="ww-make-h" style="background: none repeat scroll 0 0 #3685b7; color: #fff; font-size: 17px; font-weight: bold; padding: 10px 0 8px 70px;">
						Доставка
					</div>
				</th>
			</tr>
			<?elseif($r=='TIME'):?>
			<tr>
				<th colspan="2"  style="background: none repeat scroll 0 0 rgba(0, 0, 0, 0); padding-bottom: 22px; padding-top: 22px;">
					<div class="ww-make-h" style="background: none repeat scroll 0 0 #3685b7; color: #fff; font-size: 17px; font-weight: bold; padding: 10px 0 8px 70px;">
						Информация о готовности заказа
					</div>
				</th>
			</tr>
			<?endif;?>
			
			<?if($r!='COMMENTS'):?>
				<tr>
			<?endif;?>
			<?//if($n_line > 0) echo '<br/><br/>';
			$n_line ++ ;
			if(substr_count($arProp["INPUT"], "radio") > 0){
				$arr = explode("<br/>", $arProp["INPUT"]);?>
				<?foreach($arr as $k=>&$ar){
					if($ar){
						if(substr_count($ar, "checked") > 0)
							$ar = '<li style="list-style-type: none; padding:5px 5px 5px 20px; background: url(http://shool.wwall.tmweb.ru/bitrix/templates/weewaa_cake/images/dell_all.gif) left center no-repeat;"><label class="ww-active" style=" font-size: 16px; padding-left: 12px; text-decoration: none; background: url(http://shool.wwall.tmweb.ru/bitrix/templates/weewaa_cake/images/dell_all.gif) left center no-repeat;" class="">&nbsp;&nbsp;&nbsp&nbsp;&nbsp'.$ar.'</label></li>';					
						else
							$ar = '<li style="list-style-type: none;  padding:5px 5px 5px 20px; background: url(http://shool.wwall.tmweb.ru/bitrix/templates/weewaa_cake/images/chek_no.gif) left center no-repeat;"><label class="" style=" font-size: 16px; padding-left: 12px; text-decoration: none;  background: url(http://shool.wwall.tmweb.ru/bitrix/templates/weewaa_cake/images/chek_no.gif) left center no-repeat;">&nbsp;&nbsp;&nbsp&nbsp;&nbsp'.$ar.'</label></li>';					
					}
				}

				
				$arProp["INPUT"] = '<ul class="ww_tab_nav" id="'.$r.'" style="margin-bottom: 0; margin-left: -35px;  margin-top: 0; padding-left: 0 !important;">'.implode(" ", $arr)."</ul>";
			}
		?>
				<?
					if(substr_count($arProp["INPUT"], 'text')) $arProp["INPUT"] = str_replace("<input ", "<input class='ww-text' style='background: none repeat scroll 0 0 #f7f7f7; border: 1px solid #d3d3d3; padding: 5px 10px; width: 540px;' ", $arProp["INPUT"]) ;
				if(substr_count($arProp["INPUT"], 'radio')) $arProp["INPUT"] = str_replace("<input ", "<input style='display: none;' ", $arProp["INPUT"]) ;
				
				?>
			<?if($r=='DELIVERY_E' || $r=='PAYMENT_E' || $r=='PAY_STATYS'|| $r=='STATUS' || $r=='COMMENTS'):?>
				<?if($r=='STATUS' || $r=='COMMENTS'):?>
	                <td style=" font-size: 16px; padding: 8px 0 8px 70px !important; text-align: left;"> 
	                	<?if($r=='COMMENTS'):?>
	                		<?=$arProp["NAME"]?><br>
	                	<?endif;?>
	                	<?=$arProp["INPUT"]?>
	                </td>
				<?else:?>
            	<td colspan="2"  style=" font-size: 16px; padding: 8px 0 8px 70px !important; text-align: left;"> 
                	<?=$arProp["INPUT"]?>
                </td>
                <?endif;?>
            <?elseif($r=='ABOUT'):?>
            	<td colspan="2" class="ww-make-about"  style=" font-size: 16px; padding: 8px 0 8px 70px !important; text-align: left;"> 
            		<span><?=$arProp["NAME"]?></span><br>
                	<textarea name="PROPERTY[ABOUT]" placeholder="В этом поле вы можете указать любую информацию, которую считаете нужной сообщить
менеджеру компании относительно вашего заказа" style="padding: 6px 10px; color: #505050;  background: none repeat scroll 0 0 #f7f7f7;
    border: 1px solid #d3d3d3; font-size: 12px; height: 85px; margin-left: -35px; width: 590px;"><?if(strlen($arProp["VALUE"])>0):?><?=$arProp["VALUE"];?><?endif;?></textarea>

                </td>
              <?elseif($r=='COUNT'):?>
            	<input type="hidden" value="<?=$cntitem;?>" name="PROPERTY[COUNT]">
             <?else:?>
             <td class="ww-make-name"  style=" font-size: 16px; padding: 8px 0 8px 70px !important; text-align: left;  text-align: left; width: 240px;">
                	<?=$arProp["NAME"]?> <?if($arProp['IS_REQUIRED'] == "Y"):?>*<?endif?>: 
                </td>
                <td  style=" font-size: 16px; padding: 8px 0 8px 70px !important; text-align: left;"> 
                	<?=$arProp["INPUT"]?>
                </td>
            <?endif;?>
            
           <?if($r!='STATUS'):?>
           	</tr> 
           <?endif;?>
           <?if($r=='DELIVERY_E'):?>
           <tr>	
           	<td colspan="2" class="ww-post-text" style=" font-size: 16px; padding: 0px 0 20px 0px !important; text-align: left;">
           		<?$APPLICATION->IncludeFile(SITE_DIR . ".inc/post.php", array(), array("MODE"=>"html"));?>
           	</td>
           </tr>
           <?endif;?>
        <?endforeach?>

		</table>
		</div>
	</form>
	<p>Заказ подтверждаю, с условиями оплаты и доставки ознакомлен.</p>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td style="padding: 10px;">Ф.И.О.: __________________________________</td>
			<td style="padding: 10px;">Дата: __________________________________</td>
		</tr>
		<tr>
			<td style="padding: 10px;">Подпись: __________________________________</td>
			<td style="padding: 10px;"></td>
		</tr>
	</table>
	<br>		
	<br>							  <!--.make_order-->
<?else:?>
<?=GetMessage("YENISITE_BASKET_EMPTY")?>
<?endif;?>
                 
                </div><!--.user_basket-->
