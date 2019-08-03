<?foreach($arResult["ITEMS"] as &$arItem):?>
		<?foreach($arParams["PROPERTY_CODE"] as &$code): 
				if($code == 'PAYMENT_E'):?>
						<?if(is_array($arItem["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])):?>
							<?foreach($arItem["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"] as $k=>$el):?>
								
							<?endforeach?>
						<?else:?>
							<?//=$arItem["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"];?>
							<?//r($arItem["DISPLAY_PROPERTIES"][$code]["VALUE"]);?>
							<?$arItem["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"] = $arItem["DISPLAY_PROPERTIES"][$code]["LINK_ELEMENT_VALUE"][$arItem["DISPLAY_PROPERTIES"][$code]["VALUE"]]["~NAME"];?>
						<?endif?>
				<?endif;?>						
			<?endforeach;?>
			<?unset($code);?>
<?endforeach;?>
<?unset($arItem);?>	