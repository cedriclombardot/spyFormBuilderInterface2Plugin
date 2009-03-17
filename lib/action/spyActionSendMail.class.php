<?php

class spyActionSendMail extends spyFormActionBase{
	
	var $tpl;
	
	public function configure($options){
		$this->tpl=realpath(dirname(__FILE__).'../../').'/tpl/mail/default.tpl';
	}
	
	public function execute(){
		
		$message=$this->parseMessage();
		
		$send=mail($this->getOption('to'),$this->getOption('subject','no subject'),$message);
		if(!$send){
			throw new Exception('Impossible to send email');
		}
		
	}
	
	protected function parseMessage(){
		$fp=fopen($this->tpl,'r');
		$tpl=fread($fp,filesize($this->tpl));
		$datas=$this->getDatas();
		ob_start();
		eval('?>'.$tpl);
		$var= ob_get_contents();
		ob_end_clean();
		return $var;
	}
}
?>