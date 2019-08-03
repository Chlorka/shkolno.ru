<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(empty($arResult))
	return "";

$strReturn = '<ul>';

for($index = 0, $itemSize = count($arResult); $index < $itemSize; $index++) {
	if($index > 0)
		$strReturn .= '<li>&nbsp;/&nbsp;</span></li>';

	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	if($arResult[$index]["LINK"] <> "" && count($arResult)!=($index+1)) {
		$strReturn .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="url"><span itemprop="title">'.$title.'</span></a></li>';
	}
	else {
		$strReturn .= '<li>'.$title.'</li>';
	}
}

$strReturn .= '</ul>';
return $strReturn;