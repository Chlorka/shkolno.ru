<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<section id="ww-order-list">
<?
$cnt = count($arParams["FIELD_CODE"]);
$cnt += count($arParams["PROPERTY_CODE"]);
?>

  <table class="ww-bills" cellpadding="0" border="0" cellspacing="0">  
		<thead>
		<tr>
		<th>Отмена<br>заказа</th>								
		<?foreach($arParams["FIELD_CODE"] as $code): 
			if($code!="DATE_CREATE" && $code != 'STATUS' && $code != 'ACTIVE'):?>
				<th><?=GetMessage($code)?></th>						
			<?endif;
		endforeach;?>
		<?foreach($arParams["FIELD_CODE"] as $code): 
			if($code == 'STATUS'):?>
				<th><?=GetMessage($code)?></th>						
			<?endif;
		endforeach;?>
						
		<?foreach($arParams["PROPERTY_CODE"] as $code): 
			if($arResult["ITEMS"][0]["PROPERTIES"][$code]["NAME"] && $code != 'STATUS'):?>
				<th><?=$arResult["ITEMS"][0]["PROPERTIES"][$code]["NAME"]?></th>						
			<?endif;
		endforeach;?>
		
		<?foreach($arParams["PROPERTY_CODE"] as $code): 
			if($arResult["ITEMS"][0]["PROPERTIES"][$code]["NAME"] && $code == 'STATUS'):?>
				<th><?=$arResult["ITEMS"][0]["PROPERTIES"][$code]["NAME"]?></th>						
			<?endif;
		endforeach;?>						
								
		</tr>
		</thead>
		<tbody>
		<?foreach($arResult["ITEMS"] as $arItem):?>
		<tr <?if($arItem["ACTIVE"]=="N"):?>style="background:#dadada;"<?endif;?>>
			<td>
				<a	<?if($arItem["ACTIVE"]=="Y"):?>
						href="/account/orders/?ID=<?=$arItem['ID']?>&action=N"
					<?else:?>
						href="/account/orders/?ID=<?=$arItem['ID']?>&action=Y"
					<?endif;?> 
				class="active<?if($arItem["ACTIVE"]=="N"):?>_no<?endif;?>">
				&nbsp;</a>
				<?//r($arItem);?>
			</td>
			<?foreach($arParams["FIELD_CODE"] as $code): 
				if($code!="DATE_CREATE" && $code != 'STATUS' && $code != 'ACTIVE'):?>
					<td>
						<a href="<?=$arItem['DETAIL_PAGE_URL'];?>">
							<b>№: &nbsp;<?=$arItem[$code]?></b>
						</a>
						<?if($code == "ID"):?>
								<br><span class="date" style="white-space: nowrap;"><?=GetMessage("PO")?> <?=ConvertDateTime($arItem["DATE_CREATE"], "DD.MM.YYYY", "ru");?></span>
						<?endif?>
						<a href="/account/orders/detail_new/?ORDER=<?=$arItem[$code]?>&copy=Y" class="ww-order_copy">копировать</a>
					</td>						
				<?endif; 
			endforeach;?>
			
			<?foreach($arParams["FIELD_CODE"] as $code): 
				if($code == 'STATUS'):?>
					<td>
						<a href="<?=$arItem['DETAIL_PAGE_URL'];?>">
							<b>№: &nbsp;<?=$arItem[$code]?></b>
							<?if($code == "ID"):?>
								<br><span class="date"><?=GetMessage("PO")?> <?=$arItem["DATE_CREATE"]?></span>
							<?endif?>
						</a>
					</td>						
				<?endif; 
			endforeach;?>
			
			
			<?foreach($arParams["PROPERTY_CODE"] as $code): 
				if($code != 'STATUS' && $code != 'ACTIVE'):?>	
					<td>
						<?if(is_array($arItem["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])):?>
							<?foreach($arItem["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"] as $k=>$el):?>
								<?=$k+1;?>.&nbsp;<?=$el?><br/>
							<?endforeach?>
						<?else:?>
							<?=$arItem["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"];?>
							<?//r($arItem["DISPLAY_PROPERTIES"][$code]);?>
						<?endif?>
					</td>
				<?endif;?>						
			<?endforeach;?>
			
			<?foreach($arParams["PROPERTY_CODE"] as $code): 
				if($code == 'STATUS'):?>	
					<td>
						<?if(is_array($arItem["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])):?>
							<?foreach($arItem["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"] as $k=>$el):?>
								<?=$k+1;?>.&nbsp;<?=$el?><br/>
							<?endforeach?>
						<?else:?>
							<?=$arItem["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"];?>
						<?endif?>
					</td>
				<?endif;?>						
			<?endforeach;?>						
		</tr>
		<?endforeach?>
	</tbody>
</table>	
<?//r($arParams["PROPERTY_CODE"]);?>
</section>