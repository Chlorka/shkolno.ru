<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]) {
	$this->__component->SetResultCacheKeys(array("DISPLAY_ACTIVE_FROM"));
}

$arResult = array_merge($arResult, $arResult["FIELDS"]);
unset($arResult["FIELDS"]);