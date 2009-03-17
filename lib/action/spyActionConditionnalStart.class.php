<?php

class spyActionConditionnalStart extends spyFormActionBase {
	public function configure($options){
	}
	
	public function execute(){
		spyFormActionBase::addCheck($this->getOption('condition','true;'));
	}
	
	
}
?>