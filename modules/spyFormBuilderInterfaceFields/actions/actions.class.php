<?php

/**
 * spyFormBuilderInterfaceFields actions.
 *
 * @package    AELF
 * @subpackage spyFormBuilderInterfaceFields
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class spyFormBuilderInterfaceFieldsActions extends autospyFormBuilderInterfaceFieldsActions
{
  public function preExecute(){
    require_once(sfContext::getInstance()->getConfigCache()->checkConfig('config/spy_form_widgets.yml'));
  }
	/*
	 * Liste des params adapré au champs
	 */
	public function executeParams(){
		$this->field_type=$this->getRequestParameter('field_type');
		$this->form_params=new spyFormBuilderFieldsParams($this->field_type);
		
	}
	public function executeDelete($request){
		$this->spy_form_builder_fields = SpyFormBuilderFieldsPeer::retrieveByPk($this->getRequestParameter('id'));
	    $this->forward404Unless($this->spy_form_builder_fields);
		$form_id=$this->spy_form_builder_fields->getFormId();
	    try
	    {
	      $this->deleteSpyFormBuilderFields($this->spy_form_builder_fields);
	    }
	    catch (PropelException $e)
	    {
	      $this->getRequest()->setError('delete', 'Could not delete the selected Spy form builder fields. Make sure it does not have any associated items.');
	      return $this->redirect('spyFormBuilderInterface/edit?id='.$form_id);
	    }
	
	    return $this->redirect('spyFormBuilderInterface/edit?id='.$form_id);
	}
	public function executeEdit( $request){
	 $this->spy_form_builder_fields = $this->getspyFormBuilderFieldsOrCreate();

	    if ($this->getRequest()->getMethod() == sfRequest::POST)
	    {
	      $this->updatespyFormBuilderFieldsFromRequest();
	
	      $this->savespyFormBuilderFields($this->spy_form_builder_fields);
	 		
	 	  $params=$this->getRequestParameter('spy_form_builder_fields[params]');
	      $this->spy_form_builder_fields->setWidgetParams(serialize($params));
	      $this->spy_form_builder_fields->save();
	      $this->getUser()->setFlash('notice', 'Your modifications have been saved');
	
	      if ($this->getRequestParameter('save_and_add'))
	      {
	        return $this->redirect('spyFormBuilderInterfaceFields/create');
	      }
	      else if ($this->getRequestParameter('save_and_list'))
	      {
	        return $this->redirect('spyFormBuilderInterface/edit?id='.$this->spy_form_builder_fields->getFormId());
	      }
	      else
	      {
	        return $this->redirect('spyFormBuilderInterfaceFields/edit?id='.$this->spy_form_builder_fields->getId());
	      }
	    }	
	    else
	    {
	      $this->labels = $this->getLabels();
	    }
		$_POST['params']=$this->spy_form_builder_fields->getWidgetParams();
	}
	
	public function executeMoveDown(){
		$this->field=SpyFormBuilderFieldsPeer::retrieveByPK($this->getRequestParameter('id'));
		$this->field->moveDown();
		$this->redirect('spyFormBuilderInterface/edit?id='.$this->field->getFormId());
	}
	public function executeMoveUp(){
		$this->field=SpyFormBuilderFieldsPeer::retrieveByPK($this->getRequestParameter('id'));
		$this->field->moveUp();
		$this->redirect('spyFormBuilderInterface/edit?id='.$this->field->getFormId());
	}

	public function executeDoList(){
		$this->redirect('spyFormBuilderInterface/edit?id='.$this->getRequestParameter('form_id'));
	}
	
	/*
	 * Execute an advanced action for one form Action
	 */
	public function executeAction($request){
		$this->forward404Unless($request->getParameter('do'));
		$this->forward404Unless($request->getParameter('id'));
		$this->action=SpyFormBuilderFieldsPeer::retrieveByPK($this->getRequestParameter('id'));
		$this->forward404Unless($this->action);
		$actions=sfConfig::get('sfw_widgets_fields');
		$this->class=$actions[$this->action->geWidgetType()]['type'];
		$this->do=$request->getParameter('do');
	}
}
