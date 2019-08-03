<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Контактная информация");
$APPLICATION->SetPageProperty("keywords", "как проехать, адрес салона всегда в форме");
$APPLICATION->SetPageProperty("description", "контактная информация");
$APPLICATION->SetTitle("Контакты");
?><p>
 <b><span style="color: #f16522;">САЛОН "ВСЕГДА В ФОРМЕ"</span></b>
</p>
<p>
 <b>Адрес:</b> г. Красноярск, ул. Мате Залки 10 г, ТК “Кристалл”, 2 этаж, офис 14.<br>
 <b>Телефон:</b> 8 (391)&nbsp;278-82-10, 8 (913) 577-41-79<br>
 <b>Электронная почта:</b> <a href="mailto:shkolno@vforme24.ru">shkolno@vforme24.ru</a><br>
 <b>Режим работы:</b><br>
 <span class="round">пн</span><span class="round">вт</span><span class="round">ср</span><span class="round">чт</span><span class="round">пт</span> - с 11:00 до 19:00<br>
 <span class="round round-blue">сб</span><span class="round round-blue">вс</span> - выходные&nbsp;
</p>
<p>
	<span style="color: #ff0000;"><b>Внимание: в течение августа мы работаем также по субботам и воскресеньям до 16.00</b></span>
</p>
<p>
</p>
<p>
 <b>Как к нам проехать:</b>
</p>
<p>
	 На автомобиле:<b><br>
 </b><span style="background-color: #ffffff;">Чтобы добраться на автомобиле из центра нужно&nbsp;следовать по&nbsp;ул.&nbsp;9 Мая, затем повернуть направо на&nbsp;проспект Комсомольский. Далее&nbsp;повернуть налево на 1 светофоре&nbsp;и следовать до ТК "Кристалл".</span>
</p>
<p>
 <span style="background-color: #ffffff; line-height: 1.4;">На общественном транспорте:<b><br>
 </b><span style="background-color: #ffffff;">Из центра от ост.&nbsp;Горького до ост.&nbsp; Комсомольский проспект&nbsp; - &nbsp;троллейбус&nbsp;8, автобус&nbsp;88.</span><br style="background-color: #ffffff;">
 <span style="background-color: #ffffff;">От Свободного квартала&nbsp; до ост. &nbsp;Комсомольский проспект - &nbsp;автобус 87.</span><br style="background-color: #ffffff;">
 <span style="background-color: #ffffff;">От КрасТЭЦ&nbsp; до&nbsp;ост. &nbsp;Комсомольский проспект -&nbsp; автобусы&nbsp;20, 85, 79.</span><br style="background-color: #ffffff;">
 <span style="background-color: #ffffff;">От ТРЦ Планета до ост. Шумяцкого - &nbsp;автобусы 50, 79.</span><br style="background-color: #ffffff;">
 <span style="background-color: #ffffff;">Из мкр. Солнечный до ост. &nbsp;Комсомольский проспект&nbsp; - &nbsp;автобусы&nbsp;23, 61, 87.</span><br>
 </span>
</p>
<h2>Схема</h2>
<p>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:map.yandex.view",
	".default",
	Array(
		"CONTROLS" => "",
		"INIT_MAP_TYPE" => "MAP",
		"MAP_DATA" => "a:4:{s:10:\"yandex_lat\";d:56.06356780749312;s:10:\"yandex_lon\";d:92.93472170122527;s:12:\"yandex_scale\";i:15;s:10:\"PLACEMARKS\";a:1:{i:0;a:3:{s:3:\"LON\";d:92.93824075945282;s:3:\"LAT\";d:56.064071988826434;s:4:\"TEXT\";s:67:\"г. Красноярск, ул. Мате Залки 10 г, ТК “Кристалл”, 2 этаж, офис 16.\";}}}",
		"MAP_HEIGHT" => "550",
		"MAP_ID" => "",
		"MAP_WIDTH" => "1000",
		"OPTIONS" => array(0=>"ENABLE_SCROLL_ZOOM",1=>"ENABLE_DRAGGING",)
	)
);?>
</p>
<p>
 <br>
</p>
<p>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"feedback",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "N",
		"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID",),
		"WEB_FORM_ID" => "1"
	)
);?><br>
</p><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>