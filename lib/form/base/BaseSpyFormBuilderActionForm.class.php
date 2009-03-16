<?php

/**
 * SpyFormBuilderAction form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseSpyFormBuilderActionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'action_type'   => new sfWidgetFormInput(),
      'action_params' => new sfWidgetFormTextarea(),
      'rank'          => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'SpyFormBuilderAction', 'column' => 'id', 'required' => false)),
      'action_type'   => new sfValidatorString(array('max_length' => 255)),
      'action_params' => new sfValidatorString(array('required' => false)),
      'rank'          => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('spy_form_builder_action[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SpyFormBuilderAction';
  }


}
