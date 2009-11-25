<form action="<?php echo url_for($form_submit_url) ?>" method="POST">
	<div class="spyform_builder">
		<?php echo $form->renderGlobalErrors() ?>

		<?php foreach($form as $field): ?>
			<?php if($field->renderLabelName()!=' '): ?>
			<div class="form-row <?php if($field->hasError()) { echo 'field_error'; } ?>">
				
					<?php echo $field->renderLabel(); ?>
				
				<div class="content">
					<?php echo $field->renderError(); ?>
					<?php echo $field->render(); ?>
				</div>
			</div>
			<?php else: ?>
				<?php echo $field->render(); ?>
			<?php endif; ?>
		<?php endforeach; ?>
	 <div class="form-row">
	        <input type="submit" />
	    </div>
  </div>
</form>