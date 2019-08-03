<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?

if($arParams["COLOR_SCHEME"] == "green")
	$GLOBALS["APPLICATION"]->SetAdditionalCSS(str_replace($_SERVER["DOCUMENT_ROOT"], "", dirname(__FILE__)."/green.css"));
elseif($arParams["COLOR_SCHEME"] == "blue")
	$GLOBALS["APPLICATION"]->SetAdditionalCSS(str_replace($_SERVER["DOCUMENT_ROOT"], "", dirname(__FILE__)."/blue.css"));
else{	
	$cs = COption::GetOptionString("yenisite.market", "color_scheme")=="ice"?"blue":COption::GetOptionString("yenisite.market", "color_scheme");
	if($cs && !$arParams["COLOR_SCHEME"] )
		$GLOBALS["APPLICATION"]->SetAdditionalCSS(str_replace($_SERVER["DOCUMENT_ROOT"], "", dirname(__FILE__)."/".$cs.".css"));
	else
		$GLOBALS["APPLICATION"]->SetAdditionalCSS(str_replace($_SERVER["DOCUMENT_ROOT"], "", dirname(__FILE__)."/red.css"));
}

?>

<div style='color: red;'>
<? if(count($arResult['ERROR']) > 0) foreach($arResult['ERROR'] as $err) echo GetMessage("ERROR").$err.'<br/>'; ?>
<br/>
</div>

	<div class="ys-user-basket">

<?if(isset($arResult["ITEMS"])):?>
<?$resizer = CModule::IncludeModule('yenisite.resizer2');?>	 
<form method="POST" id="basket_form">
<input type="hidden" name="calculate_no" id="calculate"  value="Y" />
<input type="hidden" name="order_no" id="order" value="<?=GetMessage("ORDER");?>" />
			<table>
       <?foreach($arResult["ITEMS"] as $k=>$arItem):?>
						<tr>
			  <td class="ibimg">
			  
			 <input type="hidden" class="no_del" name="no_del[]" id="del_<?=$key?>" value="<?=$arItem["KEY"]?>" />
			 

			 
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
					$ResizeParams = array('width' => 50, 'height' => 50);
					$path = CFile::ResizeImageGet($pathid, $ResizeParams,  BX_RESIZE_IMAGE_PROPORTIONAL, true);
					$path = $path['src'];
				}
				
			 ?>
			  
			  <img src="<?=$path;?>" alt="" /></td>
			  <td class="ys-ibname"><h3><a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>"><?=$arItem["FIELDS"]["NAME"]?></a></h3>
			  <td class="ys-ibprice"><span class="price"><?=$arItem["MIN_PRICE"]?> <span class="rubl"><?=GetMessage('RUB');?></span></span></td>
			  <td class="ys-ibcount"><input type="text" name="count[<?=$arItem["KEY"]?>]" id="QUANTITY_<?=$k?>" value="<?=$arItem["COUNT"]?>" class="txt w32" />
				<button onclick="$('#order').attr('name', 'no_order'); $('#calculate').attr('name', 'calculate'); setQuantity('#QUANTITY_<?=$k?>', '+'); return false;" class="button4">+</button> <button onclick="$('#order').attr('name', 'no_order'); $('#calculate').attr('name', 'calculate'); setQuantity('#QUANTITY_<?=$k?>', '-'); return false;" class="button5">-</button></td>
			  <td class="ys-ibdel"><button onclick="$('#order').attr('name', 'no_order'); $('#calculate').attr('name', 'calculate'); $('#del_<?=$key?>').attr('name', 'del[]');" class="button6 sym">'</button></td>
			</tr>
			<?endforeach;?>
		</table>

						

					<div class="make_order"> 
<span class="ys-delivery"><?=GetMessage("DELIVERY");?>: <strong>0<span class="rubl"><?=GetMessage('RUB');?></span></strong></span> 
<br/>
<span class="ys-sum"><?=GetMessage("ITOG");?>: <strong><?=$arResult["COMMON_PRICE"]?><span class="rubl"><?=GetMessage('RUB');?></span></strong></span> 
<br/>					
					
		<div style="text-align: left;">	
        <?foreach($arResult["DISPLAY_PROPERTIES"] as $arProp):
			if(substr_count($arProp["INPUT"], "radio") > 0){
				$arr = explode("<br/>", $arProp["INPUT"]);
				foreach($arr as $k=>&$ar){
					if($ar){
						if(substr_count($ar, "checked") > 0)
							$ar = '<li><a class="ys_active" class="" href="#tab-'.$k.md5($arProp["NAME"]).'">&nbsp;&nbsp;&nbsp&nbsp;&nbsp'.$ar.'</a></li>';					
						else
							$ar = '<li><a class="" href="#tab-'.$k.md5($arProp["NAME"]).'">&nbsp;&nbsp;&nbsp&nbsp;&nbsp'.$ar.'</a></li>';					
					}
				}
				
				
				$arProp["INPUT"] = '<ul class="ys_tab_nav">'.implode(" ", $arr)."</ul>";
			}
		?>
				<?
					if(substr_count($arProp["INPUT"], 'text')) $arProp["INPUT"] = str_replace("<input ", "<input class='txt' ", $arProp["INPUT"]) ;
				?>
                <b><?=$arProp["NAME"]?> <?if($arProp['IS_REQUIRED'] == "Y"):?>*<?endif?></b>:<br/>            
                <?=$arProp["INPUT"]?><br/><br/>
        <?endforeach?>
		</div>
   
<button onclick="$('#calculate').attr('name', 'no_calculate'); $('#order').attr('name', 'order');  $('#basket_form').attr('action', '<?=$arParams["BASKET_URL"]?>').submit();  return false;" class="button3"><?=GetMessage("ORDER");?></button></div>
						
	</form>					
								  <!--.make_order-->

<?else:?>
<?=GetMessage("YENISITE_BASKET_EMPTY")?>
<?endif;?>
                 
                </div><!--.user_basket-->

<?return?>

<div style='color: red;'>
<? if(count($arResult['ERROR']) > 0) foreach($arResult['ERROR'] as $err) echo GetMessage("ERROR").$err.'<br/>'; ?>
</div>


<?if(isset($arResult["ITEMS"])):?>
<form method="POST">
    <table class="big-basket" width="100%">
        <tr><td width="20%" class="head"><?=GetMessage("PHOTO");?></td><td width="50%" class="head"><?=GetMessage("NAME");?></td><td width="10%" class="head l"><?=GetMessage("COUNT");?></td><td width="10%" class="head c"><?=GetMessage("PRICE");?></td><td width="10%" class="head"><?=GetMessage("DELETE");?></td></tr>
        <?foreach($arResult["ITEMS"] as $arItem):?>
        <tr class="item">
		<td>
			<?	if($arItem["FIELDS"]['PREVIEW_PICTURE']): ?>
				   <a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>" title="<?=$arItem["FIELDS"]["NAME"]?>"><img src='<?=CFile::GetPath($arItem["FIELDS"]['PREVIEW_PICTURE']);?>' alt='<?=$arItem["FIELDS"]["NAME"]?>' /></a>
			<? endif; ?>
		</td>
		
		<td>
                <a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>" title="<?=$arItem["FIELDS"]["NAME"]?>"><?=$arItem["FIELDS"]["NAME"]?></a><br/>


                <span>
                <? $i=0; foreach($arItem["PROPERTIES"] as $arProp): $i++;?>
				<?if($arProp[VALUE]):?>
                    <b><?=$arProp["NAME"]?>:</b> <?=$arProp["VALUE"]?><?=($i<count($arItem["PROPERTIES"]))?",&nbsp;":"";?>
				<?endif?>
                <?endforeach?>    
                </span>

            </td>
            <td><input style="width: 40px;" type="text" name="count[<?=$arItem["KEY"]?>]" value="<?=$arItem["COUNT"]?>" /></td>
			<td><?=$arItem["MIN_PRICE"]?> <?=$arParams['UE'];?></td>
            <td><input type="checkbox" name="del[]" value="<?=$arItem["KEY"]?>"/></td></tr>
        <?endforeach?>
			<tr><td></td><td></td> <td></td> <td></td> <td><br/><b><?=GetMessage("ITOG");?>:</b> <?=$arResult["COMMON_PRICE"]?> <?=$arParams['UE'];?></td></tr>
        </table>
    
        <br/>
        
        <input style="float: right;" name="calculate" type="submit" value="<?=GetMessage("CALCULATE");?>"/>

<br/>
<br/>

    <table class="big-basket-fields" width="100%">
        <?foreach($arResult["DISPLAY_PROPERTIES"] as $arProp):?>
        <tr class="field">
            <td class="left">
                <?=$arProp["NAME"]?><?if($arProp['IS_REQUIRED'] == "Y"):?>*<?endif?>:
            </td>
            <td class="right">
                <?=$arProp["INPUT"]?>
            </td>
        </tr>
        <?endforeach?>
   </table>
   
   <br/>
   <input class="button3" style="float: right;" type="submit" name="order" value="<?=GetMessage("ORDER");?>"/>
  
</form>

<?else:?>
<?=GetMessage("YENISITE_BASKET_EMPTY")?>
<?endif;?>

