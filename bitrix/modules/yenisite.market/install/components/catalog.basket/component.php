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


CModule::IncludeModule("iblock");

$calc = htmlspecialchars($_REQUEST["calculate"]);
$ord = htmlspecialchars($_REQUEST["order"]);



$action = $calc?"calculate":"";
$action = $ord?"order":$action;

if(CModule::IncludeModule("yenisite.market"))
{
    $rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("CODE" => "YENISITE_MARKET_ORDER"));
    $arr = $rsIBlock->Fetch();
    $arProperty[] = array();
    $rsProp = CIBlockProperty::GetList(Array("SORT"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arr["ID"]));
    while($arr=$rsProp->Fetch())
    {
        $arProperty[$arr["CODE"]] = $arr;		
    }
    
    foreach($arParams["PROPERTY_CODE"] as $code)
    {
	
        $type = $arProperty[$code]["PROPERTY_TYPE"];
	$arResult["DISPLAY_PROPERTIES"][$code]["SORT"] = $arProperty[$code]["SORT"];
	    switch($type)
        {

            
            case "N":
            case "S":
                $arResult["DISPLAY_PROPERTIES"][$code]["IS_REQUIRED"] = $arProperty[$code]["IS_REQUIRED"];              
                $arResult["DISPLAY_PROPERTIES"][$code]["NAME"] = $arProperty[$code]["NAME"];
                $arResult["DISPLAY_PROPERTIES"][$code]["VALUE"] = htmlspecialchars($_REQUEST["PROPERTY"][$code]);
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
					$arResult["DISPLAY_PROPERTIES"][$code]["VALUE"] = htmlspecialchars($_REQUEST["PROPERTY"][$code]);
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
					$resProp = CIBlockElement::GetList(array(), array('ID'=>$arres['ID']), false, array(), array("ID", "NAME", "PROPERTY_PRICE"));
					$arProps =  $resProp->GetNext();
					
					if($arProps['PROPERTY_PRICE_VALUE']==0)
						$arProps['DISPLAY_PRICE']=' ('.GetMessage("DELIVERY_FREE").')';
					else
						$arProps['DISPLAY_PRICE']=' ('.$arProps['PROPERTY_PRICE_VALUE'].' <span class="rubl">'.GetMessage("RUB").'</span>)';
						
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
			
uasort($arResult["DISPLAY_PROPERTIES"], 'sortprop');


    /* delete and recalculate items */    
    if($action == "calculate")
    {
        foreach($_REQUEST["count"] as $k=>$v)
            if($v > 0)
                $_SESSION["YEN_MARKET_BASKET"][$k]["YEN_COUNT"] = $v;

        foreach($_REQUEST["del"] as $val)
        {
            unset($_SESSION["YEN_MARKET_BASKET"][$val]);
        }
    }

    

    /* print items */
    foreach($_SESSION["YEN_MARKET_BASKET"] as $key=>$value)
    {

        $res = CMarketBasket::DecodeBasketItems($key);

        $props_list = array();
        

        if(!is_array($arResult["PROPERTIES"][$res["ID"]]))
        {
            $ob_el = CIBlockElement::GetByID($res["ID"]);
            if($el = $ob_el->GetNextElement())
            {                
                $arResult["PROPERTIES"][$res["ID"]] = $el->GetProperties();
                $arResult["FIELDS"][$res["ID"]] = $el->GetFields();
            }
            
        }

        foreach($res["PROPERTIES"] as $key1=>$value1)
        {
            if($arResult["PROPERTIES"][$res["ID"]][$key1]["PROPERTY_TYPE"] == "L")
            {
                
                $db_enum = CIBlockProperty::GetPropertyEnum($arResult["PROPERTIES"][$res["ID"]][$key1]["ID"], array(), array());
                while($enum = $db_enum->Fetch())
                    if($enum["ID"] == $res["PROPERTIES"][$key1])
                        $res["PROPERTIES"][$key1] = $enum["VALUE"];
                $res["PROPERTIES"][$key1] = array("VALUE" => $res["PROPERTIES"][$key1], "NAME" => $arResult["PROPERTIES"][$res["ID"]][$key1]["NAME"]) ;
            }
            else
                $res["PROPERTIES"][$key1] = array("VALUE" => $res["PROPERTIES"][$key1], "NAME" => $arResult["PROPERTIES"][$res["ID"]][$key1]["NAME"]) ;
            $res["FIELDS"] = $arResult["FIELDS"][$res["ID"]];
        }

        $res["COUNT"] = $value["YEN_COUNT"];
        $res["KEY"] = $key;
        
        $prices = CMarketPrice::GetItemPriceValues($res["ID"]);
        foreach($prices as $key=>$value)
        if(CMarketPrice::IsCanAdd($key))
        {
            $res["PRICE"][$key] = $value;
            $res["MIN_PRICE"] = $value;
        }

        foreach($res["PRICE"] as $price)
        if($price < $res["MIN_PRICE"])
            $res["MIN_PRICE"] = $price;

        $arResult["ITEMS"][] = $res;
     }



    $arResult["COMMON_PRICE"] = 0;
    $arResult["COMMON_COUNT"] = 0;
    foreach($arResult["ITEMS"] as $key => $arElement)
    {
        $arResult["COMMON_PRICE"] += $arElement["MIN_PRICE"]*$arElement["COUNT"];
        $arResult["COMMON_COUNT"]++;
    }

        /* add order */
		
    if($action == "order")
    {
			
        $temp = GetMessage("TEXT");
		$temp2 = GetMessage("TEXT_ADMIN");
		$order = "";
		$preview_order = "";
		
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

		$order .= '<table border="1" width="100%">';
		$order .= '<tr><td><b>'.GetMessage("TOVAR").'</b></td><td><b>'.GetMessage("KOLVO").'</b></td><td><b>'.GetMessage("PRICE_SHT").'</b></td></tr>';
		$ids = array();
		
        foreach($arResult["ITEMS"] as $arItem){
		
			$ids[] = $arItem['ID'];
		
			if(!$arItem["MIN_PRICE"]) $arItem["MIN_PRICE"] = 0;
            $har = "";
			$preview_har = "";
            if(count($arItem["PROPERTIES"]) > 0)
			{
				foreach($arItem["PROPERTIES"] as $arProp){
						$i++;
						if(!$arProp["NAME"]) continue;
						$har .= "<b>".$arProp["NAME"].":</b> <i>".$arProp["VALUE"].(($i<count($arItem["PROPERTIES"]))?",&nbsp;":"")."</i>";
						$preview_har .= "".$arProp["NAME"].": ".$arProp["VALUE"].(($i<count($arItem["PROPERTIES"]))?", ":"");
				}
			}
			
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
        
        foreach($arResult["DISPLAY_PROPERTIES"] as $pk => $pv)
        if($pv["UT"] == "HTML" && $pv["VALUE"])
            $PROP[$pk]["VALUE"]["TEXT"] = $pv["VALUE"];
		elseif($pv["UT"] == "L")		
		{
			 $PROP[$pk]["VALUE"] = $pv["VALUE"];
		}
        elseif($pv["VALUE"])
            $PROP[$pk] = $pv["VALUE"];

        $arLoadProductArray = Array(          
          "IBLOCK_SECTION_ID" => false,
          "IBLOCK_ID"      => $arr["ID"],
		  "PREVIEW_TEXT" => $preview_order,
          "PROPERTY_VALUES"=> $PROP,
          "NAME"           => "Order ".date("d.m.Y h:i:s"), //$arResult["DISPLAY_PROPERTIES"]["FIO"]["VALUE"],
          "ACTIVE"         => "Y",
          );
		  
	if(count($arResult["ERROR"]) == 0)	  
        if($PRODUCT_ID = $el->Add($arLoadProductArray))
        {
			$property_enums = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID"=>$arr["ID"], "CODE"=>"STATUS", "DEF" => "Y"))->GetNext();			
			
			CIBlockElement::SetPropertyValueCode($PRODUCT_ID, 'STATUS', array("VALUE" => $property_enums['ID']));			
			CIBlockElement::SetPropertyValueCode($PRODUCT_ID, 'ITEMS', $ids);
			
			$sites = array();
			$rsSites = CSite::GetList($by="sort", $order="desc", Array());
			while ($arSite = $rsSites->Fetch())
				$sites[] = $arSite["ID"];
			

            CEvent::Send($arParams["EVENT"], $sites, $arEventFields);
			
			$text2 = str_replace("#ID#", $PRODUCT_ID, $text2);
			$text2 = str_replace("#IBLOCK_ID#", $arLoadProductArray['IBLOCK_ID'], $text2);
			$text2 = str_replace("#SERVER_NAME#", "http://{$_SERVER['SERVER_NAME']}", $text2);
			
			$arEventFields2 = array("TEXT" => $text2, "EMAIL"  => $arParams['ADMIN_MAIL']);
			CEvent::Send($arParams["EVENT_ADMIN"], $sites, $arEventFields2);
			
            unset($_SESSION["YEN_MARKET_BASKET"]);
			if($arParams["THANK_URL"])
				LocalRedirect($arParams["THANK_URL"]);
        }

    }


}

$this->IncludeComponentTemplate();
?>
