<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetTitle("Пользовательское соглашение");?>

<p>В разработке</p>
Согласен со всем - покупаю
<?$APPLICATION->IncludeFile(SITE_DIR . ".inc/licenziya.php", array(), array("MODE"=>"html"));?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>