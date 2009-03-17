<?php

/**
 * spyFormBuilderInterface actions.
 *
 * @package    AELF
 * @subpackage spyFormBuilderInterface
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class spyFormBuilderInterfaceTemplateActions extends autospyFormBuilderInterfaceTemplateActions
{
	public function executeFormulaire(){
		$this->forward('spyFormBuilderInterface','edit');
	}
	
	public function executeEdit($request)
 	{
    $this->spy_form_builder = $this->getSpyFormBuilderOrCreate();

    if($this->getRequestParameter('tpl')){
    	
    	$this->spy_form_builder->setTemplate($this->spy_form_builder->getTemplateFile($this->getRequestParameter('tpl')));
    }
   
    if ($request->isMethod('post'))
    {
      $this->updateSpyFormBuilderFromRequest();

      try
      {
        $this->saveSpyFormBuilder($this->spy_form_builder);
      }
      catch (PropelException $e)
      {
        $request->setError('edit', 'Could not save the edited Spy form builders.');
        return $this->forward('spyFormBuilderInterfaceTemplate', 'list');
      }

      $this->getUser()->setFlash('notice', 'Your modifications have been saved');

      if ($this->getRequestParameter('save_and_add'))
      {
        return $this->redirect('spyFormBuilderInterfaceTemplate/create');
      }
      else if ($this->getRequestParameter('save_and_list'))
      {
        return $this->redirect('spyFormBuilderInterfaceTemplate/list');
      }
      else
      {
        return $this->redirect('spyFormBuilderInterfaceTemplate/edit?id='.$this->spy_form_builder->getId());
      }
    }
    else
    {
      $this->labels = $this->getLabels();
    }
  }
	
}
