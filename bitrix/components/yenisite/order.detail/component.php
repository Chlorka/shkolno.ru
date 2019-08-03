<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

function sortprop($a, $b)
{
    $key = 'SORT';
    if ($a[$key] == $b[$key]) {
        return 0;
    }
    return ($a[$key] < $b[$key]) ? -1 : 1;
}  

//unset($_SESSION["YEN_MARKET_BASKET"]);

if($_REQUEST["ORDER"]>0) {
	$orderID = $_REQUEST["ORDER"];
}
elseif($arParams['ORDER_ID']>0) {
	$orderID = $_REQUEST["ORDER"];
	$_REQUEST["ORDER"]=$arParams['ORDER_ID'];
}
else
	$arResult["ERROR"][] = 'Заказ не найден';

if(isset($_REQUEST["printfor"]))
	LocalRedirect('/account/orders/detail/?ORDER='.$orderID.'&print=Y');


if(isset($_REQUEST["printuser"]))
	LocalRedirect('/account/orders/detail_user/?ORDER='.$orderID.'&print=Y');

CModule::IncludeModule("iblock");	
//$arResult['ORDER_DATE']

$arFilter = Array( 
   "ID"=>$orderID
   );
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, Array("DATE_CREATE"));
while($ar_fields = $res->GetNext())
{
  	$arResult['ORDER_DATE'] = $ar_fields["DATE_CREATE"];
	$arResult['ORDER_ID'] = $orderID;
 // echo $ar_fields["DATE_ACTIVE_FROM"].": ".$ar_fields["CNT"]."<br>";
}


if(is_array($_REQUEST["new_goods"])) {
	foreach($_REQUEST["new_goods"] as $pid=>$arr) {
		$arResult["ADD_NEW_GOODS"][$pid] = implode(";", $arr);
	}
}
if(is_array($_REQUEST["new_price"])) {
	//foreach($_REQUEST["new_price"] as $pid=>$arr) {
		$arResult["OPLATA_price"] = implode(";", $_REQUEST["new_price"]);
	//}
}
if(is_array($_REQUEST["new_date"])) {
	//foreach($_REQUEST["new_date"] as $pid=>$arr) {
		$arResult["OPLATA_date"] = implode(";", $_REQUEST["new_date"]);
	//}
}
if($_REQUEST["all_order_price"]>0)
	$arResult['AMOUNT'] = $_REQUEST["all_order_price"];

/*r($_REQUEST["new_date"]);
r($arResult["OPLATA_date"]);*/
		
	if(!isset($_REQUEST["update"]) && !isset($_REQUEST["sendmail"]))
		CUtil::JSPostUnescape();
	if(isset($_REQUEST["update"]))
		$action='update';

$payment = htmlspecialchars($_REQUEST["payment"]);

/*
$action = $calc?"calculate":"";
$action = $update?"update":$action;*/
$action = $payment?"payment":$action;

/* добавление по артикулу */
if(strlen($_REQUEST["articleNew"])>0) {
	$arFilter = Array(
	   "IBLOCK_ID"=>"2", 
	   "ACTIVE"=>"Y", 
	   "PROPERTY_ARTICLE"=>htmlspecialchars($_REQUEST["articleNew"])
	   );
	$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, Array("ID", "PROPERTY_SIZE"));
	while($ar_fields = $res->GetNext())
	{
		$arrNewarticle[0] = $ar_fields['ID'];
		$arrNewarticle[1] = $ar_fields['PROPERTY_SIZE_VALUE'];
		$arrNewarticle[2] = 1; 
		$stringNewarticle = $ar_fields['ID'].';'.$ar_fields['PROPERTY_SIZE_VALUE'].';1;';
	}
}


if(CModule::IncludeModule("yenisite.market"))
{
    $rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("CODE" => "YENISITE_MARKET_ORDER"));
    $arr = $rsIBlock->Fetch();
	$order_iblock = $arr['ID'];
	if($action == "payment")
	{
		$order_id = htmlspecialchars($orderID);
		if(is_numeric($order_id))
		{
			
			$arResult['ORDER'] = CMarketOrder::GetByID($order_id);
			
			include($_SERVER['DOCUMENT_ROOT'].$arResult['ORDER']['PAY_SYSTEM']['PATH_TO_ACTION']);
		}
		else
			echo GetMessage("NO_ORDER_ID");
		return;
	}
    $arProperty[] = array();
    $rsProp = CIBlockProperty::GetList(Array("SORT"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arr["ID"]));
    while($arr=$rsProp->Fetch())
    {
        $arProperty[$arr["CODE"]] = $arr;		
    }

   if(is_array($arParams['PROPERTY_CODE']))
	{
		foreach($arParams["PROPERTY_CODE"] as $idcode=>$code)
		{
			
	$order_res = CIBlockElement::GetProperty($order_iblock, $orderID, "sort", "asc", array("CODE"=>$code));
    while ($ar_props = $order_res->GetNext()) {
	 //if($ar_props = $order_res->Fetch()) {
	 	 
		if($ar_props["MULTIPLE"] == "Y") {
			$order_VALUES[$code][] = $ar_props["VALUE"];
		}
		else {
			$order_VALUES[$code] = $ar_props["VALUE"];
		}
	 }
	 
		$type = $arProperty[$code]["PROPERTY_TYPE"];
		$arResult["DISPLAY_PROPERTIES"][$code]["SORT"] = $arProperty[$code]["SORT"];
			switch($type)
			{
				case "N":
				case "S":
					$arResult["DISPLAY_PROPERTIES"][$code]["IS_REQUIRED"] = $arProperty[$code]["IS_REQUIRED"];              
					$arResult["DISPLAY_PROPERTIES"][$code]["NAME"] = $arProperty[$code]["NAME"];
					if($_REQUEST["PROPERTY"][$code]) {
						$arResult["DISPLAY_PROPERTIES"][$code]["VALUE"] = htmlspecialchars($_REQUEST["PROPERTY"][$code]);
					}
					else {
						if($arProperty[$code]["USER_TYPE"] == "HTML") {	
								$arResult["DISPLAY_PROPERTIES"][$code]["VALUE"] = htmlspecialchars($order_VALUES[$code]["TEXT"]);
						}
						else {
							$arResult["DISPLAY_PROPERTIES"][$code]["VALUE"] = htmlspecialchars($order_VALUES[$code]);
							
							$arResult["DISPLAY_PROPERTIES"][$code]["MULTIPLE_VALUE"] = $order_VALUES[$code];
						}
					}
					if($arProperty[$code]["USER_TYPE"] == "HTML")
					{
						$arResult["DISPLAY_PROPERTIES"][$code]["INPUT"] = "<textarea name='PROPERTY[".$code."]'>".$arResult["DISPLAY_PROPERTIES"][$code]["VALUE"]."</textarea>";
						$arResult["DISPLAY_PROPERTIES"][$code]["UT"] = "HTML";
					}
					else
					{
						$arResult["DISPLAY_PROPERTIES"][$code]["INPUT"] = "<input type='text' name='PROPERTY[".$code."]' value='".$arResult["DISPLAY_PROPERTIES"][$code]["VALUE"]."' />";
						$arResult["DISPLAY_PROPERTIES"][$code]["UT"] = "N";
					}
					
					break;
				case "L":
					$arResult["DISPLAY_PROPERTIES"][$code]["IS_REQUIRED"] = $arProperty[$code]["IS_REQUIRED"];   				                
						$arResult["DISPLAY_PROPERTIES"][$code]["NAME"] = $arProperty[$code]["NAME"];
						$res = CIBlockPropertyEnum::GetList(array("sort" => "asc"), array("PROPERTY_ID" => $arProperty[$code]['ID']));
						
						if($_REQUEST["PROPERTY"][$code]) {
							$arResult["DISPLAY_PROPERTIES"][$code]["VALUE"] = htmlspecialchars($_REQUEST["PROPERTY"][$code]);
						}
						else {
							$arResult["DISPLAY_PROPERTIES"][$code]["VALUE"] = htmlspecialchars($order_VALUES[$code]);
						}
					
						//$arResult["DISPLAY_PROPERTIES"][$code]["VALUE"] = htmlspecialchars($_REQUEST["PROPERTY"][$code]);
						while($arres =  $res->GetNext()){
							if(!$arResult["DISPLAY_PROPERTIES"][$code]["VALUE"]) 
							{
								if($arres['DEF'] == 'Y')
									$arResult["DISPLAY_PROPERTIES"][$code]["INPUT"] .= "<input type='radio' checked='checked' name='PROPERTY[".$code."]' value='".$arres['ID']."' />".$arres['VALUE']."<br/>";						
								else
									$arResult["DISPLAY_PROPERTIES"][$code]["INPUT"] .= "<input type='radio' name='PROPERTY[".$code."]' value='".$arres['ID']."' />".$arres['VALUE']."<br/>";						
							}
							else
							{
								if($arResult["DISPLAY_PROPERTIES"][$code]["VALUE"] == $arres['ID'])
									$arResult["DISPLAY_PROPERTIES"][$code]["INPUT"] .= "<input type='radio' checked='checked' name='PROPERTY[".$code."]' value='".$arres['ID']."' />".$arres['VALUE']."<br/>";						
								else
									$arResult["DISPLAY_PROPERTIES"][$code]["INPUT"] .= "<input type='radio' name='PROPERTY[".$code."]' value='".$arres['ID']."' />".$arres['VALUE']."<br/>";						
							}
						}
						
						$arResult["DISPLAY_PROPERTIES"][$code]["UT"] = "L";
						

				break;
				case "E":
					$arResult["DISPLAY_PROPERTIES"][$code]["IS_REQUIRED"] = $arProperty[$code]["IS_REQUIRED"];   				                
				$arResult["DISPLAY_PROPERTIES"][$code]["NAME"] = $arProperty[$code]["NAME"];
					$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$arProperty[$code]['LINK_IBLOCK_ID'], "ACTIVE"=>"Y"));
					$arResult["DISPLAY_PROPERTIES"][$code]["VALUE"] = htmlspecialchars($_REQUEST["PROPERTY"][$code]);
					$checked = false;
					while($ob =  $res->GetNextElement())
					{
						$arres = $ob->GetFields();
						$resProp = CIBlockElement::GetList(array(), array('ID'=>$arres['ID']), false, array(), array("ID", "NAME", "PROPERTY_PRICE", "PROPERTY_PATH_TO_ACTION"));
						$arProps =  $resProp->GetNext();
						
						$arres["NAME"] = $arres["~NAME"];
						if(strlen($arProps["PREVIEW_TEXT"])>0)
						{
							$arres["NAME"] = $arres["~NAME"].'<span>'.$arProps["PREVIEW_TEXT"].'</span>'; 
						}
						
						if(is_numeric($arProps['PROPERTY_PRICE_VALUE_ID']))
						{
							if($arProps['PROPERTY_PRICE_VALUE']==0)
								$arProps['DISPLAY_PRICE']=' ('.GetMessage("DELIVERY_FREE").')';
							else
								$arProps['DISPLAY_PRICE']=' ('.$arProps['PROPERTY_PRICE_VALUE'].' <span class="rubl">'.GetMessage("RUB").'</span>)';
						}
						if(is_numeric($arProps['PROPERTY_PATH_TO_ACTION_VALUE_ID']))
						{
							$arResult["PAY_SYSTEM"][$arres['ID']]['NEED_PAY'] = true;
						}
						else
						{
							$arResult["PAY_SYSTEM"][$arres['ID']]['NEED_PAY'] = false;
						}
						if(!$arResult["DISPLAY_PROPERTIES"][$code]["VALUE"]) 
						{
							if(!$checked)
							{
								$arResult["DISPLAY_PROPERTIES"][$code]["INPUT"] .= "<input type='radio' checked='checked' name='PROPERTY[".$code."]' value='".$arres['ID']."' placeholder='".$arProps['PROPERTY_PRICE_VALUE']."' />".$arres['NAME'].$arProps['DISPLAY_PRICE']."<br/>";	
								$checked = true;
							}							
							else
							{
								$arResult["DISPLAY_PROPERTIES"][$code]["INPUT"] .= "<input type='radio'  name='PROPERTY[".$code."]' value='".$arres['ID']."' placeholder='".$arProps['PROPERTY_PRICE_VALUE']."' />".$arres['NAME'].$arProps['DISPLAY_PRICE']."<br/>";
							}
						}
						else
						{
							if($arResult["DISPLAY_PROPERTIES"][$code]["VALUE"] == $arres['ID'])
							{
								$arResult["DISPLAY_PROPERTIES"][$code]["INPUT"] .= "<input type='radio' checked='checked' name='PROPERTY[".$code."]' value='".$arres['ID']."' placeholder='".$arProps['PROPERTY_PRICE_VALUE']."' />".$arres['NAME'].$arProps['DISPLAY_PRICE']."<br/>";		
							}
							else
							{
								$arResult["DISPLAY_PROPERTIES"][$code]["INPUT"] .= "<input type='radio' name='PROPERTY[".$code."]' value='".$arres['ID']."' placeholder='".$arProps['PROPERTY_PRICE_VALUE']."' />".$arres['NAME'].$arProps['DISPLAY_PRICE']."<br/>";
							}
						}
					}
					
					$arResult["DISPLAY_PROPERTIES"][$code]["UT"] = "E";
				break;
			}
		}
	}		
//r($arResult["DISPLAY_PROPERTIES"]);
uasort($arResult["DISPLAY_PROPERTIES"], 'sortprop');


 /* delete and recalculate items */    
		
   /*if($action == "calculate")
    {
		if(is_array($_REQUEST["count"]))
		{
			foreach($_REQUEST["count"] as $k=>$v)
				if($v > 0)
					$_SESSION["YEN_MARKET_BASKET"][$k]["YEN_COUNT"] = $v;
		}
		if(is_array($_REQUEST["del"]))
		{
			foreach($_REQUEST["del"] as $val)
			{
				unset($_SESSION["YEN_MARKET_BASKET"][$val]);
			}
		}
    }*/

// Обновляем св-во заказа после добавления товарра на страницу

			
	$order_res = CIBlockElement::GetProperty($order_iblock, $orderID, "sort", "asc", array("CODE"=>"ARR"));
    $index_arr = 0;
    while ($ar_props = $order_res->GetNext())
    {
    	
    	$string_arr[$index_arr] = $ar_props["VALUE"];
		
		if($_REQUEST["personal_price"][$index_arr]>0) {
			$ar_props["VALUE"] = $ar_props["VALUE"].''.$_REQUEST["personal_price"][$index_arr];
		}
		 
        $arrITEMS[$index_arr] = explode(";", $ar_props["VALUE"]);
	$index_arr++;
    } 

	if($_REQUEST["copy"]=="Y")
		{
			$el = new CIBlockElement;

			$PROP = array();
			$PROP["ARR"] = $string_arr;  // свойству с кодом 12 присваиваем значение "Белый"
			
			$arLoadProductArray = Array(
			  "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
			  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
			  "IBLOCK_ID"      => 6,
			  "PROPERTY_VALUES"=> $PROP,
			  "NAME"           => "Копия заказа-".$_REQUEST["ORDER"],
			  "ACTIVE"         => "Y"
			  );
			
			if($PRODUCT_ID = $el->Add($arLoadProductArray))
			  LocalRedirect('/account/orders/detail_new/?ORDER='.$PRODUCT_ID);
			else
			  echo "Error: ".$el->LAST_ERROR;
		}	
		
	$arrITEMS[] = $arrNewarticle;
 
		$PROPERTY_CODE = "ARR";  // код свойства
		
		
		foreach($string_arr as $index=>$arrValue) {
			
			$PROPERTY_VALUE[] = array("VALUE"=>$arrValue);	
		}
			if(strlen($stringNewarticle)>0)
				$PROPERTY_VALUE[] = array("VALUE"=>$stringNewarticle);
			
			
	if(isset($_REQUEST["del"]) && $_REQUEST["del"]>0)
		{
				unset($arrITEMS[$_REQUEST["del"]]);
				unset($PROPERTY_VALUE[$_REQUEST["del"]]);
		}
/*
	r($PROPERTY_CODE);
	r($orderID);
	r($PROPERTY_VALUE);		*/
CIBlockElement::SetPropertyValuesEx($orderID, false, array($PROPERTY_CODE => $PROPERTY_VALUE));
		
						
	// r($arResult["PROPERTIES"]);
	if(is_array($arrITEMS))
	{
		foreach($arrITEMS as $key=>$value)
		{
			$res = array();
			$props_list = array();
			$res["ID"] = $value[0];

			// if(!is_array($arResult["PROPERTIES"][$value[0]])) {
					
				$ob_el = CIBlockElement::GetByID($value[0]);
				if($el = $ob_el->GetNextElement())
				{
					//r($el);                
					$arResult["PROPERTIES"][$key][$value[0]] = $el->GetProperties();
					$arResult["FIELDS"][$key][$value[0]] = $el->GetFields();
				}
				
			//} 

$order_res = CIBlockElement::GetProperty($arResult["FIELDS"][$key][$value[0]]["IBLOCK_ID"], $value[0], "sort", "asc", array("CODE"=>"SIZE"));
    while ($ar_props = $order_res->GetNext())
    {
    	if($_REQUEST["SIZE"][$key]>0) {
    		$res["PROPERTIES"][$ar_props["CODE"]] = $_REQUEST["SIZE"][$key];
		}
		else {
    		if($ar_props["VALUE_ENUM"] == $value[1])
        		$res["PROPERTIES"][$ar_props["CODE"]] = $ar_props["VALUE"];
		}
    } 

		foreach($res["PROPERTIES"] as $key1=>$value1)
			{
			if($arResult["PROPERTIES"][$key][$value[0]][$key1]["PROPERTY_TYPE"] == "L")
				{
					$db_enum = CIBlockProperty::GetPropertyEnum($arResult["PROPERTIES"][$key][$value[0]][$key1]["ID"], array(), array());
					while($enum = $db_enum->Fetch()) {
						//	echo $res["PROPERTIES"][$key1].'-'.$enum["ID"].'-'.$enum["VALUE"].'<br>';
				
						if($enum["ID"] == $res["PROPERTIES"][$key1]) {
							$res["PROPERTIES"][$key1] = $enum["VALUE"];
							$res["PROPERTIES"][$key1] = array("VALUE" => $res["PROPERTIES"][$key1], "NAME" => $arResult["PROPERTIES"][$key][$value[0]][$key1]["NAME"]) ;
				
						}
					}
				}
				else
					$res["PROPERTIES"][$key1] = array("VALUE" => $res["PROPERTIES"][$key1], "NAME" => $arResult["PROPERTIES"][$key][$value[0]][$key1]["NAME"]) ;
				
				//$res["FIELDS"] = $arResult["FIELDS"][$value[0]];
			}
//r($res["PROPERTIES"]);
$res["FIELDS"] = $arResult["FIELDS"][$key][$value[0]];
			    	/* r($key); 
			    	 r($value); */
			
			if($_REQUEST["count"][$key]>0)
				$res["COUNT"] = $_REQUEST["count"][$key];
			else 
				$res["COUNT"] = $value[2];

			if($_REQUEST["personal_price"][$key]>0)
				$res["PERSONAL_PRICE"] = $_REQUEST["personal_price"][$key];
			else 
				$res["PERSONAL_PRICE"] = $value[3];
			
			
			$prices = CMarketPrice::GetItemPriceValues($value[0]);
			foreach($prices as $key=>$value)
			if(CMarketPrice::IsCanAdd($key))
			{
				$res["PRICE"][$key] = $value;
				$res["MIN_PRICE"] = $value;
			}

			foreach($res["PRICE"] as $price)
			if($price < $res["MIN_PRICE"])
				$res["MIN_PRICE"] = $price;

			if($res["ID"]>0)
				$arResult["ITEMS"][] = $res;
		}
	}

// r($arResult["ITEMS"]);

    $arResult["COMMON_PRICE"] = 0;
    $arResult["COMMON_COUNT"] = 0;
	if(is_array($arResult["ITEMS"]))
	{
		foreach($arResult["ITEMS"] as $key => $arElement)
		{
			if($arElement["PERSONAL_PRICE"]>0) 
			  			$arResult["COMMON_PRICE"] += $arElement["PERSONAL_PRICE"]*$arElement["COUNT"];
			  		else
						$arResult["COMMON_PRICE"] += $arElement["MIN_PRICE"]*$arElement["COUNT"];
			  		
			$arResult["COMMON_COUNT"]++;
		}
	}
        /* add order */
		
    if($action == "update")
    {
			
        $temp = GetMessage("TEXT");
		$temp2 = GetMessage("TEXT_ADMIN");
		$order = "";
		$preview_order = "";

  //  r($arResult["DISPLAY_PROPERTIES"]);	
	if(is_array($arResult["DISPLAY_PROPERTIES"]))
	{
        foreach($arResult["DISPLAY_PROPERTIES"] as $pk => $pv)
        {  
			if($arResult["DISPLAY_PROPERTIES"][$pk]["VALUE"])
			{
				if($arResult["DISPLAY_PROPERTIES"][$pk]["UT"] == 'L') 
				{

					$ress = CIBlockPropertyEnum::GetList(array(), array("ID" => $arResult["DISPLAY_PROPERTIES"][$pk]["VALUE"]))->GetNext();					
					$text .= "<b>".$pv["NAME"].":</b> ".$ress["VALUE"]."<br/>";
					$text2 .= "<b>".$pv["NAME"].":</b> ".$ress["VALUE"]."<br/>";
				}
				elseif($arResult["DISPLAY_PROPERTIES"][$pk]["UT"] == 'E')
				{
					$ress = CIBlockElement::GetByID($arResult["DISPLAY_PROPERTIES"][$pk]["VALUE"]);
					$ar_ress = $ress->GetNext();
					$text .= "<b>".$pv["NAME"].":</b> ".$ar_ress["NAME"]."<br/>";
					$text2 .= "<b>".$pv["NAME"].":</b> ".$ar_ress["NAME"]."<br/>";
				}
				else
				{
					$text .= "<b>".$pv["NAME"].":</b> ".$arResult["DISPLAY_PROPERTIES"][$pk]["VALUE"]."<br/>";
					$text2 .= "<b>".$pv["NAME"].":</b> ".$arResult["DISPLAY_PROPERTIES"][$pk]["VALUE"]."<br/>";
				}
				
				$temp = str_replace("#".$pk."#", $arResult["DISPLAY_PROPERTIES"][$pk]["VALUE"], $temp);
				$temp2 = str_replace("#".$pk."#", $arResult["DISPLAY_PROPERTIES"][$pk]["VALUE"], $temp2);
			}
			if($arResult["DISPLAY_PROPERTIES"][$pk]["IS_REQUIRED"] == 'Y' && !$pv["VALUE"] )
				$arResult["ERROR"][] = $pv["NAME"];
        }
	}
		$order .= '<table border="1" width="100%">';
		$order .= '<tr><td><b>'.GetMessage("TOVAR").'</b></td><td><b>'.GetMessage("KOLVO").'</b></td><td><b>'.GetMessage("PRICE_SHT").'</b></td></tr>';
		$ids = array();
	
	if(is_array($arResult["ITEMS"]))
	{
		$arrItem=array();
        foreach($arResult["ITEMS"] as $index=>$arItem){
			$arrtxt='';
			//$allCount=$allCount+$arItem["COUNT"];
			$ids[] = $arItem['ID'];
			
			$arrtxt.=$arItem['ID'].';';
			
			if(!$arItem["MIN_PRICE"]) $arItem["MIN_PRICE"] = 0;
            $har = "";
			$preview_har = "";
            if(count($arItem["PROPERTIES"]) > 0)
			{
				foreach($arItem["PROPERTIES"] as $keyid=>$arProp){
						if($keyid=='SIZE')
							$arrtxt.=$arProp["VALUE"].';';
							
						$i++;
						if(!$arProp["NAME"]) continue;
						$har .= "<b>".$arProp["NAME"].":</b> <i>".$arProp["VALUE"].(($i<count($arItem["PROPERTIES"]))?",&nbsp;":"")."</i>";
						$preview_har .= "".$arProp["NAME"].": ".$arProp["VALUE"].(($i<count($arItem["PROPERTIES"]))?", ":"");
				}
			}
			$arrtxt.=$arItem["COUNT"].';';
			$arrItem[$index]=$arrtxt;
			//print_r($arItem);
			//die();
			
			$sec = CIBlockSection::GetByID($arItem["FIELDS"]['IBLOCK_SECTION_ID'])->GetNext();
			$order .="<tr><td>";
			if($sec)
				$order .= '<a href="http://'.$_SERVER['SERVER_NAME'].''.$sec["SECTION_PAGE_URL"].'" title="'.$sec["NAME"].'">'.$sec["NAME"].'</a> / ';
            $order .= '<a href="http://'.$_SERVER['SERVER_NAME'].''.$arItem["FIELDS"]["DETAIL_PAGE_URL"].'" title="'.$arItem["FIELDS"]["NAME"].'">'.$arItem["FIELDS"]["NAME"].'</a>('.$har.') </td><td>'.$arItem["COUNT"].'</td><td>'.$arItem["MIN_PRICE"].' '.$arParams["UE"].'</td></tr>';
			
			if($preview_har != ': ')
				$preview_order .= $arItem["FIELDS"]["NAME"].'('.$preview_har.') '.$arItem["COUNT"].'x'.$arItem["MIN_PRICE"].' '.$arParams["UE"]."\n";
			else
				$preview_order .= $arItem["FIELDS"]["NAME"].' '.$arItem["COUNT"].'x'.$arItem["MIN_PRICE"].' '.$arParams["UE"]."\n";
        }
	}
		$order .= '</table>';
		
		/*  delivery   */
		if($arResult["DISPLAY_PROPERTIES"]["DELIVERY_E"]["UT"]=='E')
		{
			$res = CIBlockElement::GetList(array(), array('ID'=>$arResult["DISPLAY_PROPERTIES"]["DELIVERY_E"]["VALUE"]), false, array(), array("ID", "NAME", "PROPERTY_PRICE"));
			$arDelivery =  $res->GetNext();
			$preview_order .="\n".GetMessage("DELIVERY")."\n".$arDelivery['NAME']." - ";
			if($arDelivery['PROPERTY_PRICE_VALUE']==0)
			{
				$preview_order .= GetMessage("DELIVERY_FREE");
			}
			else
			{
				$preview_order .=$arDelivery['PROPERTY_PRICE_VALUE']." ".$arParams["UE"];
				$arResult["COMMON_PRICE"]+=$arDelivery['PROPERTY_PRICE_VALUE'];
			}
		}
		
		
		$preview_order .="\n\n".GetMessage("TOTAL").$arResult["COMMON_PRICE"]." ".$arParams["UE"];
		$preview_order = str_replace("()", "", $preview_order);

        $temp = str_replace("#SUMM#", $arResult["COMMON_PRICE"]." ".$arParams["UE"], $temp);
        $temp = str_replace("#ORDER#", $order, $temp);
		
		$temp2 = str_replace("#SUMM#", $arResult["COMMON_PRICE"]." ".$arParams["UE"], $temp2);
        $temp2 = str_replace("#ORDER#", $order, $temp2);
		
		$text = str_replace("()", "", $temp.$text);		
		$order = str_replace("()", "", $order);
		
		$text2 = str_replace("()", "", $temp2.$text2);		
		

		


        $arEventFields = array("TEXT" => $text, "EMAIL" =>$arResult["DISPLAY_PROPERTIES"]["EMAIL"]["VALUE"]);
		
		$arEventFields2 = array("TEXT" => $text2, "EMAIL"  => $arParams['ADMIN_MAIL']);
		
        $el = new CIBlockElement;
        $rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("CODE" => "YENISITE_MARKET_ORDER"));
        $arr = $rsIBlock->Fetch();

        $PROP = array();
        
		
        foreach($arResult["DISPLAY_PROPERTIES"] as $pk => $pv) {
        if($pv["UT"] == "HTML" && $pv["VALUE"])
            $PROP[$pk]["VALUE"]["TEXT"] = $pv["VALUE"];
		elseif($pv["UT"] == "L")		
		{
			 $PROP[$pk]["VALUE"] = $pv["VALUE"];
		}
        elseif($pv["VALUE"])
            $PROP[$pk] = $pv["VALUE"];
		
		}
		//r($arrtxt);
		foreach($arrItem as $index=>$value) {
			if($_REQUEST["personal_price"][$index]>0) {
				$value = $value.''.$_REQUEST["personal_price"][$index];
			}
			$PROP["ARR"][]=$value;
		}	
		
		foreach($arResult["ADD_NEW_GOODS"] as $index=>$arrValue) {
			//$PROP["ADD_GOODS"][] = $arrValue;
			$arrADD[]=$arrValue;
		}

		//r($PRP);
		$PROP['ADD_GOODS'] = $arrADD;
		$PROP['OPLATA'] = array($arResult["OPLATA_price"], $arResult["OPLATA_date"]);
		
	//	r($_REQUEST);
		
			$PROP['AMOUNT'] = $arResult['AMOUNT'];
		/*else
			$PROP['AMOUNT'] = $arResult["COMMON_PRICE"];*/
		
        $arLoadProductArray = Array(          
          "IBLOCK_SECTION_ID" => false,
          "IBLOCK_ID"      => $arr["ID"],
		  "PREVIEW_TEXT" => $preview_order,
          "PROPERTY_VALUES"=> $PROP,
          "NAME"           => "Order ".date("d.m.Y h:i:s"), //$arResult["DISPLAY_PROPERTIES"]["FIO"]["VALUE"],
          "ACTIVE"         => "Y",
          );
	//r($arLoadProductArray);
	
	if(count($arResult["ERROR"]) == 0)	  
    //    if($PRODUCT_ID = $el->Add($arLoadProductArray))
      	if($res = $el->Update($orderID, $arLoadProductArray))
        {
        //	r($PRODUCT_ID);
			$property_enums = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID"=>$arr["ID"], "CODE"=>"STATUS", "DEF" => "Y"))->GetNext();			
			
			CIBlockElement::SetPropertyValueCode($PRODUCT_ID, 'STATUS', array("VALUE" => $property_enums['ID']));			
			CIBlockElement::SetPropertyValueCode($PRODUCT_ID, 'ITEMS', $ids);
			
			require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/mainpage.php");
			if(!$sites = CMainPage::GetSiteByHost())
			{
				$sites = array();
				$rsSites = CSite::GetList($by="sort", $order="desc", Array());
				while ($arSite = $rsSites->Fetch())
				$sites[] = $arSite["ID"];
			}
			
			$arEventFields['TEXT'] = str_replace ('#ID#', $PRODUCT_ID, $arEventFields['TEXT']);
        if($_REQUEST["update"]!='Сохранить')
		    CEvent::Send($arParams["EVENT"], $sites, $arEventFields);
			
			$text2 = str_replace("#ID#", $PRODUCT_ID, $text2);
			$text2 = str_replace("#IBLOCK_ID#", $arLoadProductArray['IBLOCK_ID'], $text2);
			$text2 = str_replace("#SERVER_NAME#", "http://{$_SERVER['SERVER_NAME']}", $text2);
			
			$arEventFields2 = array("TEXT" => $text2, "EMAIL"  => $arParams['ADMIN_MAIL']);
		
		if($_REQUEST["update"]!='Сохранить')
			CEvent::Send($arParams["EVENT_ADMIN"], $sites, $arEventFields2);
/*
if($_REQUEST["update"]=='Сохранить')
			LocalRedirect($APPLICATION->GetCurUri());
	*/	
          //  unset($_SESSION["YEN_MARKET_BASKET"]); 
			 
			
			
			//if (strlen($arResult["DISPLAY_PROPERTIES"])>0)
			/*
			if($arResult["PAY_SYSTEM"][$PROP['PAYMENT_E']]['NEED_PAY']===true)
			{
				LocalRedirect($APPLICATION->GetCurUri('payment=Y&id='.$PRODUCT_ID));
			}
			elseif($arParams["THANK_URL"]){
				LocalRedirect($arParams["THANK_URL"]);
			}*/
        }

    }
	if($action == "payment")
	{
		
	}
	
		
	if(isset($_REQUEST["sendmail"])) {
//			ob_start();
//			$html = ob_get_clean();
//r($arResult);
	/*
			CEvent::Send("SEND_USER_MAIL", "s1", array(	
			"ORDER_USER" => $arFields["ORDER_USER"],
			"ORDER_ID" => $arFields["ORDER_ID"],
			"ORDER_DATE" => $arFields["ORDER_DATE"],
			"PRICE" => $arFields["PRICE"],
			"SALE_EMAIL" => $arFields["SALE_EMAIL"],
			"ORDER_LIST" => $html,
			"EMAIL_TO" => 'info@weewaa.ru',
			));
	*/
	//	r($_SESSION['ORDERS']);
	}
}

$this->IncludeComponentTemplate();
?>
