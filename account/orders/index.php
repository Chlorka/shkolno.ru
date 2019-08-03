<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мои заказы");
?>
<?if (isset($_GET["ID"])) {

	if(CModule::IncludeModule("iblock"))
	   {
		$el = new CIBlockElement;

		$arLoadProductArray = Array(
		  "MODIFIED_BY"    => $USER->GetID(),
		  "ACTIVE"         => $_GET['action']
		 );

		$PRODUCT_ID = $_GET["ID"];
		$res = $el->Update($PRODUCT_ID, $arLoadProductArray);
	   }
    }?>
    <? $GLOBALS['arrFilter']['ACTIVE'] = array("Y","N"); ?>
 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"order-list", 
	array(
		"IBLOCK_TYPE" => "yenisite_market",
		"IBLOCK_ID" => "6",
		"NEWS_COUNT" => "100",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "arrFilter",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "DATE_CREATE",
			2 => "ACTIVE",
			3 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "FIO",
			1 => "STATUS",
			2 => "COUNT",
			3 => "AMOUNT",
			4 => "DELIVERY_E",
			5 => "PAYMENT_E",
			6 => "",
		),
		"CHECK_DATES" => "N",
		"DETAIL_URL" => "/account/orders/detail_new/?ORDER=#ELEMENT_ID#",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"PAGER_TEMPLATE" => "",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?> 
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
