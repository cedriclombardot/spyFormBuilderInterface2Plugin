<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * SpyFormBuilderAction filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSpyFormBuilderActionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'action_type'   => new sfWidgetFormFilterInput(),
      'action_params' => new sfWidgetFormFilterInput(),
      'form_id'       => new sfWidgetFormPropelChoice(array('model' => 'SpyFormBuilder', 'add_empty' => true)),
      'rank'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'action_type'   => new sfValidatorPass(array('required' => false)),
      'action_params' => new sfValidatorPass(array('required' => false)),
      'form_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SpyFormBuilder', 'column' => 'id')),
      'rank'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('spy_form_builder_action_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SpyFormBuilderAction';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'action_type'   => 'Text',
      'action_params' => 'Text',
      'form_id'       => 'ForeignKey',
      'rank'          => 'Number',
    );
  }
}
