<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("ferm");
?>

	<div class='content-block content-block-bord-bott'>
		<table width='100%'><tr>
			<td width='240' valign='top'><div id='content-pic1'></div></td>
			<td valign='top'>
				
			</td>
		</tr></table>
	</div>

<div class='content-block content-block-bord-bott'>
		<table width='100%'><tr>
			<td width='240'><div id='content-pic2'></div></td>
			<td>
				<p class='content-header'><a name='b2'></a>
									
			</td>
		</tr></table>
	</div>
	
	<div class='content-block'>
		<table width='100%'><tr>
			<td width='240'><div id='content-pic3'></div></td>
			<td>
			</td>
		</tr></table>
	</div>
	
	<div class='content-block' style='text-align:center;'>
		<div class='block-tr-1'>

		</div>
		<div class='block-tr-1'>
			</div>
		<div class='block-tr-2'>
			</div>
	</div>
	
	<div class='content-block content-block-bord-bott'>
		<table width='100%'><tr>
			<td>
				
			</td>
			<td width='240' align='right'><div id='content-pic4'></div></td>
		</tr></table>
	</div>
	
	<div class='content-block content-block-bord-bott'>
		<table width='100%'><tr>
			<td width='240'><div id='content-pic5'></div></td>
			<td>
				</td>
		</tr></table>
	</div>
	
	<div>
		<p class='content-header' style='text-align:center;'><a name='b6'></a>
		<ul class='scr-list'>
			</ul>
	</div>
	
	<div class='content-block content-block-bord-bott'>
		<table width='100%'><tr>
			<td>
				
			</td>
			<td width='240' align='right'><div id='content-pic6'></div></td>
		</tr></table>
	</div>
	
	<div class='content-block'>
		<table width='100%'><tr>
			<td width='240'><div id='content-pic7'></div></td>
			<td>
				</td>
		</tr></table>
	</div>
	
	<div class='content-block'>
		<table width='100%'><tr>
			<td style='padding-right: 50px;' valign='top'>
				</td>
			<td align='right'>
				<div class='block-dotted-border'>
					<p class='style-checkbox'><input type='checkbox' value='1' id='direct' checked><label for='direct'> </label>
					<p class='style-checkbox'><input type='checkbox' value='1' id='adwords' checked><label for='adwords'> </label>
					<p class='style-checkbox'><input type='checkbox' value='1' id='metrica' checked><label for='metrica'> </label>
					<p class='style-checkbox'><input type='checkbox' value='1' id='analytics' checked><label for='analytics'> </label>
					<p style='margin-top:20px;'><input type='text' name='email' placeholder='E-mail' style='width:200px;' id='subscribe_email' class='check_field'> <input type='button' class='blue-button' value='Подписаться' onClick='susbscribe_features(function(){_gaq.push(["_trackEvent","Website","News","Send"]);});'>
				</div>
			</td>
		</tr></table>
	</div>
	
	<div class='orange-block'>
		<div class='content-block'>
			<div style='height:40px;'></div>
			<table width='100%'><tr>
				<td style='padding-right: 50px;' valign='top'>
					<div style='height:3px;'></div>
					<p><a href='tariffs/' class='orange-button'></a>
				</td>
				<td align='right'>
					<div class='block-dotted-border'>
						<p><input type='text' name='email' placeholder='E-mail' style='width:200px;' class='check_field reg_email'> <input type='button' class='blue-button' value='Начать работу' onClick='send_email($(this).prev().val(),an_tryit_send);'>
					</div>
				</td>
			</tr></table>
		</div>
	</div>
	
	<div class='content-block'>
		<table width='100%'><tr>
			<td style='padding-right: 50px;' valign='top'>
				<p class='content-header'><a name='b10'></a>
				<p> <a href='faq/'>F.A.Q.</a>
			</td>
			<td align='right'>
				<div class='block-dotted-border'>
					<table width='100%' cellspacing='20'>
						<tr><td></td><td align='right'><input type='text' name='name' style='width:205px;' id='contact_name' class='check_field'></td></tr>
						<tr><td></td><td align='right'><input type='text' name='email' style='width:205px;' id='contact_email' class='check_field'></td></tr>
						<tr><td></td><td align='right'><textarea style='width:207px;height:160px;' id='contact_q' class='check_field'></textarea></td></tr>
						<tr><td></td><td align='right'><input type='button' class='blue-button' value='Задать вопрос' onClick='contact_form(this,an_askus_send);'></td></tr>
					</table>
				</div>
			</td>
		</tr></table>
	</div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>