<?php

class spyFormBuilderInterfaceFrontActions extends sfActions{
	
	public function executeIndex(sfWebRequest $request){
		$this->forward404Unless($this->getRequestParameter('id'));
		$datas=array();
		if($this->getRequestParameter('edit')) {
			$datas['id']=$this->getRequestParameter('edit');
		}
		
		$this->formulaire=new spyForm($this->getRequestParameter('id'),$datas);
		
	}
	
	
}

?>