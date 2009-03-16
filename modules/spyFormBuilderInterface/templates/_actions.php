<?php 
if($spy_form_builder->getId()){
	?>
<table class="sf_admin_list" cellspacing="0">
<?php
include_partial('action_header');

foreach($actions as $k=>$row){
?>
<tr class="sf_admin_row_<?php echo $k%2; ?>">
	<td><?php echo $row->getId(); ?></td>
	<td><?php echo link_to(__($row->getActionType()),'spyFormBuilderInterfaceActions/edit?id='.$row->getId()); ?></td>
	
	<td><?php if($k!=0) { echo link_to(image_tag('/spyFormBuilderInterface2Plugin/images/moveUp_icon.png'),'spyFormBuilderInterfaceActions/moveUp?id='.$row->getId()); }  ?>
	<?php if($k!=sizeof($actions)-1) { echo link_to(image_tag('/spyFormBuilderInterface2Plugin/images/moveDown_icon.png'),'spyFormBuilderInterfaceActions/moveDown?id='.$row->getId()); }  ?>
	<?php echo link_to(image_tag('/sf/sf_admin/images/delete_icon.png'),'spyFormBuilderInterfaceActions/delete?id='.$row->getId(),
	array('onclick'=>"if (confirm('Are you sure ?')) { return true };return false;")); ?>
	
	<?php echo $row->getActions(); ?>
	</td>
	
</tr>
<?php
}
include_partial('action_footer');
?>
</table>


<ul class="sf_admin_actions">
  <li><?php echo button_to(__('Add an action'), 'spyFormBuilderInterfaceActions/create?form_id='.$spy_form_builder->getId(), array (
  'class' => 'sf_admin_action_create',
)) ?></li>
</ul>
<?php
}else{
	echo __('You must save the form before adding fields');
}
?>