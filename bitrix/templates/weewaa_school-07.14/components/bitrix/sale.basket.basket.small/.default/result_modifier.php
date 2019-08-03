<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CModule::IncludeModule("currency");

$arResult["ALL_QUANTITY"] = $arResult["ALL_PRICE"] = 0;

foreach ($arResult["ITEMS"] as $v) {
	if ($v["DELAY"]=="N" && $v["CAN_BUY"]=="Y") {
		$arResult["ALL_QUANTITY"] += $v["QUANTITY"];
		$arResult["ALL_PRICE"] += $v["PRICE"] * $v["QUANTITY"];
	}
}

$arResult["ALL_PRICE_FORMAT"] = CurrencyFormat($arResult["ALL_PRICE"], "RUB");

if (!function_exists('str_ending')) {
	function str_ending($number, $arEnds, $flag = true)
	{
		$result = '';
		if ($flag) {
			$result = $number . ' ';
		}
	
		$len = strlen($number);
		if ($len > 1 && substr($number, $len - 2, 1) == '1') {
			$result .= $arEnds[0];
		} else {
			$c = intval(substr($number, $len - 1, 1));
			if ($c == 0 || ($c >= 5)) {
				$result .= $arEnds[0];
			} elseif ($c == 1) {
				$result .= $arEnds[1];
			} else {
				$result .= $arEnds[2];
			}
		}
		
		return $result;
	}
}