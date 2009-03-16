<?php include_partial('_params', array('spy_form_builder_action' => $spy_form_builder_action));

?>
<ul class="sf_admin_actions">
    <li><?php echo input_tag(__('Return to the form'), __('Return to the form'), array (
  'class' => 'sf_admin_action_list',
  'type'=>'button',
  'onClick'=>"document.location='".$_SERVER['SCRIPT_NAME']."/spyFormBuilderInterfaceActions/doList/form_id/'+$('spy_form_builder_action_form_id').value",
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