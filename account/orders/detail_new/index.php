<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Ваш заказ");
?>


<?if (isset($_REQUEST["ajax_call"])) {
    $APPLICATION->RestartBuffer();
}?>
<div id="ww-bask">
	<?//r($_REQUEST);?>
	<?$APPLICATION->IncludeComponent(
	"yenisite:order.detail", 
	"detail-order-new", 
	array(
		"PROPERTY_CODE" => array(
			0 => "POSHIV",
			1 => "ADD_GOODS",
			2 => "FIO",
			3 => "FIO_CIHLDREN",
			4 => "PHONE",
			5 => "SCHOOL",
			6 => "EMAIL",
			7 => "CLASS",
			8 => "DELIVERY_E",
			9 => "ABOUT",
			10 => "DELIVERY_PRICE",
			11 => "PAYMENT_E",
			12 => "PAY_STATYS",
			13 => "OPLATA",
			14 => "STATUS",
			15 => "TIME",
			16 => "MANAGER",
			17 => "COUNT",
			18 => "COMMENTS",
			19 => "AMOUNT",
		),
		"EVENT" => "SALE_ORDER",
		"EVENT_ADMIN" => "SALE_ORDER_ADMIN",
		"YENISITE_BS_FLY" => "",
		"THANK_URL" => "/account/cart/thank_you.php",
		"UE" => "Р",
		"ADMIN_MAIL" => "viperrt10@mail.ru",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "0",
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