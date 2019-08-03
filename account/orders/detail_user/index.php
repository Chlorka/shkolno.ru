<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Печать для клиента");
?>
<?$APPLICATION->IncludeComponent(
	"yenisite:order.detail", 
	"print-order-user_new", 
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
			11 => "ITEMS",
			12 => "INDEX",
			13 => "TOWN",
			14 => "PAYMENT_E",
			15 => "PAY_STATYS",
			16 => "OPLATA",
			17 => "STATUS",
			18 => "TIME",
			19 => "MANAGER",
			20 => "COUNT",
			21 => "ARR",
			22 => "COMMENTS",
			23 => "AMOUNT",
		),
		"EVENT" => "SALE_ORDER",
		"EVENT_ADMIN" => "SALE_ORDER_ADMIN",
		"YENISITE_BS_FLY" => "",
		"THANK_URL" => "/account/cart/thank_you.php",
		"UE" => "Р",
		"ADMIN_MAIL" => "admin@email.ru",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"INCLUDE_JQUERY" => "N",
		"COLOR_SCHEME" => ($ys_options["color_scheme"]=="ice"?"blue":$ys_options["color_scheme"])
	),
	false
);?> 

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>