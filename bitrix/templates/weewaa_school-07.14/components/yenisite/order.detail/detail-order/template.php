<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript" src="/bitrix/js/main/ajax.js"></script>
<?/*
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
*/
?>
<h2>��� �����</h2>
<div style='color: red;'>
<? if(count($arResult['ERROR']) > 0) foreach($arResult['ERROR'] as $err) echo GetMessage("ERROR").$err.'<br/>'; ?>
<br/>
</div>

	<div class="ys-user-basket" id="ww-order">

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
						����
					</th>
					<th>
						�������
					</th>
					<th>
						��������
					</th>
					<th>
						������
					</th>
					<th>
						����
					</th>
					<th>
						����������
					</th>
					<th>
						����
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
			  
			  <a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>"><img src="<?=$path;?>" alt="" /></a></td>
			  <td><?=$arItem['DISPLAY_PROP']['ARTICLE'];?></td>
			  <td class="ww-td-dott"><a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>"><?=$arItem["FIELDS"]["NAME"]?></a></td>
			  <td class="ww-td-dott ww-td-size">
			  	<?//r($arItem);?>
			  	<?if(count($arItem['DISPLAY_PROP']['SIZE'])>0):?>
<?/*?><div style="position: relative;">			  	
<div class="ww-ul-size"> 
<span class="h3_arr_bg"><?if(strlen($arItem['PROPERTIES']['SIZE']['VALUE'])>0) echo $arItem['PROPERTIES']['SIZE']['VALUE']; else '(�������)';?><span class="expand">+</span></span>
<ul>
<?foreach($arItem['DISPLAY_PROP']['SIZE'] as $l=>$val) {?>
	<li><label><input type="radio" <?if($val==$arItem['PROPERTIES']['SIZE']['VALUE']):?>checked="checked"<?endif;?> value="<?=$l;?>" name="prop[SIZE]" alt="<?=$val;?>"><?=$val;?></label></li>
<?}?>
</ul>
</div>
</div><?*/?>

						<div class="ww-ul-size" id="size<?=$k?>">
							<span class="arr_bg"></span>
							<span class="text_head"><?if(strlen($arItem['PROPERTIES']['SIZE']['VALUE'])>0) echo $arItem['PROPERTIES']['SIZE']['VALUE']; else '(�������)';?></span>
							<ul class="dropdown no-show">
							<?foreach($arItem['DISPLAY_PROP']['SIZE'] as $l=>$val) {?>
								<li><label><input type="radio" <?if($val==$arItem['PROPERTIES']['SIZE']['VALUE']): $numSize=$l;?>checked="checked"<?endif;?> value="<?=$l;?>" name="prop[SIZE]" alt="<?=$val;?>"><?=$val;?></label></li>
							<?}?>
							</ul>
						</div>
						
			  	
			  <?/*?>	<div tabindex="1" class="ww-rez_select dd" id="dd<?=$k?>">
							<span class="arr_bg"></span>
							<span class="text_head"><?if(strlen($arItem['PROPERTIES']['SIZE']['VALUE'])>0) echo $arItem['PROPERTIES']['SIZE']['VALUE']; else '(�������)';?></span>
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
			  <td class="ww-td-dott"><span class="price"><?=$arItem["MIN_PRICE"]?> <span class="rubl">�.</span></span></td>
			  <td class="ys-ibcount ww-td-dott">
					<div class="ww-input-count">  	
			  			<input type="text" name="count[<?=$k?>]" id="QUANTITY_<?=$k?>" value="<?=$arItem["COUNT"]?>" class="cntval<?=$k?>" />
						<a <?/*?>onclick="$('#order').attr('name', 'no_order'); $('#calculate').attr('name', 'calculate'); setQuantity('#QUANTITY_<?=$k?>', '+'); return false;"<?*/?> id="up" class="val<?=$k?>"><span></span></a> 
						<a <?/*?>onclick="$('#order').attr('name', 'no_order'); $('#calculate').attr('name', 'calculate'); setQuantity('#QUANTITY_<?=$k?>', '-'); return false;"<?*/?> id="down" class="val<?=$k?>"><span></span></a>
					</div>
			</td>
			  
			  <td class="ww-itog-item ww-td-dott">
			  	<?=$arItem["COUNT"]*$arItem["MIN_PRICE"];?> <span class="rubl">�.</span>
			  	<div>
			  		<?$link='/account/orders/detail/?ORDER='.$_REQUEST["ORDER"].'&del[]='.$k;?>
				<a alt="<?=$k;?>" href="<?=$link;?>" class="ww-del-item delete-item">�������<br>�� �������</a>  	
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
				<td colspan="3" class="ww-all-add"><input type="text" value="" placeholder="������� �������" name="articleNew"><a href="javascript:void(0)" id="ww-add-item">�������� �����</a>
				</td>
				<td colspan="4" class="ww-all-sum"><span>����� ������� <?=$cntitem;?> �� ����� <?=$arResult["COMMON_PRICE"]?>�.</span></td>
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
				<th colspan="2">
					<div class="ww-make-h">
						������ ������
					</div>
				</th>
			</tr>
			<?elseif($r=='PAYMENT_E'):?>
			<tr>
				<th colspan="2">
					<div class="ww-make-h">
						������
					</div>
				</th>
			</tr>
			<?elseif($r=='PAY_STATYS'):?>
			<tr>
				<th colspan="2">
					<div class="ww-make-h">
						������ ������
					</div>
				</th>
			</tr>
			<?elseif($r=='DELIVERY_E'):?>
			<tr>
				<th colspan="2">
					<div class="ww-make-h">
						��������
					</div>
				</th>
			</tr>
			<?elseif($r=='STATUS'):?>
			<tr>
				<th colspan="2">
					<div class="ww-make-h">
						�������������� ���������� � ������
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
			<?if($r=='DELIVERY_E' || $r=='PAYMENT_E' || $r=='PAY_STATYS'|| $r=='STATUS' || $r=='COMMENTS'):?>
				<?if($r=='STATUS' || $r=='COMMENTS'):?>
	                <td> 
	                	<?if($r=='COMMENTS'):?>
	                		<?=$arProp["NAME"]?><br>
	                	<?endif;?>
	                	<?=$arProp["INPUT"]?>
	                </td>
				<?else:?>
            	<td colspan="2"> 
                	<?=$arProp["INPUT"]?>
                </td>
                <?endif;?>
            <?elseif($r=='ABOUT'):?>
            	<td colspan="2" class="ww-make-about"> 
            		<span><?=$arProp["NAME"]?></span>
                	<textarea name="PROPERTY[ABOUT]" placeholder="� ���� ���� �� ������ ������� ����� ����������, ������� �������� ������ ��������
��������� �������� ������������ ������ ������"><?if(strlen($arProp["VALUE"])>0):?><?=$arProp["VALUE"];?><?endif;?></textarea>

                </td>
              <?elseif($r=='COUNT'):?>
            	<input type="hidden" value="<?=$cntitem;?>" name="PROPERTY[COUNT]">
             <?else:?>
             <td class="ww-make-name">
                	<?=$arProp["NAME"]?> <?if($arProp['IS_REQUIRED'] == "Y"):?>*<?endif?>: 
                </td>
                <td> 
                	<?=$arProp["INPUT"]?>
                </td>
            <?endif;?>
            
           <?if($r!='STATUS'):?>
           	</tr> 
           <?endif;?>
           <?if($r=='DELIVERY_E'):?>
           <tr>	
           	<td colspan="2" class="ww-post-text">
           		<?$APPLICATION->IncludeFile(SITE_DIR . ".inc/post.php", array(), array("MODE"=>"html"));?>
           	</td>
           </tr>
           <?endif;?>
        <?endforeach?>

		</table>
		<br/><b>*</b><span class="req_message"><?=GetMessage('REQUIRED');?></span>
		</div>
<p style="text-align: center;">
	<?/*?><input type="hidden" name="ajax_call" value="Y"><?*/?>
	<input type="submit" value="���������" name="update" id="ww-send">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?if(strlen($_REQUEST["PROPERTY"]["EMAIL"])>0) {
		$user_mail = $_REQUEST["PROPERTY"]["EMAIL"];
	}
	else {
		$user_mail = $arResult["DISPLAY_PROPERTIES"]["EMAIL"]["VALUE"];
	}
	?>
	<a href="/account/orders/send_user/?ORDER=<?=$_REQUEST['ORDER']?>&print=Y" onclick="jsAjaxUtil.InsertDataToNode('/account/orders/send_user/?ORDER=<?=$_REQUEST[ORDER];?>&print=Y&MAIL=<?=$user_mail;?>&ajax_call=Y','ww-send_yes', true); return false;" class="ww-button"  target="_blank" >��������� �������</a>
	
	<div id="ww-send_yes" style="text-align: center; color: green; font-weight: bold;"></div>
	<?/*?><input type="submit" value="��������� �������" name="sendmail"><?*/?>
</p>
<p style="text-align: center;">
	<a href="/account/orders/detail/?ORDER=<?=$_REQUEST['ORDER']?>&print=Y" class="ww-button"  target="_blank" >������ ��� ������������</a>
	<?/*?><input type="submit" value="������ ��� ������������" name="printfor"><?*/?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="/account/orders/detail_user/?ORDER=<?=$_REQUEST['ORDER']?>&print=Y" class="ww-button"  target="_blank" >������ ��� �������</a>
	<?/*?>
	<input type="submit" value="������ ��� �������" name="printuser">
	<?*/?>
</p>
	</form> 
								  <!--.make_order-->
<?else:?>
<?=GetMessage("YENISITE_BASKET_EMPTY")?>
<?endif;?>
                 
                </div><!--.user_basket-->
<?//r($arResult[ITEMS]);?>
