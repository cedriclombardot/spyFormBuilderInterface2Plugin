<?php

/**
 * SpyFormBuilderFields form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseSpyFormBuilderFieldsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'widget_type'   => new sfWidgetFormInput(),
      'label'         => new sfWidgetFormInput(),
      'name'          => new sfWidgetFormInput(),
      'widget_params' => new sfWidgetFormTextarea(),
      'hide_on_edit'  => new sfWidgetFormInputCheckbox(),
      'only_for'      => new sfWidgetFormTextarea(),
      'form_id'       => new sfWidgetFormPropelChoice(array('model' => 'SpyFormBuilder', 'add_empty' => false)),
      'created_at'    => new sfWidgetFormDateTime(),
      'rank'          => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'SpyFormBuilderFields', 'column' => 'id', 'required' => false)),
      'widget_type'   => new sfValidatorString(array('max_length' => 255)),
      'label'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'widget_params' => new sfValidatorString(array('required' => false)),
      'hide_on_edit'  => new sfValidatorBoolean(array('required' => false)),
      'only_for'      => new sfValidatorString(array('required' => false)),
      'form_id'       => new sfValidatorPropelChoice(array('model' => 'SpyFormBuilder', 'column' => 'id')),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'rank'          => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('spy_form_builder_fields[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SpyFormBuilderFields';
  }


}
