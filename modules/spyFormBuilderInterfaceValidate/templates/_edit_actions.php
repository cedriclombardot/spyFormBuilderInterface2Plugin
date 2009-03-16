<?php include_partial('params', array('spy_form_builder_validators' => $spy_form_builder_validators));

?>
<ul class="sf_admin_actions">
    <li><?php echo input_tag(__('Retour au formulaire'), __('Retour au formulaire'), array (
  'class' => 'sf_admin_action_list',
  'type'=>'button',
  'onClick'=>"document.location='".$_SERVER['SCRIPT_NAME']."/spyFormBuilderInterfaceValidate/doList/field_id/'+$('spy_form_builder_validators_field_id').value",
)) ?></li>
    <li><?php echo submit_tag(__('save'), array (
  'name' => 'save',
  'class' => 'sf_admin_action_save',
)) ?></li>
    <li><?php echo submit_tag(__('save and list'), array (
  'name' => 'save_and_list',
  'class' => 'sf_admin_action_save_and_list',
)) ?></li>
  </ul>