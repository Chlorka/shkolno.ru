<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (isset($_REQUEST['ajax_cart'])) {
	$APPLICATION->RestartBuffer();
	
	if ($arResult["ALL_QUANTITY"] > 0):?>
	на сумму <?=$arResult["ALL_PRICE_FORMAT"]?>
	<?else:?>
	В корзине нет товаров
	<?endif;
	
	die();
}
