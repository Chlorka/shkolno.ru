<?
define("ADMIN_MODULE_NAME", "yenisite.market");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
IncludeModuleLangFile(__FILE__);
CModule::IncludeModule("iblock");
CModule::IncludeModule("yenisite.market");

global $USER;
if(!$USER->IsAdmin())
	return;



global $APPLICATION;
$action = htmlspecialchars($_REQUEST["action"]);

if($action)
{
    CMarketCatalog::Delete("*");
    foreach($_REQUEST as $key=>$value)
    {
        if(substr_count($key,"IS_CATALOG_"))
        {
            $id = str_replace("IS_CATALOG_","",$key);
            $dbprice = CMarketPrice::GetList();
            while($price = $dbprice->GetNext())
            {               
                $properties = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$id, "CODE" => $price["code"]));
                if(!$properties->GetNext())
                {
                    $arFields = Array(
                      "NAME" => $price["name"],
                      "ACTIVE" => "Y",
                      "SORT" => "5555",
                      "CODE" => $price["code"],
                      "PROPERTY_TYPE" => "N",
                      "IBLOCK_ID" => $id
                      );
                    $ibp = new CIBlockProperty;
                    $PropID = $ibp->Add($arFields);
                }
            }


            CMarketCatalog::Add($id);
        }
    }

}

$catalog = CMarketCatalog::GetList();
$already_catalog = array();
while($cat = $catalog->GetNext())
    $already_catalog[] = $cat["ID"];
?>




<?
$aTabs = array(
	array("DIV" => "edit1", "TAB" => GetMessage("YEN_TAB_1_NAME"), "TITLE" => GetMessage("YEN_TAB_1"))
	
);

$tabControl = new CAdminTabControl("tabControl", $aTabs);
?>
<?
$tabControl->Begin();
?>

<?$tabControl->BeginNextTab();?>
<tr><td>
<form method="POST" action="<?=$APPLICATION->GetCurUri()?>">
    <input type="hidden" value="Y" name="action"/>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="internal">
            <tr class="heading">
                    <td width="80%" valign="top"><?=GetMessage("YEN_IBLOCK_SELECT_NAME")?></td>
                    <td valign="top"><?=GetMessage("YEN_IBLOCK_SELECT")?></td>
            </tr>
            <?
            $db_res = CIBlock::GetList(Array("iblock_type"=>"asc", "name"=>"asc"));
            while ($res = $db_res->GetNext())
            {
                if($res["IBLOCK_TYPE_ID"] == "yenisite_market")
                    continue;
                if(in_array($res["ID"], $already_catalog))
                    $checked = "checked='checked'";
                else 
                    $checked = "";

            ?>
                    <tr>
                            <td><?="[<a title='".GetMessage("CO_IB_TYPE_ALT")."' href='iblock_admin.php?type=".$res["IBLOCK_TYPE_ID"]."&lang=".LANGUAGE_ID."'>".$res["IBLOCK_TYPE_ID"]."</a>] <a title='".GetMessage("CO_IB_ELEM_ALT")."' href='iblock_element_admin.php?type=".$res["IBLOCK_TYPE_ID"]."&IBLOCK_ID=".$res["ID"]."&lang=".LANGUAGE_ID."&filter_section=-1&&filter=Y&set_filter=Y'>".$res["NAME"]."</a> (<a href='site_edit.php?LID=".$res["LID"]."&lang=".LANGUAGE_ID."' title='".GetMessage("CO_SITE_ALT")."'>".$res["LID"]."</a>)"?></td>
                            <td align="center"><input type="checkbox" name="IS_CATALOG_<?echo $res["ID"] ?>" <?=$checked?> value="Y" /></td>

                    </tr>
            <?
            }
            ?>
                    
    </table>
    <br/>
    <input type="submit" name="Update" value="<?echo GetMessage("MAIN_SAVE")?>">
</form>
</td></tr>



<? $tabControl->End(); ?>

<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>