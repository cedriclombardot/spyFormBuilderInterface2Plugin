<form action="<?php echo url_for($form_submit_url) ?>" method="POST">
	<div class="spyform_builder">
	  <table>
	    <?php echo $form ?>
	    <tr>
	      <td colspan="2">
	        <input type="submit" />
	      </td>
	    </tr>
	  </table>
  </div>
</form>