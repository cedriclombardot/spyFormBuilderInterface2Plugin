<?php

/**
 * spyFormBuilderInterface actions.
 *
 * @package    AELF
 * @subpackage spyFormBuilderInterface
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class spyFormBuilderInterfaceActions extends autospyFormBuilderInterfaceActions
{
	public function executeTemplate(){
		$this->forward('spyFormBuilderInterfaceTemplate','edit');
	}
	
	public function executeField_show(){
		$this->field=spyFormBuilderFieldsPeer::retrieveByPK($this->getRequestParameter('field_id'));
		$this->forward404Unless($this->field);
		$class='spyFormBuilderFrontInput_'.$this->field->getFieldTypeObject();
		
		$this->out=call_user_func_array($class.'::executeFieldShow',array('field'=>$this->field));
	}
}
