<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказ отменен");
?>
<?
if(CModule::IncludeModule("iblock"))
   {
	$el = new CIBlockElement;
	
	$arLoadProductArray = Array(
	  "MODIFIED_BY"    => $USER->GetID(),
	  "ACTIVE"         => "N"
	 );
	
	$PRODUCT_ID = $_GET["ID"];
	$res = $el->Update($PRODUCT_ID, $arLoadProductArray);
   }
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>