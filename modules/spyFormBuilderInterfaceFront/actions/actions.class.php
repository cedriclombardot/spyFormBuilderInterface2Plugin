<?php

class spyFormBuilderInterfaceFrontActions extends sfActions{
	
	public function executeIndex(sfWebRequest $request){
		$this->forward404Unless($this->getRequestParameter('id'));
		$this->formulaire=new spyForm($this->getRequestParameter('id'));
	}
	
	
}

?>