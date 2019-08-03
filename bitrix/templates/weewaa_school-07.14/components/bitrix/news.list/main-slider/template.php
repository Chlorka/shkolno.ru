<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<section id="ww-slider-main">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<article id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?/*if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
			<?else:?>
				<b><?echo $arItem["NAME"]?></b><br />
			<?endif;?>
		<?endif;*/?>
		<section>
			<header><?echo $arItem["NAME"]?></header>
			<section>
			<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
				<?echo $arItem["PREVIEW_TEXT"];?>
			<?endif;?>
			</section>
		</section>
		<aside>
			<section id="slider">
				<?foreach($arItem["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $pid=>$arID):?>
					<img data-href="<?=$arItem["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"][$pid]["DESCRIPTION"]?>" src="<?=$arItem["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"][$pid]["SRC"]?>" width="<?=$arItem["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"][$pid]["WIDTH"]?>" height="<?=$arItem["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"][$pid]["HEIGHT"]?>" alt="<?echo $arItem["NAME"]?>">
				<?endforeach;?>
			</section>
			<span id="play"></span>
		</aside>
		<footer>
			<?//if(strlen($arItem["DISPLAY_PROPERTIES"]["HREF"]["VALUE"])>0):?>
				<a href="#">Перейти</a>
			<?//endif;?>
		</footer>
	</article>
<?endforeach;?>
</section>
