<?php

/**
 * SpyFormBuilderValidators form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSpyFormBuilderValidatorsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'validator_type'   => new sfWidgetFormInput(),
      'field_id'         => new sfWidgetFormPropelChoice(array('model' => 'SpyFormBuilderFields', 'add_empty' => false)),
      'validator_params' => new sfWidgetFormTextarea(),
      'invalid_msg'      => new sfWidgetFormTextarea(),
      'rank'             => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'SpyFormBuilderValidators', 'column' => 'id', 'required' => false)),
      'validator_type'   => new sfValidatorString(array('max_length' => 255)),
      'field_id'         => new sfValidatorPropelChoice(array('model' => 'SpyFormBuilderFields', 'column' => 'id')),
      'validator_params' => new sfValidatorString(array('required' => false)),
      'invalid_msg'      => new sfValidatorString(array('required' => false)),
      'rank'             => new sfValidatorInteger(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'SpyFormBuilderValidators', 'column' => array('rank', 'field_id')))
    );

    $this->widgetSchema->setNameFormat('spy_form_builder_validators[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SpyFormBuilderValidators';
  }


}
