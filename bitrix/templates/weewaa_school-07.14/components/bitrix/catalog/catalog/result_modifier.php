<?
if(CModule::IncludeModule("iblock"))
   {
   if(isset($arResult["VARIABLES"]["SECTION_CODE"])) {
	$rsSect = CIBlockSection::GetList(array('ID' => 'asc'), array(
      'IBLOCK_ID' => $arParams['IBLOCK_ID'],
      "CODE"=>$arResult["VARIABLES"]["SECTION_CODE"]
    ), false, array("ID", "UF_SEO"));

    while($arSect = $rsSect->Fetch())
    {
    	$arResult["UF_SEO"] = $arSect["UF_SEO"];
	   	$nav = CIBlockSection::GetNavChain(IntVal($arParams["IBLOCK_ID"]), IntVal($arSect['ID']));
			while ($arNav=$nav->GetNext()):
				$arr_parent[]=$arNav;
				//r($arNav);
			endwhile;
    }
	//r($arr_parent);
	/*
	$arFilter = Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'], "CODE"=>$arResult["VARIABLES"]["SECTION_CODE"]);
	$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, false, array("ID", "UF_SEO"));
	while($ar_result = $db_list->GetNext())
	{
		$arResult["UF_SEO"]=$ar_result["UF_SEO"];
	}*/
	 
   }
   
$arResult["TREE_SECTIONS"]=$arr_parent;
if($arr_parent[0]['CODE']=='kollektsii' && isset($arr_parent[1]['CODE'])) {
	$property_enums = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "CODE"=>"COLLECTION"));
	while($enum_fields = $property_enums->GetNext())
	{
	  $arResult["COLLECTION"][$enum_fields["VALUE"]] = $enum_fields["ID"];
	}
				$arrSection = array();
				$arResult["LIST_SECTION_ELEMENTS"] = array();
				$arr_Select = Array("ID", "IBLOCK_SECTION_ID", "NAME");
				$arr_Filter = Array("IBLOCK_ID"=>IntVal($arParams['IBLOCK_ID']), "PROPERTY_COLLECTION_VALUE"=>$arr_parent[1]["NAME"], "SECTION_GLOBAL_ACTIVE"=>"Y", "ACTIVE"=>"Y");
				$arr_res = CIBlockElement::GetList(Array(), $arr_Filter, false, false, $arr_Select);
					while($ar_fields = $arr_res->GetNext())
					{
					 	$arrSection[$ar_fields["IBLOCK_SECTION_ID"]][] = $ar_fields["ID"];
						$arResult["LIST_SECTION_ELEMENTS"]["show_all"][] = $ar_fields["ID"];
					}
				$list_Section = array();
					foreach($arrSection as $key=>$value) {
						$sec_res = CIBlockSection::GetByID($key);
						if($ar_sec = $sec_res->GetNext()) {
							$list_Section[$ar_sec['NAME']]["CODE"] = $ar_sec['CODE'];
							foreach($arrSection[$key] as $val) {
								$list_Section[$ar_sec['NAME']]["ELEMENTS"][] = $val;
							}
		  				}
					}
					
					foreach($list_Section as $name=>$arr) {
						$arResult["LIST_SECTION_ELEMENTS"][$arr["CODE"]] = $arr["ELEMENTS"];
					}
					$arResult["LIST_SECTION_SECOND"] = $list_Section;
}
elseif(($arr_parent[0]['CODE']=='kollektsii' && !isset($arr_parent[1]['CODE'])) || !isset($arResult["VARIABLES"]["SECTION_CODE"])) {
	$property_enums = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "CODE"=>"COLLECTION"));
	while($enum_fields = $property_enums->GetNext())
	{
	  $arResult["COLLECTION"][] = $enum_fields["VALUE"];
	}
				$arrSection = array();
				$arResult["LIST_SECTION_ELEMENTS"] = array();
				$arr_Select = Array("ID", "IBLOCK_SECTION_ID", "NAME");
				$arr_Filter = Array("IBLOCK_ID"=>IntVal($arParams['IBLOCK_ID']), "PROPERTY_COLLECTION_VALUE"=>$arResult["COLLECTION"], "SECTION_GLOBAL_ACTIVE"=>"Y", "ACTIVE"=>"Y");
				$arr_res = CIBlockElement::GetList(Array(), $arr_Filter, false, false, $arr_Select);
					while($ar_fields = $arr_res->GetNext())
					{
					 	//$arrSection[$ar_fields["IBLOCK_SECTION_ID"]][] = $ar_fields["ID"];
						$arResult["LIST_SECTION_ELEMENTS"]["show_all"][] = $ar_fields["ID"];
					}
		if($arr_parent[0]['CODE']=='kollektsii' && !isset($arr_parent[1]['CODE'])) {
			unset($arResult["LIST_SECTION_ELEMENTS"]["show_all"]);
		}		
//	r($arResult["COLLECTION"]);
}
					//	r($arrSection);
					//	r($arResult["LIST_SECTION_SECOND"]);
	//				r($arResult["LIST_SECTION_ELEMENTS"]);
/*
		if($arResult["VARIABLES"]["SECTION_CODE"] == 'kollektsii') {
			$arr = array();
			$arSelect = Array("PROPERTY_GOODS");
			$arFilter = Array("IBLOCK_ID"=>IntVal($arParams['IBLOCK_ID']), "INCLUDE_SUBSECTIONS"=>"Y", "SECTION_ID"=>4, "ACTIVE"=>"Y");
		
			$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
			while($ob = $res->GetNextElement())
			{
			 $arFields = $ob->GetFields();
			 	if($arFields["PROPERTY_GOODS_VALUE"]>0){
					$arr[$arFields["PROPERTY_GOODS_VALUE"]]=$arFields["PROPERTY_GOODS_VALUE"];
				//	r($arFields);
				}
			}
		}
		elseif($arr_parent[0]=='kollektsii' && isset($arr_parent[1])) {
			$arr = array();
			$arSelect = Array("PROPERTY_GOODS");
			$arFilter = Array("IBLOCK_ID"=>IntVal($arParams['IBLOCK_ID']), "INCLUDE_SUBSECTIONS"=>"Y", "SECTION_CODE"=>$arResult["VARIABLES"]["SECTION_CODE"], "ACTIVE"=>"Y");
		
			$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
			while($ob = $res->GetNextElement())
			{
			 $arFields = $ob->GetFields();
			 	if($arFields["PROPERTY_GOODS_VALUE"]>0){
					$arr[$arFields["PROPERTY_GOODS_VALUE"]]=$arFields["PROPERTY_GOODS_VALUE"];
				 //	r($arFields);
				}
			}	
		}
	
		if($arr_parent[0]=='kollektsii' && !isset($arr_parent[1])) {
			if(count($arr)>0):
			$filter_Section=array();
				$arr_Select = Array("ID", "IBLOCK_SECTION_ID", "NAME");
				$arr_Filter = Array("IBLOCK_ID"=>IntVal($arParams['IBLOCK_ID']), "ID"=>$arr, "SECTION_GLOBAL_ACTIVE"=>"Y", "ACTIVE"=>"Y");
				$arr_res = CIBlockElement::GetList(Array(), $arr_Filter, false, false, $arr_Select);
					while($ar_fields = $arr_res->GetNext())
					{
					 	$filter_Section[$ar_fields['IBLOCK_SECTION_ID']][]=$ar_fields['ID'];
					}

					
			//r($filter_Section);
			$list_Section = array();
			foreach($filter_Section as $key=>$ids) {
				$sec_res = CIBlockSection::GetByID($key);
					if($ar_sec = $sec_res->GetNext()) {
	  					if($arResult["VARIABLES"]["SECTION_CODE"]==$ar_sec['CODE']) {
							$list_Section[$key]["NAME"] = 'Комплекты';
	  						$list_Section[$key]["CODE"] = $ar_sec['CODE'];

						}
						else {
	  						$list_Section[$key]["NAME"] = $ar_sec['NAME'];
	  						$list_Section[$key]["CODE"] = $ar_sec['CODE'];
						}
	  				}
			}
			$arResult["LIST_SECTION_SECOND"]=$list_Section;
			endif;
		}
		elseif($arr_parent[0]=='kollektsii' && isset($arr_parent[1])) {
			if(count($arr)>0):
			$filter_Section=array();
				$arr_Select = Array("ID", "IBLOCK_SECTION_ID", "NAME");
				$arr_Filter = Array("IBLOCK_ID"=>IntVal($arParams['IBLOCK_ID']), "ID"=>$arr, "SECTION_GLOBAL_ACTIVE"=>"Y", "ACTIVE"=>"Y");
				$arr_res = CIBlockElement::GetList(Array(), $arr_Filter, false, false, $arr_Select);
					while($ar_fields = $arr_res->GetNext())
					{
					 	$filter_Section[$ar_fields['IBLOCK_SECTION_ID']][]=$ar_fields['ID'];
					}

					
		//	r($filter_Section); 
			$list_Section = array();
			if(count($filter_Section)>0){
				$list_Section[0]["NAME"] = 'Комплекты';
	  			$list_Section[0]["CODE"] = $arr_parent[1];
			}
			foreach($filter_Section as $key=>$ids) {
				$sec_res = CIBlockSection::GetByID($key);
					if($ar_sec = $sec_res->GetNext()) {
	  					if($arResult["VARIABLES"]["SECTION_CODE"]==$ar_sec['CODE']) {
							$list_Section[0]["NAME"] = 'Комплекты';
	  						$list_Section[0]["CODE"] = $ar_sec['CODE'];

						}
						else {
	  						$list_Section[$key]["NAME"] = $ar_sec['NAME'];
	  						$list_Section[$key]["CODE"] = $ar_sec['CODE'];
						}
	  				}
			}
			$arResult["LIST_ELEMENT_SECOND"]=$arr;
			$arResult["LIST_SECTION_SECOND"]=$list_Section;
			endif;			
		}
  */
  }
  // r($arResult["LIST_SECTION_SECOND"]);
?> 