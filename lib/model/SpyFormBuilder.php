<?php

class SpyFormBuilder extends BaseSpyFormBuilder
{
	public function getTemplate(){
		if(!parent::getTemplate()){
			return $this->getDefaultTemplate();
		}
	}
	
	public function getDefaultTemplate(){
		$f=realpath(dirname(__FILE__).'/../').'/tpl/default.tpl';
		$fp=fopen($f,'r');
		$tpl=fread($fp,filesize($f));
		fclose($fp);
		return $tpl;
	}
	
}
