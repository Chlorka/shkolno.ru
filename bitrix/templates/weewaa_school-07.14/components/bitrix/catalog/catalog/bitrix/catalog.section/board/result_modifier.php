<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach($arResult["ITEMS"] as $cell=>&$arElement):
$arFilter = Array('IBLOCK_ID'=>$arElement["IBLOCK_ID"], 'ID'=>$arElement["IBLOCK_SECTION_ID"]);
	$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, false, array("ID", "CODE"));
	while($ar_result = $db_list->GetNext())
	{
    	$arElement["DETAIL_PAGE_URL"] = '/catalog/'.$ar_result["CODE"].'/'.$arElement["ID"].'/';
	}
    /*$arElement["DETAIL_PAGE_URL"] = '/catalog/'..''.$arElement["ID"];*/
	// r($arElement["DETAIL_PAGE_URL"]);
endforeach;
unset($arElement);
?>
