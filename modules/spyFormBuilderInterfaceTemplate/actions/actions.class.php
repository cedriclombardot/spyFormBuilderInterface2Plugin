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
	
}
