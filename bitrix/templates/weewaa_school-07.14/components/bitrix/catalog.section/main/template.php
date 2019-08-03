<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(count($arResult["ITEMS"])>0):?>
<div class="ww-head_h">
	<header><?=$arResult["NAME"]?></header>
<section class="ww-list_item">
		<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>

		<?
		$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCT_ELEMENT_DELETE_CONFIRM')));
		$arElement["DETAIL_PAGE_URL"] = $arElement["DISPLAY_PROPERTIES"]["URL"]["VALUE"];
		?>
		<article class="ww-item" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
					<aside>
					<?if(is_array($arElement["PREVIEW_PICTURE"])):?>
						<a href="<?=$arElement["DETAIL_PAGE_URL"]?>" target="_blank"><img
								border="0"
								src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>"
								width="<?=$arElement["PREVIEW_PICTURE"]["WIDTH"]?>"
								height="<?=$arElement["PREVIEW_PICTURE"]["HEIGHT"]?>"
								alt="<?=$arElement["PREVIEW_PICTURE"]["ALT"]?>"
								title="<?=$arElement["PREVIEW_PICTURE"]["TITLE"]?>"
								/></a>
					<?elseif(is_array($arElement["DETAIL_PICTURE"])):?>
						<a href="<?=$arElement["DETAIL_PAGE_URL"]?>" target="_blank"><img
								border="0"
								src="<?=$arElement["DETAIL_PICTURE"]["SRC"]?>"
								width="<?=$arElement["DETAIL_PICTURE"]["WIDTH"]?>"
								height="<?=$arElement["DETAIL_PICTURE"]["HEIGHT"]?>"
								alt="<?=$arElement["DETAIL_PICTURE"]["ALT"]?>"
								title="<?=$arElement["DETAIL_PICTURE"]["TITLE"]?>"
								/></a>
					<?endif?>
					</aside>
					<header>
					<a href="<?=$arElement["DETAIL_PAGE_URL"]?>">"<?=$arElement["NAME"]?>"</a>
					<?/*foreach($arElement["DISPLAY_PROPERTIES"] as $id=>$value):?>
						<div class="ww-<?=$id?>"><span><?=$value["NAME"]?>:</span><?=$value["VALUE"];?></div>
					<?endforeach;*/?>
					<?if($arElement["DISPLAY_PROPERTIES"]["WEIGHT"]["VALUE"]):?>
						<div class="ww-weight"><?=$arElement["DISPLAY_PROPERTIES"]["WEIGHT"]["NAME"]?>:&nbsp;<span><?=$arElement["DISPLAY_PROPERTIES"]["WEIGHT"]["VALUE"];?> кг.</div>
					<?endif;?>
					<?if($arElement["DISPLAY_PROPERTIES"]["PRICE_BASE"]["VALUE"]):?>
						<div class="ww-price"><?=$arElement["DISPLAY_PROPERTIES"]["PRICE_BASE"]["NAME"]?>:&nbsp;<span>от <?=$arElement["DISPLAY_PROPERTIES"]["PRICE_BASE"]["VALUE"];?>&nbsp;руб/кг</span></div>
					<?endif;?>
					</header>
		</article>
		<?endforeach; // foreach($arResult["ITEMS"] as $arElement):?>

</section>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
<?//r($arResult[DISPLAY_PROPERTIES]);?>
</div>
<?endif;?>