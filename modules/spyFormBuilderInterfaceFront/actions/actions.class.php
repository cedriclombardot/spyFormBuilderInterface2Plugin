<?php

class spyFormBuilderInterfaceFrontActions extends sfActions{
	
	public function executeIndex(sfWebRequest $request){
		$this->forward404Unless($this->getRequestParameter('id'));
		$datas=array();
		if($this->getRequestParameter('edit')) {
			$datas['id']=$this->getRequestParameter('edit');
			if(!$this->getRequestParameter('table')){
				throw new Exception('For Edit You must give the table name or directly gives the array of datas to spyForm()');
			}
			$class=sfInflector::camelize($this->getRequestParameter('table'));
			$object=call_user_func_array(array($class.'Peer','retrieveByPk'),$this->getRequestParameter('edit'));
			if(!$object instanceof $class){
				throw new Exception('Impossible to Edit Object ID '.$datas['id']);
			}
			$fields=call_user_func_array(array($class.'Peer','getFieldNames'),array(BasePeer::TYPE_FIELDNAME));
			foreach($fields as $field){
				$datas[$field]=call_user_func_array(array($object,'get'.sfInflector::camelize($field)),array());
			}
		}
		
		$this->formulaire=new spyForm($this->getRequestParameter('id'),$datas);
		
	}
	
	
}

?>