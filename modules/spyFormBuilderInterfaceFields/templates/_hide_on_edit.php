<?php
/*
 * Liste of yours apps
 */
$apps=sfFinder::type('dir')->maxdepth(0)->relative()->in(sfConfig::get('sf_apps_dir'));
$opt=array();
foreach($apps as $app)
	$opt[$app]=__($app);
	
echo select_tag('spy_form_builder_fields[hide_on_edit]',options_for_select($opt,$spy_form_builder_fields->getHideOnEdit()),array('multiple'=>true,'size'=>5))
?>