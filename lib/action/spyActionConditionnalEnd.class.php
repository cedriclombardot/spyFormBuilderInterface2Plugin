<?php

class spyActionConditionnalEnd extends spyFormActionBase{
	public function configure($options){
	}
	
	public function execute(){
		spyFormActionBase::removeCheck();
	}
}
?>