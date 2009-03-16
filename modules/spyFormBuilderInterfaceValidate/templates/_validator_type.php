<?php
use_helper('I18N');
echo '<pre>';

$options=array(''=>__('- Choose a validator type -'));
foreach(sfConfig::get('sfv_validators_rules') as $k=>$validator){
	$options[$k]=__($validator['name']);
}

echo select_tag('spy_form_builder_validators[validator_type]',options_for_select($options,$spy_form_builder_validators->getValidatorType()),
array('onchange'=>'$ajaxreplace(\'sf_fieldset_param__res\', \'../../params/validator_type/\'+this.value, false); $(\'sf_fieldset_param__res\').innerHTML=\'\';'));
?>