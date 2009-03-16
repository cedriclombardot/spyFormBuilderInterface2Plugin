<?php
echo $out;
?>
<ul class="sf_admin_actions">
<li>
<?php
echo button_to('Retour au formulaire','spyFormBuilderInterface/edit?form_id='.$field->getFormId(), array('class'=>'sf_admin_action_list', 'value'=>'Retour au formulaire'));
?>
</li>
</ul>