<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="pm-site-basket">
	<div class="pm-inner">
		<h2><a class="pm-icon-cart" href="/personal/cart/">�������</a></h2>
		<span class="pm-site-basket-info">
		<?if ($arResult["ALL_QUANTITY"] > 0):?>
		�� ����� <?=$arResult["ALL_PRICE_FORMAT"]?>
		<?else:?>
		� ������� ��� �������
		<?endif?>
		</span>
	</div>
</div>