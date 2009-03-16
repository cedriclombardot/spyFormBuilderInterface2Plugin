<?php 
if($spy_form_builder_validators->getFieldId()){
$value = input_hidden_tag('spy_form_builder_validators[field_id]' , $spy_form_builder_validators->getFieldId());
}else{
$value = input_hidden_tag('spy_form_builder_validators[field_id]' , $sf_request->getParameter('field_id'));

}

echo $value ? $value : '&nbsp;';

?>