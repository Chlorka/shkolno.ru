<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
<!doctype html>
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="ru"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="ru"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="ru"> <!--<![endif]-->
<head>
	<meta charset="<?=SITE_CHARSET?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="initial-scale=1.0,width=device-width">
	<script src="<?=SITE_TEMPLATE_PATH?>/js/libs/modernizr.custom.23595.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?=SITE_TEMPLATE_PATH?>/js/libs/jquery-1.7.1.min.js"><\/script>')</script>
	<title><?$APPLICATION->ShowTitle()?></title>
	<?$APPLICATION->ShowHead()?>
	<?/*?><script type="text/javascript" src="/bitrix/js/main/ajax.js"></script><?*/?>
	<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/js/nivo-slider.css" type="text/css" />
	<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/js/fancybox2/source/jquery.fancybox.css" media="screen" />
	<script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.jcarousel.min.js"></script>
	<script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.nivo.slider.pack.js" type="text/javascript"></script>
	<script src="<?=SITE_TEMPLATE_PATH?>/js/fancybox2/source/jquery.fancybox.pack.js"></script>
		
	<script src="<?=SITE_TEMPLATE_PATH?>/js/common.js"></script>
</head>
<body>
<? preg_match_all('/([A-Za-z0-9_]+)/', $APPLICATION->GetCurDir(), $mat);?>
	<?$APPLICATION->ShowPanel();?>	
	
	<header id="ww-main_header">
		<section class="ww-main_content">
			<a href="/" class="ww-logo"></a>
			<?/*?><section class="ww-logo_area">
				<?$APPLICATION->IncludeFile(SITE_DIR . ".inc/logo-area.php", array(), array("MODE"=>"html"));?>
			</section>
			 <?*/?>
			<section id="ww-main_phone">
				<?$APPLICATION->IncludeFile(SITE_DIR . ".inc/top-phone.php", array(), array("MODE"=>"html"));?>
			</section>
			<section id="ww-main_bascket-area">
				<div id="ww-res">
<?/*if (isset($_REQUEST["ajax_bt"])) {
				$APPLICATION->RestartBuffer();
			}?>
					<?$APPLICATION->IncludeComponent(
						"yenisite:catalog.basket.small",
						"basket",
						Array(
						)
					);?>
					
			<?if (isset($_REQUEST["ajax_bt"])) {
				 die();
				}*/
			?>
			</div>
			</section>
			<section class="ww-logo_area_new">
				<?$APPLICATION->IncludeFile(SITE_DIR . ".inc/logo-area_new.php", array(), array("MODE"=>"html"));?>
			</section>
		</section>
		<section id="ww-navi">
			<section class="ww-main_content">
				<?$APPLICATION->IncludeComponent("bitrix:menu", "top", array(
					"ROOT_MENU_TYPE" => "top",
					"MENU_CACHE_TYPE" => "N",
					"MENU_CACHE_TIME" => "3600",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"MENU_CACHE_GET_VARS" => array(
					),
					"MAX_LEVEL" => "1",
					"CHILD_MENU_TYPE" => "left",
					"USE_EXT" => "N",
					"DELAY" => "N",
					"ALLOW_MULTI_SELECT" => "N"
					),
					false
				);?>
			</section>
		</section>
	</header>
	<section class="ww-main_content work-area">
		<nav class="ww-breadcrumb">
		<?if ($APPLICATION->GetCurPage(true) != SITE_DIR . "index.php"):?>
		<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", array(
			"START_FROM" => "",
			"PATH" => "",
			"SITE_ID" => "-"
			),
			false
		);?>
		<?endif;?>&nbsp;
		</nav>
		<?if($mat[0][0] == 'catalog'):?>
			<h1><?$APPLICATION->ShowTitle(false)?></h1>
		<?endif;?>
<?$APPLICATION->IncludeComponent("bitrix:menu", "catalog-sections", Array(
	"ROOT_MENU_TYPE" => "catalog",	// ��� ���� ��� ������� ������
	"MENU_CACHE_TYPE" => "N",	// ��� �����������
	"MENU_CACHE_TIME" => "3600",	// ����� ����������� (���.)
	"MENU_CACHE_USE_GROUPS" => "N",	// ��������� ����� �������
	"MENU_CACHE_GET_VARS" => "",	// �������� ���������� �������
	"MAX_LEVEL" => "2",	// ������� ����������� ����
	"CHILD_MENU_TYPE" => "",	// ��� ���� ��� ��������� �������
	"USE_EXT" => "Y",	// ���������� ����� � ������� ���� .���_����.menu_ext.php
	"DELAY" => "N",	// ����������� ���������� ������� ����
	"ALLOW_MULTI_SELECT" => "Y",	// ��������� ��������� �������� ������� ������������
	),
	false
);?>
<?if ($APPLICATION->GetCurPage(true) != SITE_DIR . "index.php" && $mat[0][0] != 'catalog'):?>
			<h1><?$APPLICATION->ShowTitle(false)?></h1>
<?endif;?>
	<?if ($_SERVER["PHP_SELF"] == "/index.php"):?>
	<?$APPLICATION->IncludeComponent("bitrix:news.list", "main-slider", Array(
	"IBLOCK_TYPE" => "content",	// ��� ��������������� ����� (������������ ������ ��� ��������)
	"IBLOCK_ID" => "3",	// ��� ��������������� �����
	"NEWS_COUNT" => "1",	// ���������� �������� �� ��������
	"SORT_BY1" => "ACTIVE_FROM",	// ���� ��� ������ ���������� ��������
	"SORT_ORDER1" => "DESC",	// ����������� ��� ������ ���������� ��������
	"SORT_BY2" => "ID",	// ���� ��� ������ ���������� ��������
	"SORT_ORDER2" => "DESC",	// ����������� ��� ������ ���������� ��������
	"FILTER_NAME" => "",	// ������
	"FIELD_CODE" => array(	// ����
		0 => "",
		1 => "",
	),
	"PROPERTY_CODE" => array(	// ��������
		0 => "HREF",
		1 => "MORE_PHOTO",
		2 => "",
	),
	"CHECK_DATES" => "Y",	// ���������� ������ �������� �� ������ ������ ��������
	"DETAIL_URL" => "",	// URL �������� ���������� ��������� (�� ��������� - �� �������� ���������)
	"AJAX_MODE" => "N",	// �������� ����� AJAX
	"AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
	"AJAX_OPTION_STYLE" => "N",	// �������� ��������� ������
	"AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
	"CACHE_TYPE" => "A",	// ��� �����������
	"CACHE_TIME" => "36000000",	// ����� ����������� (���.)
	"CACHE_FILTER" => "Y",	// ���������� ��� ������������� �������
	"CACHE_GROUPS" => "N",	// ��������� ����� �������
	"PREVIEW_TRUNCATE_LEN" => "",	// ������������ ����� ������ ��� ������ (������ ��� ���� �����)
	"ACTIVE_DATE_FORMAT" => "d-m-Y",	// ������ ������ ����
	"SET_STATUS_404" => "N",	// ������������� ������ 404, ���� �� ������� ������� ��� ������
	"SET_TITLE" => "N",	// ������������� ��������� ��������
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// �������� �������� � ������� ���������
	"ADD_SECTIONS_CHAIN" => "N",	// �������� ������ � ������� ���������
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// �������� ������, ���� ��� ���������� ��������
	"PARENT_SECTION" => "",	// ID �������
	"PARENT_SECTION_CODE" => "",	// ��� �������
	"INCLUDE_SUBSECTIONS" => "N",	// ���������� �������� ����������� �������
	"PAGER_TEMPLATE" => "",	// ������ ������������ ���������
	"DISPLAY_TOP_PAGER" => "N",	// �������� ��� �������
	"DISPLAY_BOTTOM_PAGER" => "N",	// �������� ��� �������
	"PAGER_TITLE" => "�������",	// �������� ���������
	"PAGER_SHOW_ALWAYS" => "N",	// �������� ������
	"PAGER_DESC_NUMBERING" => "N",	// ������������ �������� ���������
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// ����� ����������� ������� ��� �������� ���������
	"PAGER_SHOW_ALL" => "N",	// ���������� ������ "���"
	"DISPLAY_DATE" => "N",	// �������� ���� ��������
	"DISPLAY_NAME" => "Y",	// �������� �������� ��������
	"DISPLAY_PICTURE" => "N",	// �������� ����������� ��� ������
	"DISPLAY_PREVIEW_TEXT" => "Y",	// �������� ����� ������
	"AJAX_OPTION_ADDITIONAL" => "",	// �������������� �������������
	),
	false
);?>
<?endif;?>
		<?if ($APPLICATION->GetCurPage(true) != SITE_DIR . "index.php"):?>
			
		<?else:?>
		</section>
		<?if ($APPLICATION->GetCurPage(true) == SITE_DIR . "index.php"):?>
			<? $GLOBALS['arrFilter_MAIN']['UF_MAIN_VALUE'] = 1; ?>
			<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list", 
	"main-sections", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"SECTION_ID" => "4",
		"SECTION_CODE" => "",
		"COUNT_ELEMENTS" => "N",
		"USE_FILTER" => "Y",
		"FILTER_NAME" => "arrFilter_MAIN",
		"TOP_DEPTH" => "1",
		"SECTION_FIELDS" => array(
			0 => "DESCRIPTION",
			1 => "",
		),
		"SECTION_USER_FIELDS" => array(
			0 => "UF_MAIN",
			1 => "",
		),
		"SECTION_URL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"VIEW_MODE" => "TILE",
		"SHOW_PARENT_NAME" => "Y",
		"HIDE_SECTION_NAME" => "N"
	),
	false
);?>
		<?endif;?>
			<section class="ww-main_content">
		<?endif?>	