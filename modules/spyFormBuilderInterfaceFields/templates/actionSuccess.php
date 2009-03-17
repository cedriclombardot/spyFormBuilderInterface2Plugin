<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date') ?>

<?php use_stylesheet('/sf/sf_admin/css/main') ?>
<div id="sf_admin_container">
<div id="sf_admin_content"><?php
echo call_user_func_array(array($class,$do),array());
?>
<ul class="sf_admin_actions">
	<li>
	<?php
	echo button_to(__('Return to the form'),'spyFormBuilderInterface/edit?id='.$action->getFormId(),array('class'=>'sf_admin_action_list'));
	?>
	</li>
</ul>
</div></div>