<?php

class spyActionRedirectToEdit extends spyActionRedirect{
	public function configure($options){
		$url=sfContext::getInstance()->getModuleName().'/'.sfContext::getInstance()->getActionName();
		$request=sfContext::getInstance()->getRequest();
		//SI le module contient le parametre id
		if($request->getParameter('id')){
			$url.='?id='.$request->getParameter('id');
		}elseif($request->getParameter('form_name')){
			$url.='?form_name='.$request->getParameter('form_name');
		}
		if(array_key_exists('id',$this->getContext()->datas))
			$url.='&edit='.$this->getContext()->datas['id'];
		$this->setOption('url',$url);
	}
}
?>