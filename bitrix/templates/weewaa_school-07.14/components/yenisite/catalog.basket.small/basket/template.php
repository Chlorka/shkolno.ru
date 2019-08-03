<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
	<section id="ww-main_bascket">
				<b>Ваша корзина</b>
				<span>Товаров: <?=$arResult["COMMON_COUNT"]?></span><span class="price">Сумма: <?=$arResult["COMMON_PRICE"]?><?if($arResult["COMMON_PRICE"]>0) echo '&nbsp;р.';?></span>
				<?if($arResult["COMMON_PRICE"]>0):?><section><a href="?del_all=Y">Очистить корзину</a><a href="/account/cart/">Оформить заказ</a></section><?endif;?>
	</section>
