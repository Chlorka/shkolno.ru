<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<section id="ww-catalog-section">
	<header>По отдельности:</header>
		<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
		<?
		$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
		?>
		<?if($cell%$arParams["LINE_ELEMENT_COUNT"] == 0):?>
		<section>
		<?endif;?>

		<article id="<?=$this->GetEditAreaId($arElement['ID']);?>">
					<a href="<?=$arElement["DETAIL_PAGE_URL"]?>">
						<aside>
					<?if(is_array($arElement["PREVIEW_PICTURE"])):?>
						<img
								border="0"
								src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>"
								width="<?=$arElement["PREVIEW_PICTURE"]["WIDTH"]?>"
								height="<?=$arElement["PREVIEW_PICTURE"]["HEIGHT"]?>"
								alt="<?=$arElement["PREVIEW_PICTURE"]["ALT"]?>"
								title="<?=$arElement["PREVIEW_PICTURE"]["TITLE"]?>"
								/>
					<?elseif(is_array($arElement["DETAIL_PICTURE"])):?>
						<img
								border="0"
								src="<?=$arElement["DETAIL_PICTURE"]["SRC"]?>"
								width="<?=$arElement["DETAIL_PICTURE"]["WIDTH"]?>"
								height="<?=$arElement["DETAIL_PICTURE"]["HEIGHT"]?>"
								alt="<?=$arElement["DETAIL_PICTURE"]["ALT"]?>"
								title="<?=$arElement["DETAIL_PICTURE"]["TITLE"]?>"
								/>
					<?endif?>
						<span><?=$arElement["DISPLAY_PROPERTIES"]["PRICE_BASE"]["VALUE"].'р.'?></span>
						</aside>
					<header><?=$arElement["NAME"]?></header>
					<section>
						<?foreach($arElement["DISPLAY_PROPERTIES"] as $pid=>$arProperty):
							if($pid!='PRICE_BASE'):
								echo ''.$arProperty["NAME"].':&nbsp;';
	
								if(is_array($arProperty["DISPLAY_VALUE"]))
									echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
								else
									echo $arProperty["DISPLAY_VALUE"];
							endif;?>
						<?endforeach?>
						<span>Заказать</span>
					</section>
					</a>
		</article>

		<?$cell++;
		if($cell%$arParams["LINE_ELEMENT_COUNT"] == 0):?>
			</section>
		<?endif?>

		<?endforeach; // foreach($arResult["ITEMS"] as $arElement):?>

		<?if($cell%$arParams["LINE_ELEMENT_COUNT"] != 0):?>
			<?while(($cell++)%$arParams["LINE_ELEMENT_COUNT"] != 0):?>
			<?endwhile;?>
			</section>
		<?endif?>

</section>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
