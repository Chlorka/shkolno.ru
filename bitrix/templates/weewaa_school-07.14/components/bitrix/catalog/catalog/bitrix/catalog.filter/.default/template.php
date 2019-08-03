<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<section id="ww-filter_school">
	<p>Выберите, пожалуйста, в какой возрастной группе Ваш ребенок:</p>
<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
	<?foreach($arResult["ITEMS"] as $arItem):
		if(array_key_exists("HIDDEN", $arItem)):
			echo $arItem["INPUT"];
		endif;
	endforeach;?>
	<ul>
		<?foreach($arResult["ITEMS"] as $pid=>$arItem):?>
			<?if(!array_key_exists("HIDDEN", $arItem)):?>
				<?if($pid == 'PROPERTY_46') {?>
					<?/*foreach($arResult["arrProp_LIST"]["TYPE"] as $value=>$name) {?>
						<li><label><input type="radio" value="<?=$value;?>" name="arrFilter_pf[TYPE]"><?=$name;?></label></li>	
					<?}*/?>
					<?//=$arItem["INPUT"];?>
					<?$pieces = explode("<br>", $arItem["INPUT"]);
					foreach($pieces as $input) {?>
						<li><label><?=$str = str_replace("(все)", "Показать все", $input);?></label></li>	
					<?}?>
					
					
				<?} else {?>
					<li>
						<?=$arItem["INPUT"]?>
					</li>
				<?}?>
			<?endif?>
		<?endforeach;?>
	</ul>
<input type="submit" name="set_filter" value="<?=GetMessage("IBLOCK_SET_FILTER")?>" /><input type="hidden" name="set_filter" value="Y" />
<input type="submit" name="del_filter" value="<?=GetMessage("IBLOCK_DEL_FILTER")?>" />

</form>
</section>
