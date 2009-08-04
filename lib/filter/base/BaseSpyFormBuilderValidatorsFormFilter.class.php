<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * SpyFormBuilderValidators filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSpyFormBuilderValidatorsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'validator_type'   => new sfWidgetFormFilterInput(),
      'field_id'         => new sfWidgetFormPropelChoice(array('model' => 'SpyFormBuilderFields', 'add_empty' => true)),
      'validator_params' => new sfWidgetFormFilterInput(),
      'invalid_msg'      => new sfWidgetFormFilterInput(),
      'rank'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'validator_type'   => new sfValidatorPass(array('required' => false)),
      'field_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SpyFormBuilderFields', 'column' => 'id')),
      'validator_params' => new sfValidatorPass(array('required' => false)),
      'invalid_msg'      => new sfValidatorPass(array('required' => false)),
      'rank'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('spy_form_builder_validators_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SpyFormBuilderValidators';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'validator_type'   => 'Text',
      'field_id'         => 'ForeignKey',
      'validator_params' => 'Text',
      'invalid_msg'      => 'Text',
      'rank'             => 'Number',
    );
  }
}
