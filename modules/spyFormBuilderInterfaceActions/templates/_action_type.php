<?php
use_helper('I18N');

$options=array(''=>__('- Choose an action -'));
foreach(sfConfig::get('sfa_actions_post') as $k=>$widget){
	$options[$k]=__($widget['name']);
}

echo select_tag('spy_form_builder_action[action_type]',options_for_select($options,$spy_form_builder_action->getActionType()),
array('onchange'=>'$ajaxreplace(\'sf_fieldset_param__res\', \'../../params/action_type/\'+this.value, false); $(\'sf_fieldset_param__res\').innerHTML=\'\';'));
?>