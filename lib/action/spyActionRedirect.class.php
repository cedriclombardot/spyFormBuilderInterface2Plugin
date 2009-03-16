<?php

class spyActionRedirect extends spyFormActionBase{
	public function configure($options){
	}
	
	public function execute(){
		sfContext::getInstance()->getController()->redirect($this->getOption('url'),0,302);
		throw new sfStopException();
	}
}
?>