<?php
use_helper('I18N');

$options=array(''=>__('- Choose a field type -'));
foreach(sfConfig::get('sfw_widgets_fields') as $k=>$widget){
	$options[$k]=__($widget['name']);
}

echo select_tag('spy_form_builder_fields[widget_type]',options_for_select($options,$spy_form_builder_fields->getWidgetType()),
array('onchange'=>'$ajaxreplace(\'sf_fieldset_param__res\', \'../../params/field_type/\'+this.value, false); $(\'sf_fieldset_param__res\').innerHTML=\'\';'));
?>