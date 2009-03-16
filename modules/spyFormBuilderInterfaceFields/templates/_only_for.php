<?php
/*
 * Liste of yours apps
 */
$apps=sfFinder::type('dir')->maxdepth(0)->relative()->in(sfConfig::get('sf_apps_dir'));
$opt=array();
foreach($apps as $app)
	$opt[$app]=__($app);
	
echo select_tag('spy_form_builder_fields[only_for]',options_for_select($opt,$spy_form_builder_fields->getOnlyFor()),array('multiple'=>true,'size'=>5))
?>