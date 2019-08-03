<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
</section>
 <?=$APPLICATION->ShowProperty("COMPONENT.SECTION");?> 
<footer id="ww-main_footer">
		<section class="ww-main_content">
			<aside class="ww-socserv">
				<?$APPLICATION->IncludeFile(SITE_DIR . ".inc/socserv-link.php", array(), array("MODE"=>"html"));?>
			</aside>
			<aside class="ww-link">
				<?$APPLICATION->IncludeFile(SITE_DIR . ".inc/footer-link.php", array(), array("MODE"=>"html"));?>
			</aside>
			<aside id="ww-copyright">
				<?$APPLICATION->IncludeFile(SITE_DIR . ".inc/copyright.php", array(), array("MODE"=>"html"));?>
			</aside>
		</section>
</footer>
<!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter25778186 = new Ya.Metrika({id:25778186, clickmap:true, trackLinks:true, accurateTrackBounce:true, trackHash:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/25778186" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
</body>
</html>