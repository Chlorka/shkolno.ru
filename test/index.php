<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тестовый");
?><p>
	В разработке
</p>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.filter",
	"",
	Array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"FILTER_NAME" => "arrFilter",
		"FIELD_CODE" => array("",""),
		"PROPERTY_CODE" => array("TYPE",""),
		"LIST_HEIGHT" => "5",
		"TEXT_WIDTH" => "20",
		"NUMBER_WIDTH" => "5",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"SAVE_IN_SESSION" => "N",
		"PRICE_CODE" => array()
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>