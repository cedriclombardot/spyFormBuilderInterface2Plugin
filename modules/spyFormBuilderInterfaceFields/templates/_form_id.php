<?php 
if($spy_form_builder_fields->getFormId()){
$value = input_hidden_tag('spy_form_builder_fields[form_id]' , $spy_form_builder_fields->getFormId());
}else{
$value = input_hidden_tag('spy_form_builder_fields[form_id]' , $sf_request->getParameter('form_id'));

}

echo $value ? $value : '&nbsp;';

?>