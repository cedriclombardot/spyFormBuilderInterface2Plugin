<?php 
if($spy_form_builder->getId()){
	?>
<table class="sf_admin_list" cellspacing="0">
<?php
include_partial('field_header');

foreach($fields as $k=>$row){
?>
<tr class="sf_admin_row_<?php echo $k%2; ?>">
	<td><?php echo $row->getId(); ?></td>
	<td><?php echo link_to($row->getName(),'spyFormBuilderInterfaceFields/edit?id='.$row->getId()); ?></td>
	<td><?php echo __($row->getWidgetType()); ?></td>
	<td>
	<?php
	foreach($row->getSpyFormBuilderValidatorss() as $l=>$valide){
		echo '- '.link_to($valide,'spyFormBuilderInterfaceValidate/edit?id='.$valide->getId()).'<br />';
	}
	?>

	
	</td>
	<td><?php if($k!=0) { echo link_to(image_tag('/spyFormBuilderInterface2Plugin/images/moveUp_icon.png'),'spyFormBuilderInterfaceFields/moveUp?id='.$row->getId()); }  ?>
	<?php if($k!=sizeof($fields)-1) { echo link_to(image_tag('/spyFormBuilderInterface2Plugin/images/moveDown_icon.png'),'spyFormBuilderInterfaceFields/moveDown?id='.$row->getId()); }  ?>
	<?php echo link_to(image_tag('/sf/sf_admin/images/delete_icon.png'),'spyFormBuilderInterfaceFields/delete?id='.$row->getId(),
	array('onclick'=>"if (confirm('Are you sure ?')) { return true };return false;")); ?>
	<?php 
	if($row->isValidable())
		echo link_to(image_tag('/sf/sf_admin/images/tick.png'),'spyFormBuilderInterfaceValidate/create?field_id='.$row->getId(),array('title'=>' Validations')); ?>
	<?php echo $row->getActions(); ?>
	</td>
	
</tr>
<?php
}
include_partial('field_footer');
?>
</table>


<ul class="sf_admin_actions">
  <li><?php echo button_to(__('Add a field'), 'spyFormBuilderInterfaceFields/create?form_id='.$spy_form_builder->getId(), array (
  'class' => 'sf_admin_action_create',
)) ?></li>
</ul>
<?php
}else{
	echo __('You must save the form before adding fields');
}
?>