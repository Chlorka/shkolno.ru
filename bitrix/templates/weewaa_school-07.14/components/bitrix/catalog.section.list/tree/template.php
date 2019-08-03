<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$strTitle = "";
?>
<?=($strTitle?'<br/><h2>'.$strTitle.'</h2>':'')?>
<?//r($arResult);?>
<aside id="ww-catalog_link">
	<ul class="tabs">
		<?
		$index=1;
		foreach($arResult["SECTIONS"] as $arSection)
		{?>
			<?if($arSection["DEPTH_LEVEL"]==1):?>
				<li><a href="#tab<?=$arSection["ID"];?>"><?=$arSection["NAME"];?></a></li>
			<?endif;?>
		<?}?>
	</ul>	
	<div class="clear"></div>
    <div class="tab_container">
	<?
	$TOP_DEPTH = $arResult["SECTION"]["DEPTH_LEVEL"];
	$CURRENT_DEPTH = $TOP_DEPTH;
$section='';
	foreach($arResult["SECTIONS"] as $arSection)
	{
		if($arSection["DEPTH_LEVEL"]=='1'):
			$section=$arSection["ID"];
		endif;
				
		$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
		$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
		if($CURRENT_DEPTH < $arSection["DEPTH_LEVEL"])
		{
			if($arSection["DEPTH_LEVEL"]=='1'):
			//	$section=$arSection["ID"];
			else:
				$replace = '<div id="tab'.$section.'" class="tab_content">';
				echo "\n",str_repeat("\t", $arSection["DEPTH_LEVEL"]-$TOP_DEPTH),$replace;
			endif;
		}
		elseif($CURRENT_DEPTH == $arSection["DEPTH_LEVEL"])
		{
			echo "";
		}
		else
		{
			while($CURRENT_DEPTH > $arSection["DEPTH_LEVEL"])
			{
				echo "";
				echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"</div>","\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH-1);
				$CURRENT_DEPTH--;
			}
			echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"";
		}

		$count = $arParams["COUNT_ELEMENTS"] && $arSection["ELEMENT_CNT"] ? "&nbsp;(".$arSection["ELEMENT_CNT"].")" : "";

		if ($_REQUEST['SECTION_ID']==$arSection['ID'])
		{
		}
		else
		{
			$link = '<a href="'.$arSection["SECTION_PAGE_URL"].'">'.$arSection["NAME"].'</a>';
		}

		echo "\n",str_repeat("\t", $arSection["DEPTH_LEVEL"]-$TOP_DEPTH);
		/*?><li id="<?=$this->GetEditAreaId($arSection['ID']);?>"><?*/?>
			<?if($arSection["DEPTH_LEVEL"]!='1'):?><?=$link?><?endif;?>
	<?
		$CURRENT_DEPTH = $arSection["DEPTH_LEVEL"];
	}

	while($CURRENT_DEPTH > $TOP_DEPTH)
	{
		echo "";
		echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"</div>","\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH-1);
		$CURRENT_DEPTH--;
	}
	?>
	</div>
<div class="clear"></div>
</aside>
<?//r($arParams);?>
