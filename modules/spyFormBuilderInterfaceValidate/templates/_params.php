<fieldset id="sf_fieldset_param__res">
<h2><?php use_helper('I18N'); echo __('Paramètres'); ?></h2><?php
$form_params=new spyFormBuilderValidatorParams($spy_form_builder_validators->getValidatorType(), $spy_form_builder_validators->getValidatorParams());
$form_params->renderHtml(); 
?></fieldset>