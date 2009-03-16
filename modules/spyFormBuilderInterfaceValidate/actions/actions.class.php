<?php

/**
 * spyFormBuilderInterfaceFields actions.
 *
 * @package    AELF
 * @subpackage spyFormBuilderInterfaceFields
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class spyFormBuilderInterfaceValidateActions extends autospyFormBuilderInterfaceValidateActions
{
public function preExecute(){
    require_once(sfContext::getInstance()->getConfigCache()->checkConfig('config/spy_form_validators.yml'));
  }
	/*
	 * Liste des params adapré au champs
	 */
	public function executeParams(){
		$this->validator_type=$this->getRequestParameter('validator_type');
		$this->form_params=new spyFormBuilderValidatorParams($this->validator_type);
		
	}
	
	public function executeEdit($request){
	$this->spy_form_builder_validators = $this->getSpyFormBuilderValidatorsOrCreate();

    if ($request->isMethod('post'))
    {
      $this->updateSpyFormBuilderValidatorsFromRequest();
	
      $this->saveSpyFormBuilderValidators($this->spy_form_builder_validators);
	 		
	 	  $params=$this->getRequestParameter('spy_form_builder_validators[params]');
	      $this->spy_form_builder_validators->setValidatorParams(serialize($params));
      try
      {
        $this->saveSpyFormBuilderValidators($this->spy_form_builder_validators);
      }
      catch (PropelException $e)
      {
        $request->setError('edit', 'Could not save the edited Spy form builder validatorss.');
        return $this->forward('spyFormBuilderInterfaceValidate', 'list');
      }

      $this->getUser()->setFlash('notice', 'Your modifications have been saved');

      if ($this->getRequestParameter('save_and_add'))
      {
        return $this->redirect('spyFormBuilderInterfaceValidate/create');
      }
      else if ($this->getRequestParameter('save_and_list'))
      {
        return $this->redirect('spyFormBuilderInterface/edit?id='.$this->spy_form_builder_validators->getSpyFormBuilderFields()->getFormId());
      }
      else
      {
        return $this->redirect('spyFormBuilderInterfaceValidate/edit?id='.$this->spy_form_builder_validators->getId());
      }
    }
    else
    {
      $this->labels = $this->getLabels();
    }
		$_POST['params']=$this->spy_form_builder_validators->getValidatorParams();
	}
  public function executeDelete($request)
  {
    $this->spy_form_builder_validators = SpyFormBuilderValidatorsPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->spy_form_builder_validators);
	$fid=$this->spy_form_builder_validators->getSpyFormBuilderFields()->getFormId();
    try
    {
      $this->deleteSpyFormBuilderValidators($this->spy_form_builder_validators);
    }
    catch (PropelException $e)
    {
      $request->setError('delete', 'Could not delete the selected Spy form builder validators. Make sure it does not have any associated items.');
      return $this->forward('spyFormBuilderInterfaceValidate', 'list');
    }

    return $this->redirect('spyFormBuilderInterface/edit?id='.$fid);
  }

	public function executeDoList(){
		$this->field=SpyFormBuilderFieldsPeer::retrieveByPK($this->getRequestParameter('field_id'));
		$this->redirect('spyFormBuilderInterface/edit?form_id='.$this->field->getFormId());
	}
}
