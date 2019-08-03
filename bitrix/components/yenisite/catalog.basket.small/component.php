<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
//r($arParams);
$arParams["ACTION_VARIABLE"]=trim($arParams["ACTION_VARIABLE"]);
if(strlen($arParams["ACTION_VARIABLE"])<=0|| !ereg("^[A-Za-z_][A-Za-z01-9_]*$", $arParams["ACTION_VARIABLE"]))
	$arParams["ACTION_VARIABLE"] = "action";
$arParams["PRODUCT_ID_VARIABLE"]=trim($arParams["PRODUCT_ID_VARIABLE"]);
if(strlen($arParams["PRODUCT_ID_VARIABLE"])<=0|| !ereg("^[A-Za-z_][A-Za-z01-9_]*$", $arParams["PRODUCT_ID_VARIABLE"]))
	$arParams["PRODUCT_ID_VARIABLE"] = "id";

$quantity = htmlspecialchars($_REQUEST["quantity"]);


CModule::IncludeModule("iblock");

$strError = "";
/*if (array_key_exists($arParams["ACTION_VARIABLE"], $_REQUEST) && array_key_exists($arParams["PRODUCT_ID_VARIABLE"], $_REQUEST))
{*/
		//r($_REQUEST);
	$action = strtoupper(htmlspecialchars($_REQUEST["action"]));
        $actionBUY = strtoupper(htmlspecialchars($_REQUEST["actionBUY"]));
        $actionADD2BASKET = strtoupper(htmlspecialchars($_REQUEST["actionADD2BASKET"]));
	$productID = intval(htmlspecialchars($_REQUEST["id"]));
	
	if(is_array($_REQUEST["del"]))
		{
			foreach($_REQUEST["del"] as $val)
			{
				unset($_SESSION["YEN_MARKET_BASKET"][$val]);
			}
		}
	if($_REQUEST["del_all"]=='Y')
		{
			unset($_SESSION["YEN_MARKET_BASKET"]);
			unset($_SESSION["YEN_MARKET_PROP"]);
		}
			
	//r($_GET);
	if(count($_REQUEST["cnt"])>0) {	
		foreach($_REQUEST["cnt"] as $index=>$quantity) {
		if($productID > 0)
		{			
				if(CModule::IncludeModule("yenisite.market"))
				{
	                        $res = CIBlockElement::GetByID($productID);
	                        if($el = $res->GetNextElement())
	                        {
	                            $fields = $el->GetFields();
	                            if(!CMarketCatalog::IsCatalog($fields["IBLOCK_ID"])) return 0;
								/*else
									echo 'okaaaaaaaaaaaay';*/
								//	r($_REQUEST);
							}
	$size["prop"]='';                        
	$size["prop"]["SIZE"] = $_REQUEST["suz"][$index];

	if($size["prop"]["SIZE"]>0) 
	         CMarketBasket::Add($productID, $size["prop"], $quantity);
	
				/*if($action == "ADD2BASKET"){
					$page = $APPLICATION->GetCurPageParam("", array("action", "id")); 
					LocalRedirect($page);	
				}
	
				if($action == "BUY" && !$actionADD2BASKET)
					LocalRedirect($arParams["BASKET_URL"]);*/
				}
			}
		}
	}
//}
if(strlen($strError)>0)
{
	ShowError($strError);
	return;
}
//r($_SESSION['YEN_MARKET_PROP']);
//r($_SESSION["YEN_MARKET_BASKET"]);
	if(CModule::IncludeModule("yenisite.market"))
	{
		if(is_array($_SESSION["YEN_MARKET_BASKET"]))
		{
            foreach($_SESSION["YEN_MARKET_BASKET"] as $key=>$value)
            {

                $res = CMarketBasket::DecodeBasketItems($key);
                $res["COUNT"] = $value["YEN_COUNT"];
                
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
        }    
            $arResult["COMMON_PRICE"] = 0;
            $arResult["COMMON_COUNT"] = 0;
		if(is_array($arResult["ITEMS"]))
		{
            foreach($arResult["ITEMS"] as $key => $arElement)
            {
                $arResult["COMMON_PRICE"] += $arElement["MIN_PRICE"]*$arElement["COUNT"];
                $arResult["COMMON_COUNT"]++;
            }
		}
		
	//	r($arResult);
	}

	$this->IncludeComponentTemplate();

?>
