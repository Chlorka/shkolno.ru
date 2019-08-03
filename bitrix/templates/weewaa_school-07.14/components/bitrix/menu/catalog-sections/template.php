<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<aside id="ww-catalog_link">
	<ul class="tabs">
		<?foreach($arResult as $index=>$arItem):?>
			<?if ($arItem["IS_PARENT"]):?>
				<?if ($arItem["DEPTH_LEVEL"] == 1):?>
					<li class="<?if ($arItem["SELECTED"]):?>active<?endif;?>"><a href="<?=$arItem["LINK"]?>" alt="#tab<?=$index?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected active<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a></li>
				<?endif?>
			<?else:?>

				<?if ($arItem["PERMISSION"] > "D"):?>

					<?if ($arItem["DEPTH_LEVEL"] == 1):?>
						<li  class="<?if ($arItem["SELECTED"]):?>active<?endif;?>"><a  href="<?=$arItem["LINK"]?>"  alt="#tab<?=$index?>"  class="<?if ($arItem["SELECTED"]):?>root-item-selected  active<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a></li>
					<?endif?>

				<?else:?>

					<?if ($arItem["DEPTH_LEVEL"] == 1):?>
						<li  class="<?if ($arItem["SELECTED"]):?>active<?endif;?>"><a  href="<?=$arItem["LINK"]?>"  alt="#tab<?=$index?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected  active<?else:?>root-item<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
					<?endif?>

				<?endif?>

			<?endif?>
		<?endforeach?>
	</ul>	
<div class="clear"></div>
    <div class="tab_container">
<?
$previousLevel = 0;
foreach($arResult as $index=>$arItem):?>
	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</div>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<div id="tab<?=$index?>" class="tab_content" <?if ($arItem["SELECTED"]):?><?else:?>style="display: none;"<?endif;?>>
		<?else:?>
		<?endif?>

	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<?else:?>
				<a href="<?=$arItem["LINK"]?>" <?if ($arItem["SELECTED"]):?> class="item-selected"<?endif?>><?=$arItem["TEXT"]?></a>
				<?/*?><li<?if ($arItem["SELECTED"]):?> class="item-selected"<?endif?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li><?*/?>
			<?endif?>

		<?else:?>

			<?/*if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li><a href="" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
			<?else:?>
				<li><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
			<?endif*/?>

		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</div>", ($previousLevel-1) );?>
<?endif?>
	</div>
	<div class="clear"></div>
	</aside>
<?endif?>