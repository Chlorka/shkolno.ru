<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (isset($_REQUEST['ajax_cart'])) {
	$APPLICATION->RestartBuffer();
	
	if ($arResult["ALL_QUANTITY"] > 0):?>
	�� ����� <?=$arResult["ALL_PRICE_FORMAT"]?>
	<?else:?>
	� ������� ��� �������
	<?endif;
	
	die();
}
