<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]) {
	$str = '<span class="pm-news-detail-date">'.$arResult["DISPLAY_ACTIVE_FROM"].'</span>';
	$APPLICATION->SetPageProperty('HEADER.BEFORE', $str);
}
