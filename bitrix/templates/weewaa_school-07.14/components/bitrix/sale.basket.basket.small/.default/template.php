<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="pm-site-basket">
	<div class="pm-inner">
		<h2><a class="pm-icon-cart" href="/personal/cart/">Корзина</a></h2>
		<span class="pm-site-basket-info">
		<?if ($arResult["ALL_QUANTITY"] > 0):?>
		на сумму <?=$arResult["ALL_PRICE_FORMAT"]?>
		<?else:?>
		В корзине нет товаров
		<?endif?>
		</span>
	</div>
</div>