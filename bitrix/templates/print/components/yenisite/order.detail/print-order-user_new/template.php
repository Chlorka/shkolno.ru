<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div id="ww-print_user">
<img src="/images/pr_h.jpg" width="800px" height="83px">
<h2>����� ������</h2>
<div style="text-align: center; margin-bottom: 7px;"><b class="red">���������� ����� ������ �� ������� ��������� ���������� ���� ���������!</b></div>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
	<tr>
		
		<td valign="top" width="33%"><b>����� ������:</b><br><span><?=$arResult["ORDER_ID"];?></span></td>	
		<td valign="top"  width="33%"><b>���� ������:</b><br><span><?=ConvertDateTime($arResult['ORDER_DATE'], "DD.MM.YYYY", "ru");?></span></td>	
		<td  valign="top"  width="33%">
			<b>��� ������:</b><br>
			<?foreach($arResult["DISPLAY_PROPERTIES"] as $r => $arProp):?>
				<?if($r=='POSHIV'):?>
				<?$n_line ++ ;
				if(substr_count($arProp["INPUT"], "radio") > 0){
					$arr = explode("<br/>", $arProp["INPUT"]);?>
					<?foreach($arr as $k=>&$ar){
						if($ar){
							if(substr_count($ar, "checked") > 0)
								$ar = '<li><label class="ww-active" class="">&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>'.$ar.'</b></label></li>';					
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
				        	<?=$arProp["INPUT"]?>
		                   <?endif;?>
			<?endforeach?> 
		</td>
	</tr>
</table>

<p><b>���������� � ����������:</b></p>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
	<tr>		
		<td valign="top"  width="33%"><b>������� �.�.:</b>&nbsp;<?=$arResult["DISPLAY_PROPERTIES"]["FIO"]["VALUE"];?></td><td  width="33%"><b>�������:</b>&nbsp;<?=$arResult["DISPLAY_PROPERTIES"]["PHONE"]["VALUE"];?></td><td width="33%"><b>e-mail:</b>&nbsp;<?=$arResult["DISPLAY_PROPERTIES"]["EMAIL"]["VALUE"];?></td>
	</tr>
	<tr>		
		<td valign="top"><b>��� �������:</b>&nbsp;<?=$arResult["DISPLAY_PROPERTIES"]["FIO_CIHLDREN"]["VALUE"];?></td><td><b>�����:</b>&nbsp;<?=$arResult["DISPLAY_PROPERTIES"]["SCHOOL"]["VALUE"];?></td><td><b>�����:</b>&nbsp;<?=$arResult["DISPLAY_PROPERTIES"]["CLASS"]["VALUE"];?></td>
	</tr>
</table>

<p><b>�������� �����:</b></p>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
	<tr>
		<td>�<br>�/�</td><td>�������</td><td>������������</td><td>������</td><td>����</td><td>����������</td><td>�����</td>	
	</tr>
	<tr>



		<?$cntitem=0;?>		
       <?foreach($arResult["ITEMS"] as $k=>$arItem):?>
		<td><?=$k+1;?></td>	
		<td><?=$arItem['DISPLAY_PROP']['ARTICLE'];?></td>
		<td><?=$arItem["FIELDS"]["NAME"]?></td>				  
		<td>
			<?if(strlen($arItem['PROPERTIES']['SIZE']['VALUE'])>0) echo $arItem['PROPERTIES']['SIZE']['VALUE']; else '(�������)';?></span>
		</td>
		<td><?if($arItem["PERSONAL_PRICE"]>0) 
			  			echo $arItem["PERSONAL_PRICE"];
			  		else
						echo $arItem["MIN_PRICE"];
			  		?>&nbsp;�.</td>
		<td><?=$arItem["COUNT"]?></td>
		<td><?if($arItem["PERSONAL_PRICE"]>0) 
				echo $arItem["COUNT"]*$arItem["PERSONAL_PRICE"];
			else
				echo $arItem["COUNT"]*$arItem["MIN_PRICE"];
			?>&nbsp;�.
		</td>
	</tr>
<?endforeach;?>
</table>

<p align="right" class="ww-user_itog"><b>�����: <?=$arResult["COMMON_PRICE"]?>&nbsp;������.</b></p>


<p><b>�������������� ������ � ������:</b></p>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
	<tr>
		<td>�<br>�/�</td><td>�������</td><td>������������</td><td>������</td><td>����</td><td>����������</td><td>�����</td>	
	</tr>
		 <?
		 $all_sum = 0;
		 foreach($arResult["DISPLAY_PROPERTIES"]["ADD_GOODS"]["MULTIPLE_VALUE"] as $pid => $cell) {
		 	$value = explode(";", $cell);
		 	?>
         <tr>           
			<td><?=$value[0]?></td>
			<td><?=$value[1]?></td>
			<td><?=$value[2]?></td>
			<td><?=$value[3]?></td>
			<td><?=$value[4]?></td>
			<td><?=$value[5]?></td>
			<td><?=$value[6]?> �.
				<?$all_sum = $all_sum + $value[6];?>
			</td>
		</tr>
		<?}?>
</table>
<p align="right"  class="ww-user_itog"><b>�����: <?=$all_sum;?> ������</b></p>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
	<tr>
		<td width="33%"><b>����� ������</b></td><td width="66%"  align="right"><b><?=$arResult["COMMON_PRICE"]+$all_sum;?>&nbsp;������.</b></td>
</tr>
</table>

<p><b>��������:</b></p>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
	<tr>
			<?foreach($arResult["DISPLAY_PROPERTIES"] as $r => $arProp):?>
				<?if($r=='DELIVERY_E'):?>
				<?$n_line ++ ;
				if(substr_count($arProp["INPUT"], "radio") > 0){
					$arr = explode("<br/>", $arProp["INPUT"]);?>
					<?foreach($arr as $k=>&$ar){
						if($ar){
							if(substr_count($ar, "checked") > 0)
								$ar = '<td><label class="ww-active" class="">&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>'.$ar.'</b></label></td>';					
							else
								$ar = '<td><label class="" >&nbsp;&nbsp;&nbsp&nbsp;&nbsp'.$ar.'</label></td>';					
						}
					}
	
					
					$arProp["INPUT"] = ''.implode(" ", $arr)."";
				}
			?>
					<?
						if(substr_count($arProp["INPUT"], 'text')) $arProp["INPUT"] = str_replace("<input ", "<input class='ww-text' ", $arProp["INPUT"]) ;
					?>
				        	<?=$arProp["INPUT"]?>
		                   <?endif;?>
			<?endforeach?>
	</tr>
	<tr>
		<td colspan="3">
			����� ��������: <?=$arResult["DISPLAY_PROPERTIES"]["ABOUT"]["VALUE"];?>
		</td>
	</tr>
<tr>
		<td  width="33%">��������� ��������, ���</td><td colspan="2"  width="66%"><?=$arResult["DISPLAY_PROPERTIES"]["DELIVERY_PRICE"]["VALUE"];?> �.</td>
</tr>
</table>
<p></p>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
	<tr>
		<td width="33%"><b>����� ������</b></td><td width="66%" align="right"><b><?=$arResult["COMMON_PRICE"]+$all_sum+$arResult["DISPLAY_PROPERTIES"]["DELIVERY_PRICE"]["VALUE"];?> ������.</b></td>
</tr>
</table>
<p><b>���������� �� ������:</b></p>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
	<tr>
		<td  width="33%">������ ������</td>
		<?foreach($arResult["DISPLAY_PROPERTIES"] as $r => $arProp):?>
				<?if($r=='PAYMENT_E'):?>
				<?$n_line ++ ;
				if(substr_count($arProp["INPUT"], "radio") > 0){
					$arr = explode("<br/>", $arProp["INPUT"]);?>
					<?foreach($arr as $k=>&$ar){
						if($ar){
							if(substr_count($ar, "checked") > 0)
								$ar = '<td  width="33%"><label class="ww-active" class="">&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>'.$ar.'</b></label></td>';					
							else
								$ar = '<td  width="33%"><label class="" >&nbsp;&nbsp;&nbsp&nbsp;&nbsp'.$ar.'</label></td>';					
						}
					}
	
					
					$arProp["INPUT"] = ''.implode(" ", $arr)."";
				}
			?>
					<?
						if(substr_count($arProp["INPUT"], 'text')) $arProp["INPUT"] = str_replace("<input ", "<input class='ww-text' ", $arProp["INPUT"]) ;
					?>
				        	<?=$arProp["INPUT"]?>
		                   <?endif;?>
			<?endforeach?>
	</tr>
</table>
<br>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
	<tr>
		<td  width="18%">&nbsp;</td><td  width="27%">�����</td><td width="27%">� �������</td><td width="27%">������������� ������</td>
	</tr>
		<?$value_price = explode(";", $arResult["DISPLAY_PROPERTIES"]["OPLATA"]["MULTIPLE_VALUE"][0]);?>
		<?$value_date = explode(";", $arResult["DISPLAY_PROPERTIES"]["OPLATA"]["MULTIPLE_VALUE"][1]);?>
    <tr>
		<td>�����, ���.</td><td><?=$value_price[0]?>&nbsp;</td><td><?=$value_price[1]?>&nbsp;</td><td><?=$value_price[2]?>&nbsp;</td>
	</tr> 	
	<tr>
		<td>����</td><td><?=$value_date[0]?>&nbsp;</td><td><?=$value_date[1]?>&nbsp;</td><td><?=$value_date[2]?>&nbsp;</td>
	</tr>		
</table>
<br>
<font size="2">
��������������� ���� ������������ ������ - 2 ������ � ������� ���������� ������. � ���������� ������ �� ��� �������������� �� ���������� ���� �������� � ������������ ������. �������������� � ���������� �� ������ ������ �� ���������: 8 (391) 278-82-10
</font>
<br>
<br>
<font size="3">� ��������� ������ ����������     _______________/______________  
<br><br>
������� �������������� ���� �� ������� ����������� _______________/______________ 
</font>
<br>
<br>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
	<tr>
		<td width="40%"><b>���������� ��� �����������</b></td><td width="60%">&nbsp;</td>
	</tr>
	<tr>
		<td>���� �������� ������ � ������������:</td><td>&nbsp;</td>
	</tr>
	<tr>
		<td>�����������:</td><td>&nbsp;</td>
	</tr>
	<tr>
		<td>���� ������ ������:</td><td>&nbsp;</td>
	</tr>
</table>			
</div>
<div style="clear: both;"></div>
<a href="<?=$APPLICATION->GetCurUri();?>" class="ww-print_a">������</a>
<br>
<br>
<?//r($arResult);?>
<?/*?>
<h2>����� � <?=$_REQUEST["ORDER"]?></h2>
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

						<div class="ww-ul-size" id="size<?=$k?>">
							<span class="text_head"><?if(strlen($arItem['PROPERTIES']['SIZE']['VALUE'])>0) echo $arItem['PROPERTIES']['SIZE']['VALUE']; else '(�������)';?></span>
						</div>
						
						<input type="hidden" name="SIZE[<?=$arItem["KEY"]?>]" value="<?=$numSize;?>">
				<?endif;?>
			  </td>
			  <td class="ww-td-dott"><span class="price"><?=$arItem["MIN_PRICE"]?> <span class="rubl">�.</span></span></td>
			  <td class="ys-ibcount ww-td-dott">
					<div class="ww-input-count">  	
			  			<input type="text" name="count[<?=$arItem["KEY"]?>]" id="QUANTITY_<?=$k?>" value="<?=$arItem["COUNT"]?>" class="cntval<?=$k?>" />
					</div>
			</td>
			  
			  <td class="ww-itog-item ww-td-dott">
			  	<?=$arItem["COUNT"]*$arItem["MIN_PRICE"];?> <span class="rubl">�.</span>
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
				<td colspan="2" class="ww-all-dell"></td>
				<td colspan="5" class="ww-all-sum"><span>����� ������� <?=$cntitem;?> �� ����� <?=$arResult["COMMON_PRICE"]?>�.</span></td>
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
			<?elseif($r=='TIME'):?>
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
		</div>
	</form>
	<p>����� �����������, � ��������� ������ � �������� ����������.</p>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>�.�.�.: __________________________________</td>
			<td>����: __________________________________</td>
		</tr>
		<tr>
			<td>�������: __________________________________</td>
			<td></td>
		</tr>
	</table>
	<br>		
	<br>							  <!--.make_order-->
<?else:?>
<?=GetMessage("YENISITE_BASKET_EMPTY")?>
<?endif;?>
                 
                </div><!--.user_basket-->
<?*/?>