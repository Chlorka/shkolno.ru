<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
	<section id="ww-main_bascket">
				<b>���� �������</b>
				<span>�������: <?=$arResult["COMMON_COUNT"]?></span><span class="price">�����: <?=$arResult["COMMON_PRICE"]?><?if($arResult["COMMON_PRICE"]>0) echo '&nbsp;�.';?></span>
				<?if($arResult["COMMON_PRICE"]>0):?><section><a href="?del_all=Y">�������� �������</a><a href="/account/cart/">�������� �����</a></section><?endif;?>
	</section>
