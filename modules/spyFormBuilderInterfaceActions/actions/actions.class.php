<?php

/**

 * @subpackage spyFormBuilderInterfaceActionsActions
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class spyFormBuilderInterfaceActionsActions extends autospyFormBuilderInterfaceActionsActions
{
  public function preExecute(){
    require_once(sfContext::getInstance()->getConfigCache()->checkConfig('config/spy_form_actions.yml'));
  }
	/*
	 * Liste des params adapré au champs
	 */
	public function executeParams(){
		$this->action_type=$this->getRequestParameter('action_type');
		$this->form_params=new spyFormBuilderActionsParams($this->action_type,array());
		
	}
	public function executeDelete($request){
		$this->spy_form_builder_action = SpyFormBuilderActionPeer::retrieveByPk($this->getRequestParameter('id'));
	    $this->forward404Unless($this->spy_form_builder_action);
		$form_id=$this->spy_form_builder_action->getFormId();
	    try
	    {
	      $this->deleteSpyFormBuilderAction($this->spy_form_builder_action);
	    }
	    catch (PropelException $e)
	    {
	      $this->getRequest()->setError('delete', 'Could not delete the selected Spy form builder action. Make sure it does not have any associated items.');
	      return $this->redirect('spyFormBuilderInterface/edit?id='.$form_id);
	    }
	
	    return $this->redirect('spyFormBuilderInterface/edit?id='.$form_id);
	}
	public function executeEdit( $request){
	 $this->spy_form_builder_action = $this->getspyFormBuilderActionOrCreate();

	    if ($this->getRequest()->getMethod() == sfRequest::POST)
	    {
	      $this->updatespyFormBuilderActionFromRequest();
	
	      $this->savespyFormBuilderAction($this->spy_form_builder_action);
	 		
	 	  $params=$this->getRequestParameter('spy_form_builder_action[params]');
	      $this->spy_form_builder_action->setActionParams(serialize($params));
	      $this->spy_form_builder_action->save();
	      $this->getUser()->setFlash('notice', 'Your modifications have been saved');
	
	      if ($this->getRequestParameter('save_and_add'))
	      {
	        return $this->redirect('spyFormBuilderInterfaceActions/create');
	      }
	      else if ($this->getRequestParameter('save_and_list'))
	      {
	        return $this->redirect('spyFormBuilderInterface/edit?id='.$this->spy_form_builder_action->getFormId());
	      }
	      else
	      {
	        return $this->redirect('spyFormBuilderInterfaceActions/edit?id='.$this->spy_form_builder_action->getId());
	      }
	    }	
	    else
	    {
	      $this->labels = $this->getLabels();
	    }
		$_POST['params']=$this->spy_form_builder_action->getActionParams();
	}
	
	public function executeMoveDown(){
		$this->field=SpyFormBuilderActionPeer::retrieveByPK($this->getRequestParameter('id'));
		$this->field->moveDown();
		$this->redirect('spyFormBuilderInterface/edit?id='.$this->field->getFormId());
	}
	public function executeMoveUp(){
		$this->field=SpyFormBuilderActionPeer::retrieveByPK($this->getRequestParameter('id'));
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
		$this->action=SpyFormBuilderActionPeer::retrieveByPK($this->getRequestParameter('id'));
		$this->forward404Unless($this->action);
		$actions=sfConfig::get('sfa_actions_post');
		$this->class=$actions[$this->action->getActionType()]['type'];
		$this->do=$request->getParameter('do');
	}
}
