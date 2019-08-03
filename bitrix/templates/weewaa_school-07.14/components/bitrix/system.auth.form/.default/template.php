<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="bx-system-auth-form">
<?if($arResult["FORM_TYPE"] == "login"):?>
	<?
	if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
		ShowMessage($arResult['ERROR_MESSAGE']);
	?>
	<form class="pm-site-auth" name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
		<?if($arResult["BACKURL"] <> ''):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>">
		<?endif?>
	
		<?foreach ($arResult["POST"] as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>">
		<?endforeach?>
		
		<input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="AUTH">
		
		<fieldset>
			<label for="USER_LOGIN"><?=GetMessage("AUTH_LOGIN")?></label>
			<input type="text" id="USER_LOGIN" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" size="17">
		</fieldset>
	
		<fieldset>
			<label for="USER_PASSWORD"><?=GetMessage("AUTH_PASSWORD")?></label>
			<input type="password" id="USER_PASSWORD" name="USER_PASSWORD" maxlength="50" size="17">
		</fieldset>
			
		<?if($arResult["SECURE_AUTH"]):?>
		<span class="bx-auth-secure" id="bx_auth_secure<?=$arResult["RND"]?>" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
			<div class="bx-auth-secure-icon"></div>
		</span>
		<noscript>
		<span class="bx-auth-secure" title="<?=GetMessage("AUTH_NONSECURE_NOTE")?>">
			<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
		</span>
		</noscript>
		<script type="text/javascript">
		document.getElementById('bx_auth_secure<?=$arResult["RND"]?>').style.display = 'inline-block';
		</script>			
		<?endif?>
			
		<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
			<input type="hidden" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y">
			<label for="USER_REMEMBER_frm" title="<?=GetMessage("AUTH_REMEMBER_ME")?>"><?=GetMessage("AUTH_REMEMBER_SHORT")?></label>
		<?endif?>
		
		<fieldset class="pm-form__button">
			<input class="pm-button" type="submit" name="Login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>">
		</fieldset>
		
		<fieldset class="pm-form__link">
			<a href="<?=$arParams["REGISTER_URL"]?>"><?=GetMessage("AUTH_LINK")?></a>	
			<?if($arResult["NEW_USER_REGISTRATION"] == "Y"):?>
			| <noindex><a href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a></noindex>
			<?endif?>			
		</fieldset>
		
		<?/*<noindex><a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a></noindex><?*/?>	
		
		<?if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'] && $arResult["CAPTCHA_CODE"]):
			if (strpos($APPLICATION->GetCurDir(), $arParams["REGISTER_URL"]) === false) {
				LocalRedirect($arParams["REGISTER_URL"]);
			}/*
		?>
		<fieldset>
			<label><?echo GetMessage("AUTH_CAPTCHA_PROMT")?></label>
			<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>">
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA">
			<input type="text" name="captcha_word" maxlength="50" value="">
		</fieldset>
		<?*/endif?>
	
		<?/*if($arResult["AUTH_SERVICES"]):?>
			<div class="bx-auth-lbl"><?=GetMessage("socserv_as_user_form")?></div>
			<?
			$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "icons", 
				array(
					"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
					"SUFFIX"=>"form",
				), 
				$component, 
				array("HIDE_ICONS"=>"Y")
			);
			?>
		<?endif*/?>
	</form>

	<?/*if($arResult["AUTH_SERVICES"]):?>
	<?
	$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "", 
		array(
			"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
			"AUTH_URL"=>$arResult["AUTH_URL"],
			"POST"=>$arResult["POST"],
			"POPUP"=>"Y",
			"SUFFIX"=>"form",
		), 
		$component, 
		array("HIDE_ICONS"=>"Y")
	);
	?>
	<?endif*/?>
<?
//if($arResult["FORM_TYPE"] == "login")
else:
?>
	<a href="<?=$arResult["PROFILE_URL"]?>" title="<?=GetMessage("AUTH_PROFILE")?>"><?=$arResult["USER_LOGIN"]?></a>
	[<a href="<?=$APPLICATION->GetCurPageParam('logout=yes')?>"><?=GetMessage("AUTH_LOGOUT_BUTTON")?></a>]
<?endif?>
</div>