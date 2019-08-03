<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
?>
<?if (isset($_REQUEST["ajax_call"])) {
    $APPLICATION->RestartBuffer();
}?>
<div id="ww-bask">
	<?//r($_REQUEST);?>
	<?$APPLICATION->IncludeComponent(
	"yenisite:catalog.basket", 
	"order", 
	array(
		"PROPERTY_CODE" => array(
			0 => "FIO",
			1 => "FIO_CIHLDREN",
			2 => "PHONE",
			3 => "SCHOOL",
			4 => "EMAIL",
			5 => "CLASS",
			6 => "DELIVERY_E",
			7 => "ABOUT",
			8 => "PAYMENT_E",
			9 => "COUNT",
		),
		"EVENT" => "SALE_ORDER",
		"EVENT_ADMIN" => "SALE_ORDER_ADMIN",
		"YENISITE_BS_FLY" => "",
		"THANK_URL" => "/account/cart/thank_you.php",
		"UE" => "р.",
		"ADMIN_MAIL" => "admin@email.ru",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"INCLUDE_JQUERY" => "N",
		"COLOR_SCHEME" => ($ys_options["color_scheme"]=="ice"?"blue":$ys_options["color_scheme"])
	),
	false
);?> 
</div>
<?
if (isset($_REQUEST["ajax_call"])) {
 die();
}
?> 
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
