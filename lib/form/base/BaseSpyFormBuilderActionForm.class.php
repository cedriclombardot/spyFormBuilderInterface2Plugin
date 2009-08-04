<?php

/**
 * SpyFormBuilderAction form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSpyFormBuilderActionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'action_type'   => new sfWidgetFormInput(),
      'action_params' => new sfWidgetFormTextarea(),
      'form_id'       => new sfWidgetFormPropelChoice(array('model' => 'SpyFormBuilder', 'add_empty' => false)),
      'rank'          => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'SpyFormBuilderAction', 'column' => 'id', 'required' => false)),
      'action_type'   => new sfValidatorString(array('max_length' => 255)),
      'action_params' => new sfValidatorString(array('required' => false)),
      'form_id'       => new sfValidatorPropelChoice(array('model' => 'SpyFormBuilder', 'column' => 'id')),
      'rank'          => new sfValidatorInteger(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'SpyFormBuilderAction', 'column' => array('rank', 'form_id')))
    );

    $this->widgetSchema->setNameFormat('spy_form_builder_action[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SpyFormBuilderAction';
  }


}
