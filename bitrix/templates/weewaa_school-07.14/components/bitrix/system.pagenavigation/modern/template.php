<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}
?>
<nav class="ww-pagenav ww-group">
<?

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
?>
	<?/*?><span class="modern-page-title"><?=GetMessage("pages")?></span><?*/?>
<?
if($arResult["bDescPageNumbering"] === true):
	$bFirst = true;
	if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
		if($arResult["bSavePage"]):
?>
<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]+1);?>
            <?$s=str_replace(array("ajax_call=y","AJAX_CALL=Y"),"",$s);?>
			<a class="modern-page-previous" href="<?=$s;?>"><?=GetMessage("nav_prev")?></a>
<?
		else:
			if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1) ):
?>
<?$s=$arResult["sUrlPath"].''.$strNavQueryStringFull?>
            <?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>

			<a class="modern-page-previous" href="<?=$s?>"><?=GetMessage("nav_prev")?></a>
<?
			else:
?>

<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]+1)?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>

			<a class="modern-page-previous" href="<?=$s;?>"><?=GetMessage("nav_prev")?></a>
<?
			endif;
		endif;

		if ($arResult["nStartPage"] < $arResult["NavPageCount"]):
			$bFirst = false;
			if($arResult["bSavePage"]):
?>
<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.$arResult["NavPageCount"]?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>

			<a class="modern-page-first" href="<?=$s?>">1</a>
<?
			else:
?>
<?$s=$arResult["sUrlPath"].''.$strNavQueryStringFull?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>
			<a class="modern-page-first" href="<?=$s;?>">1</a>
<?
			endif;
			if ($arResult["nStartPage"] < ($arResult["NavPageCount"] - 1)):
/*?>
			<span class="modern-page-dots">...</span>
<?*/
?>

<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.intVal($arResult["nStartPage"] + ($arResult["NavPageCount"] - $arResult["nStartPage"]) / 2)?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>

			<a class="modern-page-dots" href="<?=$s?>">...</a>
<?
			endif;
		endif;
	endif;
	do
	{
		$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;

		if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
?>
		<span class="<?=($bFirst ? "modern-page-first " : "")?>modern-page-current"><?=$NavRecordGroupPrint?></span>
<?
		elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):
?>
<?$s=$arResult["sUrlPath"].''.$strNavQueryStringFull?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>


		<a href="<?=$s?>" class="<?=($bFirst ? "modern-page-first" : "")?>"><?=$NavRecordGroupPrint?></a>
<?
		else:
?>

<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.$arResult["nStartPage"]?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>

		<a href="<?=$s?>"<?
			?> class="<?=($bFirst ? "modern-page-first" : "")?>"><?=$NavRecordGroupPrint?></a>
<?
		endif;

		$arResult["nStartPage"]--;
		$bFirst = false;
	} while($arResult["nStartPage"] >= $arResult["nEndPage"]);

	if ($arResult["NavPageNomer"] > 1):
		if ($arResult["nEndPage"] > 1):
			if ($arResult["nEndPage"] > 2):
/*?>
		<span class="modern-page-dots">...</span>
<?*/
?>
<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.round($arResult["nEndPage"] / 2)?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>

		<a class="modern-page-dots" href="<?=$s?>">...</a>
<?
			endif;
?>
<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'=1';?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>


		<a href="<?=$s;?>"><?=$arResult["NavPageCount"]?></a>
<?
		endif;

?>

<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]-1)?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>


		<a class="modern-page-next" href="<?=$s;?>"><?=GetMessage("nav_next")?></a>
<?
	endif; 

else:
	$bFirst = true;

	if ($arResult["NavPageNomer"] > 1):
		if($arResult["bSavePage"]):
?>
<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]-1)?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>

			<a class="modern-page-previous" href="<?=$s?>"><?=GetMessage("nav_prev")?></a>
<?
		else:
			if ($arResult["NavPageNomer"] > 2):
?>
<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]-1)?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>

			<a class="modern-page-previous" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=GetMessage("nav_prev")?></a>
<?
			else:
?>
<?$s=$arResult["sUrlPath"].''.$strNavQueryStringFull?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>

			<a class="modern-page-previous" href="<?=$s;?>"><?=GetMessage("nav_prev")?></a>
<?
			endif;

		endif;

		if ($arResult["nStartPage"] > 1):
			$bFirst = false;
			if($arResult["bSavePage"]):
?>

<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'=1';?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>


			<a class="modern-page-first" href="<?=$s?>">1</a>
<?
			else:
?>

<?$s=$arResult["sUrlPath"].''.$strNavQueryStringFull?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>


			<a class="modern-page-first" href="<?=$s;?>">1</a>
<?
			endif;
			if ($arResult["nStartPage"] > 2):
/*?>
			<span class="modern-page-dots">...</span>
<?*/
?>

<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.round($arResult["nStartPage"] / 2)?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>

			<a class="modern-page-dots" href="<?=$s;?>">...</a>
<?
			endif;
		endif;
	endif;

	do
	{
		if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
?>
		<span class="<?=($bFirst ? "modern-page-first " : "")?>modern-page-current"><?=$arResult["nStartPage"]?></span>
<?
		elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
?>

<?$s=$arResult["sUrlPath"].''.$strNavQueryStringFull?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>


		<a href="<?=$s?>" class="<?=($bFirst ? "modern-page-first" : "")?>"><?=$arResult["nStartPage"]?></a>
<?
		else:
?>

<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.$arResult["nStartPage"]?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>

		<a href="<?=$s?>" <?
			?> class="<?=($bFirst ? "modern-page-first" : "")?>"><?=$arResult["nStartPage"]?></a>
<?
		endif;
		$arResult["nStartPage"]++;
		$bFirst = false;
	} while($arResult["nStartPage"] <= $arResult["nEndPage"]);

	if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
		if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
			if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):
/*?>
		<span class="modern-page-dots">...</span>
<?*/
?>

<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2)?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>


		<a class="modern-page-dots" href="<?=$s?> ">...</a>
<?
			endif;
?>
<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.$arResult["NavPageCount"]?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>

		<a href="<?=$s?>"><?=$arResult["NavPageCount"]?></a>
<?
		endif;
?>
<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]+1)?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>


		<a class="modern-page-next" href="<?=$s?>"><?=GetMessage("nav_next")?></a>
<?
	endif;
endif;

if ($arResult["bShowAll"]):
	if ($arResult["NavShowAll"]):
?>
<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'SHOWALL_'.$arResult["NavNum"].'=0'?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>

		<a class="modern-page-pagen" href="<?=$s?>"><?=GetMessage("nav_paged")?></a>
<?
	else:
?>

<?$s=$arResult["sUrlPath"].'?'.$strNavQueryString.'SHOWALL_'.$arResult["NavNum"].'=1'?>
<?$s=str_replace(array("ajax_call=y","ajax=y","AJAX_CALL=Y"),"",$s);?>
		<a class="modern-page-all" href="<?=$s?>"><?=GetMessage("nav_all")?></a>
<?
	endif;
endif
?>
</nav>