<?if(CModule::IncludeModule("iblock"))
   {
foreach($arResult["SECTIONS"] as &$arSection)
		{
			//$arSection["ID"]
				 $arFilter = Array('IBLOCK_ID'=>$arSection["IBLOCK_ID"], 'ID'=>$arSection["ID"]);
				  $db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, false, array("ID","UF_SECTION_TEXT"));
				  while($ar_result = $db_list->GetNext())
				  {
				  	//r($ar_result);
				   $arSection["UF_SECTION_TEXT"]=$ar_result["UF_SECTION_TEXT"];
				  }
			
		}
		unset($arSection);
   }
?> 