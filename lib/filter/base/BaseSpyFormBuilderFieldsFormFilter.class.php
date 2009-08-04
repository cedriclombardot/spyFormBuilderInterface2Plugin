<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * SpyFormBuilderFields filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSpyFormBuilderFieldsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'widget_type'   => new sfWidgetFormFilterInput(),
      'label'         => new sfWidgetFormFilterInput(),
      'name'          => new sfWidgetFormFilterInput(),
      'help'          => new sfWidgetFormFilterInput(),
      'widget_params' => new sfWidgetFormFilterInput(),
      'hide_on_edit'  => new sfWidgetFormFilterInput(),
      'only_for'      => new sfWidgetFormFilterInput(),
      'form_id'       => new sfWidgetFormPropelChoice(array('model' => 'SpyFormBuilder', 'add_empty' => true)),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'rank'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'widget_type'   => new sfValidatorPass(array('required' => false)),
      'label'         => new sfValidatorPass(array('required' => false)),
      'name'          => new sfValidatorPass(array('required' => false)),
      'help'          => new sfValidatorPass(array('required' => false)),
      'widget_params' => new sfValidatorPass(array('required' => false)),
      'hide_on_edit'  => new sfValidatorPass(array('required' => false)),
      'only_for'      => new sfValidatorPass(array('required' => false)),
      'form_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SpyFormBuilder', 'column' => 'id')),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'rank'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('spy_form_builder_fields_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SpyFormBuilderFields';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'widget_type'   => 'Text',
      'label'         => 'Text',
      'name'          => 'Text',
      'help'          => 'Text',
      'widget_params' => 'Text',
      'hide_on_edit'  => 'Text',
      'only_for'      => 'Text',
      'form_id'       => 'ForeignKey',
      'created_at'    => 'Date',
      'rank'          => 'Number',
    );
  }
}
