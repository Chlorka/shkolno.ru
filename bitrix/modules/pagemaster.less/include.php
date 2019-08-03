<?
/*
	@dir = '../less'  // переменная
	[ ] - dir // директория
		[x] main.less -f -d > main.css <tag>, 2.css <tag2> // использование тегов, опции для генерации
		[x] s.less > <tag>, main.css+ // перечисление нескольких файлов, добавление в конце
		[x] slides.* > +main.css // добавление в начале
		[ ] *.less > =main.css // - замена файла
		[ ] {/asd/} -f > @dir/&.css // переменные, регулярные выражения
	
	[ ] *.* > <test>
 * 
 * - профилиирование (использование нескольких настроек по типу веток)
 */

IncludeModuleLangFile(__FILE__);

class CLess
{
	function less()
	{
		$path = $_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH;
		
		require 'less/lessc.inc.php';
		$less = new lessc;
		$less->setFormatter("compressed");
		if (file_exists($path . '/less/_all.less')) {
			try {
				$less->compileFile($path . '/less/_all.less', $path . '/template_styles.css');
			} catch (exception $e) {
				echo $e->getMessage();
			}
		}
	}
}
?>