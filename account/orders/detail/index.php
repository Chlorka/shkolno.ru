<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказ");
?>
<?if (isset($_REQUEST["ajax_call"])) {
    $APPLICATION->RestartBuffer();
}?>
<div id="ww-bask">
	<?//r($_REQUEST);?>
	<?$APPLICATION->IncludeComponent("yenisite:order.detail", "detail-order", array(
	"PROPERTY_CODE" => array(
		0 => "FIO",
		1 => "EMAIL",
		2 => "PHONE",
		3 => "DELIVERY_E",
		4 => "INDEX",
		5 => "TOWN",
		6 => "ADRESS",
		7 => "ABOUT",
		8 => "PAYMENT_E",
		9 => "PAY_STATYS",
		10 => "STATUS",
		11 => "COMMENTS",
		12 => "TIME",
		13 => "MANAGER",
		14 => "COUNT",
	),
	"EVENT" => "SALE_ORDER",
	"EVENT_ADMIN" => "SALE_ORDER_ADMIN",
	"YENISITE_BS_FLY" => "",
	"THANK_URL" => "/account/cart/thank_you.php",
	"UE" => "Р",
	"ADMIN_MAIL" => "admin@email.ru",
	"CACHE_TYPE" => "N",
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