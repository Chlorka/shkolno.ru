<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

$aMenuLinksExt=$APPLICATION->IncludeComponent("bitrix:menu.sections", "", array(
	"IS_SEF" => "Y",
	"SEF_BASE_URL" => "/catalog/",
	"SECTION_PAGE_URL" => "#SECTION_CODE#/",
	"DETAIL_PAGE_URL" => "#SECTION_CODE#/#ELEMENT_ID#",
	"IBLOCK_TYPE" => "catalog",
	"IBLOCK_ID" => "2",
	"DEPTH_LEVEL" => "2",
	"CACHE_TYPE" => "N",
	"CACHE_TIME" => "3600"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);
	$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>