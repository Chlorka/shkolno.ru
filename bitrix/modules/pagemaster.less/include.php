<?
/*
	@dir = '../less'  // ����������
	[ ] - dir // ����������
		[x] main.less -f -d > main.css <tag>, 2.css <tag2> // ������������� �����, ����� ��� ���������
		[x] s.less > <tag>, main.css+ // ������������ ���������� ������, ���������� � �����
		[x] slides.* > +main.css // ���������� � ������
		[ ] *.less > =main.css // - ������ �����
		[ ] {/asd/} -f > @dir/&.css // ����������, ���������� ���������
	
	[ ] *.* > <test>
 * 
 * - ��������������� (������������� ���������� �������� �� ���� �����)
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