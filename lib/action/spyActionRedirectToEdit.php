<?php

class spyActionRedirectToEdit extends spyActionRedirect{
	public function configure($options){
		$url=sfContext::getInstance()->getModuleName().'/'.sfContext::getInstance()->getActionName();
		//SI le module contient le parametre id
		if(sfContext::getInstance()->getRequest()->getParameter('id')){
			$url.='?id='.sfContext::getInstance()->getRequest()->getParameter('id');
		}elseif(sfContext::getInstance()->getRequest()->getParameter('form_name')){
			$url.='?form_name='.sfContext::getInstance()->getRequest()->getParameter('form_name');
		}
		if(array_key_exists('id',$this->getContext()->datas))
			$url.='&edit='.$this->getContext()->datas['id'];
		$this->setOption('url',$url);
	}
}
?>