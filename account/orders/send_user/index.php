<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отправить пользователю");
?>
<?if (isset($_GET["ajax_call"])) {
        $APPLICATION->RestartBuffer();
    }?> 
<?ob_start();?>
<?$APPLICATION->IncludeComponent("yenisite:order.detail", "send-order-user", array(
	"E-MAIL"=>$_REQUEST['MAIL'], 
	"ORDER"=>$_REQUEST['ORDER'],
	"PROPERTY_CODE" => array(
		0 => "FIO",
		1 => "EMAIL",
		2 => "PHONE",
		3 => "INDEX",
		4 => "TOWN",
		5 => "ADRESS",
		6 => "DELIVERY_E",
		7 => "ABOUT",
		8 => "PAYMENT_E",
		9 => "PAY_STATYS",
		10 => "TIME",
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
<?
$html = ob_get_clean();

			CEvent::Send("SEND_USER_MAIL", "s1", array(	
			"ORDER_LIST" => $html,
			"EMAIL_TO" => $_REQUEST['MAIL'] 
			));
?>
<?
/*if($_REQUEST['send']!=Y)
	LocalRedirect('/account/orders/send_user/?ORDER='.$_REQUEST['ORDER'].'Y&send=Y&mail='.$_REQUEST['MAIL']);*/
?>
Письмо отправлено, оно будет доставлено на указанны клиентом E-mail.
<?
if (isset($_GET["ajax_call"])) {
 die();
}
?> 
<?//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>