<?foreach($arResult["ITEMS"] as &$arItem):
//r($arItem);
if ($arItem['PREVIEW_PICTURE']['ID'] > 0) {
	
	$arItem["PREVIEW_PICTURE"] = array_change_key_case(CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array("width"=>165, "height"=>295), BX_RESIZE_IMAGE_PROPORTIONAL, true), CASE_UPPER);
}
endforeach;
unset($arItem);?> 

<?if(CModule::IncludeModule("iblock"))
   {}
?> 