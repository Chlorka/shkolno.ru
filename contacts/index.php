<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "���������� ����������");
$APPLICATION->SetPageProperty("keywords", "��� ��������, ����� ������ ������ � �����");
$APPLICATION->SetPageProperty("description", "���������� ����������");
$APPLICATION->SetTitle("��������");
?><p>
 <b><span style="color: #f16522;">����� "������ � �����"</span></b>
</p>
<p>
 <b>�����:</b> �. ����������, ��. ���� ����� 10 �, �� ���������, 2 ����, ���� 14.<br>
 <b>�������:</b> 8 (391)&nbsp;278-82-10, 8 (913) 577-41-79<br>
 <b>����������� �����:</b> <a href="mailto:shkolno@vforme24.ru">shkolno@vforme24.ru</a><br>
 <b>����� ������:</b><br>
 <span class="round">��</span><span class="round">��</span><span class="round">��</span><span class="round">��</span><span class="round">��</span> - � 11:00 �� 19:00<br>
 <span class="round round-blue">��</span><span class="round round-blue">��</span> - ��������&nbsp;
</p>
<p>
	<span style="color: #ff0000;"><b>��������: � ������� ������� �� �������� ����� �� �������� � ������������ �� 16.00</b></span>
</p>
<p>
</p>
<p>
 <b>��� � ��� ��������:</b>
</p>
<p>
	 �� ����������:<b><br>
 </b><span style="background-color: #ffffff;">����� ��������� �� ���������� �� ������ �����&nbsp;��������� ��&nbsp;��.&nbsp;9 ���, ����� ��������� ������� ��&nbsp;�������� �������������. �����&nbsp;��������� ������ �� 1 ���������&nbsp;� ��������� �� �� "��������".</span>
</p>
<p>
 <span style="background-color: #ffffff; line-height: 1.4;">�� ������������ ����������:<b><br>
 </b><span style="background-color: #ffffff;">�� ������ �� ���.&nbsp;�������� �� ���.&nbsp; ������������� ��������&nbsp; - &nbsp;����������&nbsp;8, �������&nbsp;88.</span><br style="background-color: #ffffff;">
 <span style="background-color: #ffffff;">�� ���������� ��������&nbsp; �� ���. &nbsp;������������� �������� - &nbsp;������� 87.</span><br style="background-color: #ffffff;">
 <span style="background-color: #ffffff;">�� �������&nbsp; ��&nbsp;���. &nbsp;������������� �������� -&nbsp; ��������&nbsp;20, 85, 79.</span><br style="background-color: #ffffff;">
 <span style="background-color: #ffffff;">�� ��� ������� �� ���. ��������� - &nbsp;�������� 50, 79.</span><br style="background-color: #ffffff;">
 <span style="background-color: #ffffff;">�� ���. ��������� �� ���. &nbsp;������������� ��������&nbsp; - &nbsp;��������&nbsp;23, 61, 87.</span><br>
 </span>
</p>
<h2>�����</h2>
<p>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:map.yandex.view",
	".default",
	Array(
		"CONTROLS" => "",
		"INIT_MAP_TYPE" => "MAP",
		"MAP_DATA" => "a:4:{s:10:\"yandex_lat\";d:56.06356780749312;s:10:\"yandex_lon\";d:92.93472170122527;s:12:\"yandex_scale\";i:15;s:10:\"PLACEMARKS\";a:1:{i:0;a:3:{s:3:\"LON\";d:92.93824075945282;s:3:\"LAT\";d:56.064071988826434;s:4:\"TEXT\";s:67:\"�. ����������, ��. ���� ����� 10 �, �� ���������, 2 ����, ���� 16.\";}}}",
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