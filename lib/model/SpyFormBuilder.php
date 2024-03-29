<?php

class SpyFormBuilder extends BaseSpyFormBuilder
{
	public function getTemplate(){
		if(!parent::getTemplate()){
			return $this->getDefaultTemplate();
		}
		
		return parent::getTemplate();
	}
	
	public function getDefaultTemplate(){
		return $this->getTemplateFile();
	}
	
	public function getTemplateFile($file='default.tpl'){
		$f=realpath(dirname(__FILE__).'/../').'/tpl/form/'.$file;
		$fp=fopen($f,'r');
		$tpl=fread($fp,filesize($f));
		fclose($fp);
		return $tpl;
	}
	
	public function getWidgetTypeFromFieldName($name){
		$field=$this->getFieldFromFieldName($name);
		if(!$field instanceof SpyFormBuilderFields)
			return false;
		return $field->getWidgetType();
	}
	
	public function getFieldFromFieldName($name){
		$c=new Criteria();
		$c->add(SpyFormBuilderFieldsPeer::FORM_ID,$this->getId());
		$c->add(SpyFormBuilderFieldsPeer::NAME,$name);
		return SpyFormBuilderFieldsPeer::doSelectOne($c);
	}
	
}
