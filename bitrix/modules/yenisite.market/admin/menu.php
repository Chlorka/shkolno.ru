<?
/* Меню модуля yenisite.market */
global $USER;
if(!$USER->IsAdmin())
	return;
	
	IncludeModuleLangFile(__FILE__);
        CModule::IncludeModule("iblock");
        $res = CIBlock::GetList(array(), array("CODE" => "YENISITE_MARKET_ORDER"));
        $iblock = $res->GetNext();
	$aMenu = array(
		"parent_menu" => "global_menu_services",
		"text" => GetMessage("MODULE_NAME"),		
		"icon" => "market_menu_icon",
        "page_icon" => "market_page_icon",
		"url"  => "",
		"items_id" => "yenisite_market",
		"items" => array(
			array(
				"text" => GetMessage("CATALOG_LIST"),
				"url" => "/bitrix/admin/yci_market_catalog.php?lang=".LANG,
			),
			array(
				"text" => GetMessage("ORDER_PROPERTIES"),				
                                "url" => "/bitrix/admin/iblock_edit.php?type=yenisite_market&tabControl_active_tab=edit2&lang=ru&ID=".$iblock["ID"],

			),
                        array(
				"text" => GetMessage("PRICE_TYPE"),
				"url" => "/bitrix/admin/yci_market_price.php?lang=".LANG,
                                "more_url" => array(
                                        "yci_market_price_edit.php",
                                ),
                        ),
                        array(
				"text" => GetMessage("CSV_IMPORT"),
				"url" => "/bitrix/admin/yci_market_import_list.php?lang=".LANG,
                                "more_url" => array(
                                            "yci_market_import.php",
                                    ),
                        ),
						   array(
				"text" => GetMessage("F1"),
				"url" => "/bitrix/admin/yci_market_f1.php?lang=".LANG,
                                
                        ),


			),

			

	);
	return($aMenu);	
?>
