<?

function r($arr)
{
	if ($GLOBALS["USER"]->GetLogin() == 'weewaa') {
		echo '<pre>' . print_r($arr, true) . '</pre>';
	}
}

function rr($arr)
{
	echo '<pre>' . print_r($arr, true) . '</pre>';
}

function pmcache($func)
{
	$args = func_get_args();
	array_shift($args);
	
	if (strpos($func, '::') !== false) {
		$func = explode('::', $func);
	}
	
	$obCache = new CPHPCache; 
	$CACHE_TIME = 360000000; 
	$strCacheID = serialize($args);
	$sCustomCachePath = SITE_ID . '/' . __FUNCTION__ . '/' . implode('/', (array)$func);
	if ($obCache->StartDataCache($CACHE_TIME, $strCacheID, $sCustomCachePath)) {
	   if ($CACHE_TIME && defined('BX_COMP_MANAGED_CACHE')) { 
	      $GLOBALS['CACHE_MANAGER']->StartTagCache($sCustomCachePath); 
	   }
	   $array = call_user_func_array($func, $args);
	   if ($CACHE_TIME && defined('BX_COMP_MANAGED_CACHE')) { 
	      $GLOBALS['CACHE_MANAGER']->EndTagCache(); 
	   }
	   $obCache->EndDataCache($array); 
	} else { 
	   $array = $obCache->GetVars();
	}
	
	return $array;
}
/*
AddEventHandler('main', 'OnBeforeEventSend', Array("MyForm", "my_OnBeforeEventSend"));
class MyForm
{
   function my_OnBeforeEventSend($arFields, $arTemplate)
   {

        if($arTemplate["ID"]==28) {
        ob_start();
		$GLOBALS["APPLICATION"]->IncludeComponent("yenisite:order.detail", ".default", array(
		"ORDER_ID"=>30,
	"PROPERTY_CODE" => array(
		0 => "FIO",
		1 => "EMAIL",
		2 => "PHONE",
		3 => "DELIVERY_E",
		4 => "ABOUT",
		5 => "PAYMENT_E",
		6 => "PAY_STATYS",
		7 => "TIME",
	),
	"EVENT" => "SALE_ORDER",
	"EVENT_ADMIN" => "SALE_ORDER_ADMIN",
	"YENISITE_BS_FLY" => "",
	"THANK_URL" => "/account/cart/thank_you.php",
	"UE" => "Ð",
	"ADMIN_MAIL" => "admin@email.ru",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "3600",
	"INCLUDE_JQUERY" => "N",
	"COLOR_SCHEME" => ($ys_options["color_scheme"]=="ice"?"blue":$ys_options["color_scheme"])
	),
	false
);
		$html = ob_get_clean();
		unset($_SESSION['ORDERS']);
		// $_SESSION['ORDERS'][]=$arFields;
        $_SESSION['ORDERS'] = $html;
			CEvent::Send("test", "s1", array(
				"ORDER_USER" => $arFields["ORDER_USER"],
				"ORDER_ID" => $arFields["ORDER_ID"],
				"ORDER_DATE" => $arFields["ORDER_DATE"],
				"PRICE" => $arFields["PRICE"],
				"SALE_EMAIL" => $arFields["SALE_EMAIL"],
				"ORDER_LIST" => $html,
				// "EMAIL_TO" => isset($send) && strlen($send) ? $send : 'xbelje@gmail.com',
				// "LINK" => str_replace(array('#ID#'), array($arFields["ORDER_ID"]), 'http://' . SITE_SERVER_NAME . SITE_DIR . 'mail/mail.php?id=#ID#'),
				"USER_DESCRIPTION" => $comment
			));
		}	
   }
}*/
function ClearCSSCache()
{
    DeleteDirFilesEx('/bitrix/cache/');
    DeleteDirFilesEx('/bitrix/managed_cache/MYSQL/');
    return "ClearCSSCache();";
}
?>