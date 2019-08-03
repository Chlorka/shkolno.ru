<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);?>

<?
$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);
?><div id="ww-catalog_item-detail"><?
	reset($arResult['MORE_PHOTO']);
$arFirstPhoto = current($arResult['MORE_PHOTO']);?>
	<article>
		<aside>
			<a href="<?=$arResult["DETAIL_PICTURE"]['SRC']; ?>" 
				alt="<? echo $strAlt; ?>"
				class="fancy" rel="imgs" id="prev_pict">
					<img
					id="image_<? echo $arItemIDs['PICT']; ?>"
					src="<?=$arResult["DETAIL_PICTURE_LARGE"]['SRC']; ?>"
					alt="<? echo $strAlt; ?>"
					title="<? echo $strTitle; ?>"
				>
			</a>
			
			<section id="ww-catalog_item-detail_photos">
				<?foreach($arResult["MORE_PHOTO_MINI"] as $key=>$photo):?>
					<a class="fancy" rel="imgs" id="img<?=$key;?>" href="<?=$arResult["MORE_PHOTO"][$key]['SRC']; ?>" rel="photos">
						<img
							src="<? echo $photo['SRC']; ?>"
							alt="<? echo $strAlt; ?>"
							title="<? echo $strTitle; ?>"
						>
				</a>
				<?endforeach;?>
			</section>
		</aside>
		<section>
			<header>
				<h2>
				<?if ('Y' == $arParams['DISPLAY_NAME'])
					{
					?>
					<? echo (
								isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
								? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
								: $arResult["NAME"]
							); ?>
					<?
					}?>
				</h2>
			</header>
            <?if($arResult["DISPLAY_PROPERTIES"]["ACTION"]["VALUE"][0] == 'Да'):?>
                <i class="action_icon"></i>
            <?endif;?>
            <?if($arResult["DISPLAY_PROPERTIES"]["SCLAD"]["VALUE"][0] == 'Да' && $arResult["DISPLAY_PROPERTIES"]["ACTION"]["VALUE"][0] == 'Да'):?>
                <i class="sclad_icon_"></i>
            <?elseif($arResult["DISPLAY_PROPERTIES"]["SCLAD"]["VALUE"][0] == 'Да'):?>
                <i class="sclad_icon"></i>
            <?endif;?>

            <section class="ww-catalog_item-detail_prop">
				<?if (!empty($arResult['DISPLAY_PROPERTIES']))
					{?>
						<?foreach ($arResult['DISPLAY_PROPERTIES'] as $key=>$arOneProp)
						{
							 if($key!='PRICE_BASE' && $key!='SIZE'  && $key!='ACTION' && $key!='SCLAD' && $key!='PRICE_TEXT' && $key!='GOODS'):?>
								<span><? echo $arOneProp['NAME']; ?>:&nbsp;</span><?
									echo '', (
										is_array($arOneProp['DISPLAY_VALUE'])
										? implode(' / ', $arOneProp['DISPLAY_VALUE'])
										: $arOneProp['DISPLAY_VALUE']
									), '<br>';
							 endif;
						}
						unset($arOneProp);?>
				<?}?>
				</section>
						<p class="ww-catalog_item-detail_text">
							<?=$arResult['DETAIL_TEXT'];?>
						</p>
				<section class="ww-catalog_item-detail_prop">
					<span>Размеры, доступные для данного товара:&nbsp;</span>
									<?echo '', (
										is_array($arResult['DISPLAY_PROPERTIES']['SIZE']['DISPLAY_VALUE'])
										? implode(', ', $arResult['DISPLAY_PROPERTIES']['SIZE']['DISPLAY_VALUE'])
										: $arResult['DISPLAY_PROPERTIES']['SIZE']['DISPLAY_VALUE']
									), '<br>';?>		
					<a href="/opredelit-razmer/">Как определить размер ребенка</a>
				</section>

<?if($arResult["DISPLAY_PROPERTIES"]["PRICE_TEXT"]["VALUE"]):?>
   <?/*?> <p class="catalog-price"><?=$arResult["DISPLAY_PROPERTIES"]["PRICE_TEXT"]["VALUE"].' р.'?></p><?*/?>
<?elseif($arResult["DISPLAY_PROPERTIES"]["PRICE_BASE"]["VALUE"]>0):?>


	<?if(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"])):?>
		<?foreach($arResult["OFFERS"] as $arOffer):?>
			<?foreach($arParams["OFFERS_FIELD_CODE"] as $field_code):?>
				<small><?echo GetMessage("IBLOCK_FIELD_".$field_code)?>:&nbsp;<?
						echo $arOffer[$field_code];?></small><br />
			<?endforeach;?>
			<?foreach($arOffer["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
				<small><?=$arProperty["NAME"]?>:&nbsp;<?
					if(is_array($arProperty["DISPLAY_VALUE"]))
						echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
					else
						echo $arProperty["DISPLAY_VALUE"];?></small><br />
			<?endforeach?>
			<?foreach($arOffer["PRICES"] as $code=>$arPrice):?>
				<?if($arPrice["CAN_ACCESS"]):?>
					<p class="catalog-price"><?=$arResult["CAT_PRICES"][$code]["TITLE"];?>:&nbsp;&nbsp;
					<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
						<s><?=$arPrice["PRINT_VALUE"]?></s> <span class="catalog-price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span>
					<?else:?>
						<?=$arPrice["PRINT_VALUE"]?>&nbsp;р.
					<?endif?>
					</p>
				<?endif;?>
			<?endforeach;?>
			<p>
			<?if($arParams["DISPLAY_COMPARE"]):?>
				<noindex>
				<a href="<?echo $arOffer["COMPARE_URL"]?>" rel="nofollow"><?echo GetMessage("CT_BCE_CATALOG_COMPARE")?></a>&nbsp;
				</noindex>
			<?endif?>
			<?if($arOffer["CAN_BUY"]):?>
				<?if($arParams["USE_PRODUCT_QUANTITY"]):?>
					<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">
					<table border="0" cellspacing="0" cellpadding="2">
						<tr valign="top">
							<td><?echo GetMessage("CT_BCE_QUANTITY")?>:</td>
							<td>
								<input type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="1" size="5">
							</td>
						</tr>
					</table>
					<input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="BUY">
					<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arOffer["ID"]?>">
					<input type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."BUY"?>" value="<?echo GetMessage("CATALOG_BUY")?>">
					<input type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value="<?echo GetMessage("CT_BCE_CATALOG_ADD")?>">
					</form>
				<?else:?>
					<noindex>
					<a href="<?echo $arOffer["BUY_URL"]?>" rel="nofollow"><?echo GetMessage("CATALOG_BUY")?></a>
					&nbsp;<a href="<?echo $arOffer["ADD_URL"]?>" rel="nofollow"><?echo GetMessage("CT_BCE_CATALOG_ADD")?></a>
					</noindex>
				<?endif;?>
			<?elseif(count($arResult["CAT_PRICES"]) > 0):?>
				<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
				<?$APPLICATION->IncludeComponent("bitrix:sale.notice.product", ".default", array(
					"NOTIFY_ID" => $arOffer['ID'],
					"NOTIFY_URL" => htmlspecialcharsback($arOffer["SUBSCRIBE_URL"]),
					"NOTIFY_USE_CAPTHA" => "N"
					),
					$component
				);?>
			<?endif?>
			</p>
		<?endforeach;?>
	<?else:?>
		<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
			<?if($arPrice["CAN_ACCESS"]):?>
				<p class="catalog-price"><?=$arResult["CAT_PRICES"][$code]["TITLE"];?>:
				<?if($arParams["PRICE_VAT_SHOW_VALUE"] && ($arPrice["VATRATE_VALUE"] > 0)):?>
					<?if($arParams["PRICE_VAT_INCLUDE"]):?>
						(<?echo GetMessage("CATALOG_PRICE_VAT")?>)
					<?else:?>
						(<?echo GetMessage("CATALOG_PRICE_NOVAT")?>)
					<?endif?>
				<?endif;?>
				<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
					<s><?=$arPrice["PRINT_VALUE"]?></s> <span class="catalog-price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span>
					<?if($arParams["PRICE_VAT_SHOW_VALUE"]):?><br />
						<?=GetMessage("CATALOG_VAT")?>:&nbsp;&nbsp;<span class="catalog-vat catalog-price"><?=$arPrice["DISCOUNT_VATRATE_VALUE"] > 0 ? $arPrice["PRINT_DISCOUNT_VATRATE_VALUE"] : GetMessage("CATALOG_NO_VAT")?></span>
					<?endif;?>
				<?else:?>
				<?=$arPrice["PRINT_VALUE"]?>р.
					<?if($arParams["PRICE_VAT_SHOW_VALUE"]):?><br />
						<?=GetMessage("CATALOG_VAT")?>:&nbsp;&nbsp;<span class="catalog-vat catalog-price"><?=$arPrice["VATRATE_VALUE"] > 0 ? $arPrice["PRINT_VATRATE_VALUE"] : GetMessage("CATALOG_NO_VAT")?></span>
					<?endif;?>
				<?endif?>
				<?/*?><a href="javascript:void(0)" id="ww-in-bask">В корзину</a><?*/?>
				</p>
			<?endif;?>
		<?endforeach;?>
		<?if(is_array($arResult["PRICE_MATRIX"])):?>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data-table">
			<thead>
			<tr>
				<?if(count($arResult["PRICE_MATRIX"]["ROWS"]) >= 1 && ($arResult["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_FROM"] > 0 || $arResult["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_TO"] > 0)):?>
					<td><?= GetMessage("CATALOG_QUANTITY") ?></td>
				<?endif;?>
				<?foreach($arResult["PRICE_MATRIX"]["COLS"] as $typeID => $arType):?>
					<td><?= $arType["NAME_LANG"] ?></td>
				<?endforeach?>
			</tr>
			</thead>
			<?foreach ($arResult["PRICE_MATRIX"]["ROWS"] as $ind => $arQuantity):?>
			<tr>
				<?if(count($arResult["PRICE_MATRIX"]["ROWS"]) > 1 || count($arResult["PRICE_MATRIX"]["ROWS"]) == 1 && ($arResult["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_FROM"] > 0 || $arResult["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_TO"] > 0)):?>
					<th nowrap>
						<?if(IntVal($arQuantity["QUANTITY_FROM"]) > 0 && IntVal($arQuantity["QUANTITY_TO"]) > 0)
							echo str_replace("#FROM#", $arQuantity["QUANTITY_FROM"], str_replace("#TO#", $arQuantity["QUANTITY_TO"], GetMessage("CATALOG_QUANTITY_FROM_TO")));
						elseif(IntVal($arQuantity["QUANTITY_FROM"]) > 0)
							echo str_replace("#FROM#", $arQuantity["QUANTITY_FROM"], GetMessage("CATALOG_QUANTITY_FROM"));
						elseif(IntVal($arQuantity["QUANTITY_TO"]) > 0)
							echo str_replace("#TO#", $arQuantity["QUANTITY_TO"], GetMessage("CATALOG_QUANTITY_TO"));
						?>
					</th>
				<?endif;?>
				<?foreach($arResult["PRICE_MATRIX"]["COLS"] as $typeID => $arType):?>
					<td>
						<?if($arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["DISCOUNT_PRICE"] < $arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["PRICE"])
							echo '<s>'.FormatCurrency($arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["PRICE"], $arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["CURRENCY"]).'</s> <span class="catalog-price">'.FormatCurrency($arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["DISCOUNT_PRICE"], $arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["CURRENCY"])."</span>";
						else
							echo '<span class="catalog-price">'.FormatCurrency($arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["PRICE"], $arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["CURRENCY"])."</span>";
						?>
					</td>
				<?endforeach?>
			</tr>
			<?endforeach?>
			</table>
			<?if($arParams["PRICE_VAT_SHOW_VALUE"]):?>
				<?if($arParams["PRICE_VAT_INCLUDE"]):?>
					<small><?=GetMessage('CATALOG_VAT_INCLUDED')?></small>
				<?else:?>
					<small><?=GetMessage('CATALOG_VAT_NOT_INCLUDED')?></small>
				<?endif?>
			<?endif;?><br />
		<?endif?>

		<section id="ww-area_order"> 
		<?if(!$arResult["CAN_BUY"]):?>
			<?if($arParams["USE_PRODUCT_QUANTITY"] || count($arResult["PRODUCT_PROPERTIES"])):?>
			<section id="ww-form_order" style="<?if($_GET['quantity']>1):?>display: block;<?else:?>display: none;<?endif;?>">
				<header><?=$arResult["NAME"];?></header>
				<section>
				<form action="" id="ww-form" method="post" enctype="multipart/form-data">
				
				<table border="0" cellspacing="0" cellpadding="2">
				<?if($arParams["USE_PRODUCT_QUANTITY"]):?>
					<tr>
						<td><?echo GetMessage("CT_BCE_QUANTITY")?>:</td>
						<td>
							<div class="ww-input-count">
								<input type="text" size="5" value="<?if($_GET['quantity']>1):?><?=$_GET['quantity']?><?else:?>1<?endif;?>" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" class="cntval<?=$arResult["ID"];?>">
								<a class="val<?=$arResult["ID"];?>" id="up" href="javascript:void(0)"><span></span></a>
								<a class="val<?=$arResult["ID"];?>" id="down" href="javascript:void(0)"><span></span></a>
							</div>
						</td>
					</tr>
				<?endif;?>
				<tr><td colspan="2" class="ww-discription"><span>Выберите размер для каждой еденицы:</span></td></tr>
				<?foreach($arResult["PRODUCT_PROPERTIES"] as $pid => $product_property):?>
					<tr>
						<td valign="top"><?echo $arResult["PROPERTIES"][$pid]["NAME"]?>:</td>
						<td id="ww-size_list">
						<?if(
							$arResult["PROPERTIES"][$pid]["PROPERTY_TYPE"] == "L"
							&& $arResult["PROPERTIES"][$pid]["LIST_TYPE"] == "C"
						):?>
							<?if($_GET['quantity']>0) $cnt=$_GET['quantity']; else $cnt=1;?>
						<?for($i=1; $i<=$cnt; $i++) {?>		
							<div class="ww-ul-size" id="size<?=$i?>">
								<span class="arr_bg"></span>
								<span class="text_head">(размеры)</span>
								<ul class="dropdown no-show">
									<?foreach($product_property["VALUES"] as $k => $v):?>
										<li><label><input type="radio" alt="<?echo $v?>" name="<?echo $arParams["PRODUCT_PROPS_VARIABLE"]?>[<?echo $pid?>]" value="<?echo $k?>" <?if($k == $product_property["SELECTED"]) echo '"checked"'?>><?echo $v?></label></li>
									<?endforeach;?>
								</ul>
							</div>
							<input type="hidden" value="" class="item-size" name="<?echo $arParams[PRODUCT_PROPS_VARIABLE]?>[SIZES][<?=$i?>]"> 									
						<?}?>
							<?/*else:?>
						<div class="ww-ul-size" id="size0">
							<span class="arr_bg"></span>
							<span class="text_head">(размеры)</span>
							<ul class="dropdown no-show">
								<?foreach($product_property["VALUES"] as $k => $v):?>
									<li><label><input type="radio" alt="<?echo $v?>" name="<?echo $arParams["PRODUCT_PROPS_VARIABLE"]?>[<?echo $pid?>]" value="<?echo $k?>" <?if($k == $product_property["SELECTED"]) echo '"checked"'?>><?echo $v?></label></li>
								<?endforeach;?>
							</ul>
						</div>
						<input type="hidden" value="" name="<?echo $arParams[PRODUCT_PROPS_VARIABLE]?>[SIZES][0]"> 			
							<?endif;*/?>
						<?else:?>
							<select name="<?echo $arParams["PRODUCT_PROPS_VARIABLE"]?>[<?echo $pid?>]">
								<?foreach($product_property["VALUES"] as $k => $v):?>
									<option value="<?echo $k?>" <?if($k == $product_property["SELECTED"]) echo '"selected"'?>><?echo $v?></option>
								<?endforeach;?>
							</select>
						<?endif;?>
						</td>
					</tr>
					<?if($_GET['quantity']>=7):?>
					<tr>
						<td colspan="2">
							<p class="ww-alert-text">Заказать можно не более 7 шт.<br>
								Для заказа большего количества - свжитесь с нашим менеджором по телефону.
							</p>
						</td>
					</tr>
					<?endif;?>
						
				<?endforeach;?>
				</table>
				<?if($_GET['quantity']>0) $cnt=$_GET['quantity']; else $cnt=1;?>
					<?for($i=1; $i<=$cnt; $i++) {?>	
				<?/*if($_GET['quantity']>0):?>
					<?for($i=0; $i<$_GET['quantity']; $i++){*/?>
						<input type="hidden" size="5" value="1" name="cnt[<?=$i?>]" class="item_cnt">
					<?}?>
				<?/*else:?>
				<input type="hidden" size="5" value="1" name="cnt[0]">
				<?endif;*/?>
				<?/*?><input type="hidden" name="ajax_bt" value="Y"><?*/?>
				<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arResult["ID"]?>">
				<input type="submit" value="send" name="name" style="display: none;">
				<?/*?><input type="submit" id="ww-sub_bye" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value="В корзину"><?*/?>
				<a class="ww-button" href="javascript:void(0)" id="ww-sub_bye">В корзину</a>
				
				<a class="ww-button" href="javascript:void(0)" id="ww-chancel">Отменить</a>
				
				</form>
				</section>
			</section>
			<?else:?>
				<noindex>
				<a href="<?echo $arResult["BUY_URL"]?>" rel="nofollow"><?echo GetMessage("CATALOG_BUY")?></a>
				&nbsp;<a href="<?echo $arResult["ADD_URL"]?>" rel="nofollow"><?echo GetMessage("CATALOG_ADD_TO_BASKET")?></a>
				</noindex>
			<?endif;?>
		<?elseif((count($arResult["PRICES"]) > 0) || is_array($arResult["PRICE_MATRIX"])):?>
			<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
			<?$APPLICATION->IncludeComponent("bitrix:sale.notice.product", ".default", array(
				"NOTIFY_ID" => $arResult['ID'],
				"NOTIFY_URL" => htmlspecialcharsback($arResult["SUBSCRIBE_URL"]),
				"NOTIFY_USE_CAPTHA" => "N"
				),
				$component
			);?>
			
		<?endif?>
		</section>
	<?endif?>

<?endif;?>
            <?/*?>
		<div id="ww-ss">
				<?if (isset($_GET["ajax_basket"])) {
				$APPLICATION->RestartBuffer();
				}?>
				<?r($_GET);?>
					<?$APPLICATION->IncludeComponent(
						"yenisite:catalog.basket.small",
						"basket",
						Array(
						)
					);?>
			<?if (isset($_GET["ajax_basket"])) {
				 die();
				}
			?>
			</div>
	<?*/?>
		</section>	
		
		<?//r($arResult['DISPLAY_PROPERTIES']['GOODS']['VALUE']);?>
<?if(count($arResult['DISPLAY_PROPERTIES']['GOODS']['VALUE'])>0):?>
<?$GLOBALS['arFilter_goods']['ID'] = $arResult['DISPLAY_PROPERTIES']['GOODS']['VALUE'];?>	
<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "board", array(
	"IBLOCK_TYPE" => "catalog",
	"IBLOCK_ID" => "2",
	"SECTION_ID" => "",
	"SECTION_CODE" => "",
	"SECTION_USER_FIELDS" => array(
		0 => "",
		1 => "",
	),
	"ELEMENT_SORT_FIELD" => "sort",
	"ELEMENT_SORT_ORDER" => "desc",
	"ELEMENT_SORT_FIELD2" => "id",
	"ELEMENT_SORT_ORDER2" => "desc",
	"FILTER_NAME" => "arFilter_goods",
	"INCLUDE_SUBSECTIONS" => "Y",
	"SHOW_ALL_WO_SECTION" => "Y",
	"PAGE_ELEMENT_COUNT" => "2",
	"LINE_ELEMENT_COUNT" => "2",
	"PROPERTY_CODE" => array(
		0 => "COLOR",
		1 => "ARTICLE",
		2 => "PRICE_BASE",
		3 => "",
		4 => "",
	),
	"OFFERS_LIMIT" => "",
	"TEMPLATE_THEME" => "",
	"ADD_PICT_PROP" => "-",
	"LABEL_PROP" => "-",
	"MESS_BTN_BUY" => $arParams["MESS_BTN_BUY"],
	"MESS_BTN_ADD_TO_BASKET" => $arParams["MESS_BTN_ADD_TO_BASKET"],
	"MESS_BTN_SUBSCRIBE" => $arParams["MESS_BTN_SUBSCRIBE"],
	"MESS_BTN_DETAIL" => $arParams["MESS_BTN_DETAIL"],
	"MESS_NOT_AVAILABLE" => $arParams["MESS_NOT_AVAILABLE"],
	"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
	"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
	"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_GROUPS" => "N",
	"SET_META_KEYWORDS" => "N",
	"META_KEYWORDS" => "",
	"SET_META_DESCRIPTION" => "N",
	"META_DESCRIPTION" => "",
	"BROWSER_TITLE" => "-",
	"ADD_SECTIONS_CHAIN" => "N",
	"DISPLAY_COMPARE" => "N",
	"SET_TITLE" => "N",
	"SET_STATUS_404" => "N",
	"CACHE_FILTER" => "N",
	"PRICE_CODE" => array(
	),
	"USE_PRICE_COUNT" => "N",
	"SHOW_PRICE_COUNT" => "1",
	"PRICE_VAT_INCLUDE" => "N",
	"BASKET_URL" => "",
	"ACTION_VARIABLE" => "",
	"PRODUCT_ID_VARIABLE" => "",
	"USE_PRODUCT_QUANTITY" => "N",
	"ADD_PROPERTIES_TO_BASKET" => "N",
	"PAGER_TEMPLATE" => "",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "N",
	"PAGER_TITLE" => "",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "",
	"PAGER_SHOW_ALL" => "N",
	"AJAX_OPTION_ADDITIONAL" => "",
	"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
	"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
	"PARTIAL_PRODUCT_PROPERTIES" => "N",
	"PRODUCT_PROPERTIES" => array(
	)
	),
	$component
);?>	
<?endif;?>
	</article>
</div>