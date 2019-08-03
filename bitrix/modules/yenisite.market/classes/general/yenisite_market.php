<?
class CMarket{
    
    static function add_event($func, $arFields = array())
    {
        $function = $func;
        if(function_exists($func))        
            $function($arFields);        
    }

}

class CMarketPrice extends CMarket{
    static function GetList($by = 'id', $order = 'desc')
    {
        global $DB;
        $strSql = "SELECT * FROM yen_market_catalog_price ORDER BY ".$by." ".$order;
        $res = $DB->Query($strSql, false, $err_mess.__LINE__);
        return $res;
    }

    static function GetItemPriceValues($productID)
    {
        CModule::IncludeModule("iblock");
        $res = CIBlockElement::GetByID($productID);
        if($el = $res->GetNextElement())
        {
            $fields = $el->GetFields();
            if(!CMarketCatalog::IsCatalog($fields["IBLOCK_ID"])) return 0;
            $properties = $el->GetProperties();
            $db_price = CMarketPrice::GetList();
            $result = array();
            while($price = $db_price->GetNext())
            {
                $result[$price["code"]] = $properties[$price["code"]]["VALUE"];
            }
            return $result;
        }
    }

    static function GetPriceGroup($id)
    {
        global $DB;
        $strSql = "SELECT id, groups FROM yen_market_catalog_price WHERE id='".$id."' OR code='".$id."'";
        $res = $DB->Query($strSql, false, $err_mess.__LINE__);
        if($groups = $res->GetNext())
        {            
            $result = explode("#",$groups["groups"]);
            return $result;
        }
        return 0;
    }

    static function IsCanAdd($id)
    {
        global $USER;
        $my_groups = $USER->GetUserGroupArray();
        $groups = CMarketPrice::GetPriceGroup($id);
        foreach($my_groups as $mygr)
        {
            if(in_array($mygr, $groups))
                    return 1;

        }
        return 0;
    }

    static function GetByCode($code)
    {

        global $DB;
        $strSql = "SELECT * FROM yen_market_catalog_price WHERE code='".$code."'";
        $res = $DB->Query($strSql, false, $err_mess.__LINE__);
        return $res;
    }

    static function Update($id, $name, $code, $base, $group)
    {
        /* ---------------- */
        $args = array("id" => $id, "name" => $name, "code" => $code, "base" => $base, "group" => $group);
        CMarket::add_event("onBeforeMarketPriceUpdate", $args);
        /* ---------------- */

        global $DB;
        $base = $base=='Y'?'Y':'N';

        $db_this = CMarketPrice::GetByID($id);
        if($ar_this = $db_this->GetNext())
        {
            $db_catalog = CMarketCatalog::GetList();
            while($catalog = $db_catalog->GetNext())
            {
                $properties = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$catalog["ID"], "CODE" => $ar_this["code"]));
                if($prop_fields = $properties->GetNext())
                {
                    $arFields = Array(
                        "NAME" => $name,
                        "ACTIVE" => "Y",
                        "SORT" => "5555",
                        "CODE" => $code,
                        "PROPERTY_TYPE" => "S",
                        "IBLOCK_ID" => $catalog["ID"]
                    );                    
					if($code == 'PRICE')
						$arFields['PROPERTY_TYPE'] = 'N';

                    $ibp = new CIBlockProperty;
                    $ibp->Update($prop_fields["ID"], $arFields);
                }
            }
        }

        $strSql = "SELECT id FROM yen_market_catalog_price WHERE base='Y'";
        $res = $DB->Query($strSql, false, $err_mess.__LINE__);
        $price = $res->GetNext();
        if($price["id"] == $id)
            $base = 'Y';

        if($base == 'Y')
        {
            $strSql = "UPDATE yen_market_catalog_price SET base='N' WHERE base='Y'";
            $res = $DB->Query($strSql, false, $err_mess.__LINE__);
        }

        $prices = CMarketPrice::GetList();
        $cnt = 0;
        while($prices->GetNext()) $cnt ++;
        if($cnt == 1)
            $base = 'Y';

        $gr = implode("#", $group);        
        $strSql = "UPDATE yen_market_catalog_price SET name='".$name."', code='".$code."', groups='".$gr."', base='".$base."' WHERE id=".$id."";
        $res = $DB->Query($strSql, false, $err_mess.__LINE__);

        /* ---------------- */
        $args = array("id" => $id, "name" => $name, "code" => $code, "base" => $base, "group" => $group);
        CMarket::add_event("onAfterMarketPriceUpdate", $args);
        /* ---------------- */
    }

    static function GetByID($id)
    {
        global $DB;
        $strSql = "SELECT * FROM yen_market_catalog_price WHERE id='".$id."'";
        $res = $DB->Query($strSql, false, $err_mess.__LINE__);
        return $res;
    }

    static function GetBasePrice()
    {
        global $DB;
        $strSql = "SELECT * FROM yen_market_catalog_price WHERE base='Y'";
        $res = $DB->Query($strSql, false, $err_mess.__LINE__);
        return $res;
    }

    static function Delete($id)
    {
        global $DB;
        $strSql = "DELETE FROM yen_market_catalog_price WHERE id=".$id;
        $res = $DB->Query($strSql, false, $err_mess.__LINE__);        
    }

    static function Add($name, $code, $base, $group)
    {
        global $DB;
        $base = $base=='Y'?'Y':'N';
        if($base == 'Y')
        {
            $strSql = "UPDATE yen_market_catalog_price SET base='N' WHERE base='Y'";
            $res = $DB->Query($strSql, false, $err_mess.__LINE__);
        }
        else
        {
            $prices = CMarketPrice::GetList();
            if(!$prices->GetNext())
                    $base = 'Y';
        }
        $gr = implode("#",$group);

        $cat = CMarketPrice::GetByCode($code);
        if(!$cat->GetNext())
        {
            $strSql = "INSERT INTO yen_market_catalog_price(name, code, base, groups) values('".$name."','".$code."','".$base."','".$gr."')";
            $res = $DB->Query($strSql, false, $err_mess.__LINE__);
        }

        $db = CMarketCatalog::GetList();
        while($catalog = $db->GetNext())
        {
            $properties = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$catalog["ID"], "CODE" => $code));
            if(!$properties->GetNext())
            {
                $arFields = Array(
                  "NAME" => $name,
                  "ACTIVE" => "Y",
                  "SORT" => "5555",
                  "CODE" => $code,
                  "PROPERTY_TYPE" => "N",
                  "IBLOCK_ID" => $catalog["ID"]
                  );
                $ibp = new CIBlockProperty;
                $PropID = $ibp->Add($arFields);
            }
        }
    
    }
}


class CMarketCatalog extends CMarket{

    static function GetList($by = "id", $order = "asc")
    {
        CModule::IncludeModule("iblock");
        global $DB;
        $strSql = "SELECT * FROM yen_market_catalog";
        $res = $DB->Query($strSql, false, $err_mess.__LINE__);
        $iblock = array();
        while($catalog = $res->GetNext())
            $iblock[] = $catalog["iblock_id"];
		$iblock[] = -1;
        $db_iblock = CIBlock::GetList(array($by=>$order), array("ID" => $iblock));
        return $db_iblock;
    }

    static function Add($iblock_id)
    {
        global $DB;
        $strSql = "SELECT id FROM yen_market_catalog WHERE iblock_id=".$iblock_id;
        $res = $DB->Query($strSql, false, $err_mess.__LINE__);
        if($res->GetNext())
            return 0;

        $strSql = "INSERT INTO yen_market_catalog(iblock_id) values(".$iblock_id.")";
        $DB->Query($strSql, false, $err_mess.__LINE__);

        $strSql = "SELECT MAX(id) as ID FROM yen_market_catalog";
        $max = $DB->Query($strSql, false, $err_mess.__LINE__);

        if($iblock = $max->GetNext())
            return $iblock["ID"];

        return 0;
    }

    static function Delete($id)
    {
        global $DB;
        $id = $id?$id:0;
        if(!$id)
            return 0;
        if($id == '*')
            $strSql = "DELETE FROM yen_market_catalog";
        else
            $strSql = "DELETE FROM yen_market_catalog WHERE ID=".$id;
        $DB->Query($strSql, false, $err_mess.__LINE__);
        return 1;
    }

    static function IsCatalog($iblock_id)
    {
        global $DB;
        $strSql = "SELECT id FROM yen_market_catalog WHERE iblock_id=".$iblock_id;
        $res = $DB->Query($strSql, false, $err_mess.__LINE__);
        if(!$res->GetNext())
            return 0;
        return 1;

    }

}

class CMarketCatalogProperties extends CMarket{

    static function GetList()
    {
        $strSql = "SELECT * FROM yen_market_catalog_properties";
        $res = $DB->Query($strSql, false, $err_mess.__LINE__);
        return $res;
    }

    static function Add($name, $code, $iblocks, $type = "L", $multiple = "N")
    {
        CModule::IncludeModule("iblock");
        /*   $code       ,   $code   yen_market_catalog_properties */
        $strSql = "SELECT id FROM yen_market_catalog_properties WHERE code=".$code;
        $res = $DB->Query($strSql, false, $err_mess.__LINE__);
        if(!$res->GetNext())
        {
            $ibs = implode("#", $iblocks);
            $strSql = "INSERT INTO yen_market_catalog_properties(code, name, iblocks) values('".$code."','".$name."','".$ibs."')";
            $DB->Query($strSql, false, $err_mess.__LINE__);
        }

        //$db_iblock = CMarketCatalog::GetList();
        //while($iblock = $db_iblock->GetNext())
        foreach($iblocks as $iblock)
        {
            $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$iblock, "CODE" => $code));
            if(!$properties->GetNext())
            {
                $arFields = Array(
                    "NAME" => $name,
                    "ACTIVE" => "Y",
                    "SORT" => "100",
                    "CODE" => $code,
                    "MULTIPLE" => $multiple,
                    "PROPERTY_TYPE" => $type,
                    "IBLOCK_ID" => $iblock["ID"],
                );

                $ibp = new CIBlockProperty;
                $ibp->Add($arFields);

            }
        }


    }
}


class CMarketBasket extends CMarket{

    function Add($id, $props = array(), $quantity = 1)
    {
        CModule::IncludeModule("iblock");
        session_start();

        $quantity = intval($quantity);
        if($quantity == 0) $quantity = 1;

        $basketelementid = "";
        $basketelementid = CMarketBasket::EncodeBasketItems($id, $props);
	    $db_el = CIBlockElement::GetByID($id);
        if($ar_el = $db_el->GetNext())
        {
            if(!CMarketCatalog::IsCatalog($ar_el["IBLOCK_ID"]))
                return 0;



            if(!$_SESSION['YEN_MARKET_BASKET'][$basketelementid])
                $_SESSION['YEN_MARKET_BASKET'][$basketelementid]["YEN_COUNT"]   =   $quantity;
            else
                $_SESSION['YEN_MARKET_BASKET'][$basketelementid]["YEN_COUNT"]   += $quantity;

            //$_SESSION['YEN_MARKET_BASKET'][$basketelementid]["FIELDS"]    =   $ar_el;
            return 1;
        }
        return 0;
    }

    function DecodeBasketItems($key)
    {
        $res = explode("---", $key);
        $result["ID"] = $res[0];
        for($i = 1; $i < count($res); $i++)
        {
            $prop = explode("***", $res[$i]);
            $result["PROPERTIES"][base64_decode($prop[0])] = base64_decode($prop[1]);
        }        
        return $result;
    }

    function EncodeBasketItems($id, $props)
    {
        $beids = array();
        foreach($props as $key=>$value)
        {
            $beids[] = base64_encode($key)."***".base64_encode($value);
        }
        $basketelementid = $id."---".implode("---", $beids);
        return $basketelementid;

    }

    function Delete($key)
    {
        CModule::IncludeModule("iblock");
        session_start();
        $props = array();
        $db_prop = CMarketCatalogProperties::GetList();
        while($ar_prop = $db_prop->GetNext())
        {
            $props[] = "PROPERTY_".$ar_prop["code"];
        }
    }

    function GetList()
    {

    }

    function Clear()
    {

    }


}


class CMarketOrderProperties extends CMarket{

    static function GetList($arSort)
    {
        CModule::IncludeModule("iblock");
        $db_iblock = CIBlock::GetList(array(), array("CODE" => "YENISITE_MARKET_ORDER"));
            if(!$ar_iblock = $db_iblock->Fetch())
                return 0;
        $properties = CIBlockProperty::GetList($arSort, Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$ar_iblock["ID"]));
        return $properties;

    }

    static function Add($name, $code, $type = "S", $multiple = "N")
    {

        CModule::IncludeModule("iblock");
        $db_iblock = CIBlock::GetList(array(), array("CODE" => "YENISITE_MARKET_ORDER"));
            if(!$ar_iblock = $db_iblock->Fetch())
                return 0;
            
        $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$ar_iblock["ID"], "CODE" => $code));
        if($prop_fields = $properties->GetNext())
            return 0;
        
         $arFields = Array(
            "NAME" => $name,
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => $code,
            "MULTIPLE" => $multiple,
            "PROPERTY_TYPE" => $type,
            "IBLOCK_ID" => $ar_iblock["ID"],
        );

        $ibp = new CIBlockProperty;
        if($PropID = $ibp->Add($arFields))
            return $PropID;
        
        return 0;
    }

}
class CMarketOrder extends CMarket{
    static function GetByID($id)
    {
		CModule::IncludeModule("iblock");
		$arReturn = false;
		
		$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("CODE" => "YENISITE_MARKET_ORDER"));
		$arr = $rsIBlock->Fetch();
		
		//### GET INFO ABOUT ORDER ###//
        $res = CIBlockElement::GetProperty($arr["ID"], $id, array("sort" => "asc"));
		while($arRes = $res->GetNext())
		{
			$arReturn[$arRes['CODE']]= $arRes['VALUE'];
			if($arRes['CODE']=='PAYMENT_E')
				$link_iblock = $arRes['LINK_IBLOCK_ID'];
		}
		
		//### GET INFO ABOUT PAY SYSTEM ###//
		$res = CIBlockElement::GetProperty($link_iblock, $arReturn['PAYMENT_E'], array("sort" => "asc"));
		while($arRes = $res->GetNext())
		{
			$arReturn["PAY_SYSTEM"][$arRes['CODE']]= $arRes['VALUE'];
		}
		
		return $arReturn;
    }
	
	static function SetStatus($id,$status)
    {
		CModule::IncludeModule("iblock");
		IncludeModuleLangFile(__FILE__);
		
		$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("CODE" => "YENISITE_MARKET_ORDER"));
		$arr = $rsIBlock->Fetch();
		
		$arStatus = CIBlockProperty::GetPropertyEnum("STATUS", Array("SORT"=>"asc"), Array("IBLOCK_ID"=>$arr["ID"], "VALUE"=>GetMessage('YEN_STATUS_'.$status)))->GetNext();
		
		CIBlockElement::SetPropertyValues($id, $arr["ID"], $arStatus['ID'], "STATUS");
		
		return true;
    }
	
	static function GetStatus($id)
    {
		CModule::IncludeModule("iblock");
		IncludeModuleLangFile(__FILE__);
		
		$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("CODE" => "YENISITE_MARKET_ORDER"));
		$arr = $rsIBlock->Fetch();
		
		//### GET INFO ABOUT ORDER ###//
		$res = CIBlockElement::GetProperty($arr["ID"], $id, array("sort" => "asc"), Array("CODE" => "STATUS"));
		if($arRes = $res->GetNext())
		{
			$order_status = $arRes;
		}
		
        $res = CIBlockProperty::GetPropertyEnum("STATUS", Array("SORT"=>"asc"), Array("IBLOCK_ID"=>$arr["ID"], "VALUE"=>GetMessage('YEN_STATUS_PAYED')));
		if($arRes = $res->GetNext())
		{
			$status_payed = $arRes;
		}
		// if order status is 'PAYED' or higher
		if($order_status['VALUE_SORT']>=$status_payed['SORT'])
			return 'PAYED';
		else
			return 'NOT_PAYED';
		
    }
}
class CMarketPayment extends CMarket{
    static function GetByName($name)
    {
		CModule::IncludeModule("iblock");
		$res = CIBlock::GetList(
			Array(), 
			Array(
				'TYPE'=>'dict', 
				'SITE_ID'=>SITE_ID, 
				'ACTIVE'=>'Y', 
				'CODE'=>'payment',
				'CHECK_PERMISSIONS' => 'N'
			), false
		);

		if($ar_res = $res->GetNext())
		{
			$arReturn['IBLOCK'] = $ar_res['ID'];
		}
		$arFilter = Array("IBLOCK_ID"=>$arReturn['IBLOCK'],"ACTIVE"=>"Y", "NAME"=>$name);
		$res = CIBlockElement::GetList(Array(), $arFilter);
		if($arFields = $res->GetNext())
		{
			$arReturn['ID'] = $arFields['ID'];
		}
		
		return $arReturn;
    }
}

?>
