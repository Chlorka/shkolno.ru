<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if($arParams['INCLUDE_JQUERY'] != 'N')
	CJSCore::Init(array("jquery"));
?>
<?//r($arResult["ITEMS"]);?>
  <?foreach($arResult["ITEMS"] as $k=>&$arItem):?>
	<?$db_props = CIBlockElement::GetProperty($arItem['FIELDS']['IBLOCK_ID'] , $arItem['ID'], array("sort" => "asc"), Array("CODE"=>"ARTICLE"));
		if($ar_props = $db_props->Fetch())
			$arItem['DISPLAY_PROP']['ARTICLE']=$ar_props['VALUE'];?>
			
  	<?$res = CIBlockElement::GetProperty($arItem['FIELDS']['IBLOCK_ID'] , $arItem['ID'], array("enum_sort" => "asc"), Array("CODE"=>"SIZE"));
		 while ($ob = $res->GetNext())
    {
    	//r($ob);
    	if($ob['VALUE_ENUM'])
		$arItem['DISPLAY_PROP']['SIZE'][$ob['VALUE']] = $ob['VALUE_ENUM'];
    }
    ?>
  		
  		<?//r($arItem);?>
  <?endforeach;?>
  <?unset($arItem);?>
<?//r($arResult["DISPLAY_PROPERTIES"]);?>