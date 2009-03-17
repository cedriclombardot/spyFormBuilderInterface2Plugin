<?php
$files=array(null=>'-- Select on template -- ');

$list=sfFinder::type('file')->maxdepth(0)->relative()->in(sfConfig::get('sf_plugins_dir').'/spyFormBuilderInterface2Plugin/lib/tpl/form/');
foreach($list as $f)
	$files[$f]=__($f);
echo select_tag('change_theme',options_for_select($files));
echo input_tag('exec_change',__('Load the selected theme'),array('type'=>'button',
'onclick'=>'if(document.getElementById(\'change_theme\').value!=\'\'){ document.location=\''.url_for('spyFormBuilderInterfaceTemplate/edit?id='.
$sf_request->getParameter('id').'&tpl=').'\'+document.getElementById(\'change_theme\').value }'));
?>