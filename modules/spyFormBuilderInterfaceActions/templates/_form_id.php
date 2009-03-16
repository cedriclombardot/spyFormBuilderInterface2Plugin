<?php 
if($spy_form_builder_action->getFormId()){
$value = input_hidden_tag('spy_form_builder_action[form_id]' , $spy_form_builder_action->getFormId());
}else{
$value = input_hidden_tag('spy_form_builder_action[form_id]' , $sf_request->getParameter('form_id'));

}

echo $value ? $value : '&nbsp;';

?>