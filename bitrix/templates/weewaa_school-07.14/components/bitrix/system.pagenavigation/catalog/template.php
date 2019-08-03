<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arSort = array(
	"def" =>
		array(
			"TITLE" => "-",
			"BY" => "asc",
			"ORDER" => "sort",
			"INDEX" => 0
		),
	"sort1" =>
		array(
			"TITLE" => "возрастанию цены",
			"BY" => "asc",
			"ORDER" => "CATALOG_PRICE_" . pmGetPriceType("ID"),
			"INDEX" => false
		),
	"sort2" =>
		array(
			"TITLE" => "убыванию цены",
			"BY" => "desc",
			"ORDER" => "CATALOG_PRICE_" . pmGetPriceType("ID"),
			"INDEX" => false
		),
	"sort3" =>
		array(
			"TITLE" => "производителю",
			"BY" => "asc",
			"ORDER" => "NAME",
			"INDEX" => false
		)
);

$arPerPage = array(15, 30, 45);
?>
	<form class="pm-form-misc" method="get" action="">
		<span class="pm-count-all">Найдено <?=str_ending($arResult["NavRecordCount"], array('товаров', 'товар', 'товара'))?></span>

		<span class="pm-sort">Сортировать по:
			<select name="sort"> 
			<?foreach (pSort::Sort($arSort) as $code => $sort):?>
				<option value="<?=$code?>"<?if ($sort["INDEX"] !== false):?> selected="selected"<?endif?>><?=$sort["TITLE"]?></option>
			<?endforeach?>
			</select>
		</span>
		
		<span class="pm-cnt">Отображать по:
			<select name="cnt">
			<?
			if (isset($_GET["cnt"]) && in_array($_GET["cnt"], $arPerPage)) {
				$current = $_GET["cnt"];
			}			
			foreach ($arPerPage as $cnt) {
				if ($cnt == $current):
				?>
					<option value="<?=$cnt?>" selected="selected"><?=$cnt?></option>
				<?else:?>
					<option value="<?=$cnt?>"><?=$cnt?></option>
				<?
				endif;
			}
			?>
			</select>
		</span>
		
		<?foreach ($_GET as $key => $value) {
			$key = htmlspecialchars($key);
			if (in_array($key, array('sort', 'cnt', 'clear_cache', 'ajax_catalog_section', 'ajax_cart'))) continue;
			if (is_array($value)) {
				foreach ($value as $_key => $_value) {
					$_key = htmlspecialchars($_key);
					$_value = htmlspecialchars($_value);
					?><input type="hidden" name="<?=$key?>[<?=$_key?>]" value="<?=$_value?>"><?
				}
			} else {
				$value = htmlspecialchars($value);
				?><input type="hidden" name="<?=$key?>" value="<?=$value?>"><?
			}
		}
		?>
	</form>

<?
if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
?>

<nav class="pm-pagenav">
	<header class="pm-pagenav-title">Страница</header>
	<ul>
<?if($arResult["bDescPageNumbering"] === true):?>

	<div class="nav-title"><?=$arResult["NavTitle"]?> <?=$arResult["NavFirstRecordShow"]?> - <?=$arResult["NavLastRecordShow"]?> <?=GetMessage("nav_of")?> <?=$arResult["NavRecordCount"]?></div>

	<div class="nav-pages">
		
	<?if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
		<?if($arResult["bSavePage"]):?>
			<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=GetMessage("nav_begin")?></a></li>
			<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">&laquo;</a></li>
		<?else:?>
			<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=GetMessage("nav_begin")?></a></li>
			<?if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1) ):?>
				<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">&laquo;</a></li>
			<?else:?>
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">&laquo;</a></li>
			<?endif?>
		<?endif?>
	<?endif?>

	<?while($arResult["nStartPage"] >= $arResult["nEndPage"]):?>
		<?$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;?>

		<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
			<span class="nav-current-page">&nbsp;<?=$NavRecordGroupPrint?>&nbsp;</span>&nbsp;
		<?elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):?>
			<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$NavRecordGroupPrint?></a>&nbsp;
		<?else:?>
			<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$NavRecordGroupPrint?></a>&nbsp;
		<?endif?>

		<?$arResult["nStartPage"]--?>
	<?endwhile?>

	<?if ($arResult["NavPageNomer"] > 1):?>
		|&nbsp;<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">&raquo;</a></li>
		<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?=GetMessage("nav_end")?></a>&nbsp;
	<?endif?>

<?else:?>

	<?if ($arResult["NavPageNomer"] > 1):?>

		<?if($arResult["bSavePage"]):?>
			<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?=GetMessage("nav_begin")?></a>
		<?else:?>
			<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=GetMessage("nav_begin")?></a>
		<?endif?>

	<?else:?>
		
	<?endif?>

	<?while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>

		<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
			<li><span class="nav-current-page"><?=$arResult["nStartPage"]?></span></li>
		<?elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
			<li><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a></li>
		<?else:?>
			<li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a></li>
		<?endif?>
		<?$arResult["nStartPage"]++?>
	<?endwhile?>
	
	<?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
		<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=GetMessage("nav_end")?></a>
	<?else:?>
		
	<?endif?>

<?endif?>


<?if ($arResult["bShowAll"]):?>
	<li>
	<?if ($arResult["NavShowAll"]):?>
		<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=0" rel="nofollow"><?=GetMessage("nav_paged")?></a> 
	<?else:?>
		<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=1" rel="nofollow"><?=GetMessage("nav_all")?></a>
	<?endif?>
	</li>
<?endif?>

	</ul>
</nav>

<div class="pm-clear"></div>
