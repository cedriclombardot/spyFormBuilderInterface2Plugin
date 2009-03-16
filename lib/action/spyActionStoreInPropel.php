<?php

class spyActionStoreInPropel extends spyFormActionBase{
	
	public function configure($options){
		if($this->getOption('table_name')==''){
			$this->setOption('table_name',str_replace(' ','_',$this->getContext()->form_object->getName()));
		}
		$this->setOption('class',sfInflector::camelize($this->getOption('table_name')));
	}
	
	public function execute(){
		$c=$this->getOption('class');
		if($this->getContext()->isInEditMode()){
			$myObject=call_user_func_array(array($c.'Peer','retrieveByPk'),array('id'=>$this->getContext()->datas['id']));
			if(!$myObject instanceof $c){
				$myObject=new $c;
			}
		}else{
			$myObject=new $c;
		}
		foreach($this->getDatas() as $field=>$value){
			call_user_func_array(array($myObject,'set'.sfInflector::camelize($field)),array($value));
		}
		$myObject->save();
	}
	
	public static function generateYml(){
		require_once(sfContext::getInstance()->getConfigCache()->checkConfig('config/spy_form_widgets.yml'));
		$yml=array();
		$sf_request=sfContext::getInstance()->getRequest();
		$action=SpyFormBuilderActionPeer::retrieveByPK($sf_request->getParameter('id'));
		
		$form=$action->getSpyFormBuilder();
		$fields=$form->getSpyFormBuilderFieldss();
		$db=$action->getParameter('dbname','propel');
		$tb=$action->getParameter('table_name',str_replace(' ','_',$form->getName()));
		$table=$tb;
		$yml[$db]=array($table=>array());
		$yml_table=&$yml[$db][$table];
		$yml_table['id']='~';
		foreach($fields as $field){
			$yml_table[$field->getName()]=self::getYmlForField($field);
		}
		
		$o='<h1>'.sfContext::getInstance()->getI18N()->__('Generate the YML').'</h1>';
		$o.=sfContext::getInstance()->getI18N()->__('copy this yml code into your schema and execute propel:build-all-diff').'<br/>';
		$o.= '<textarea cols="100" rows="20">';
		$o.= sfYaml::dump($yml,3);
		$o.= '</textarea>';
		return $o;
	}
	
	protected static function getYmlForField(SpyFormBuilderFields $field){
		
		$fields=sfConfig::get('sfw_widgets_fields');
		if(array_key_exists($field->getWidgetType(),$fields)){
			if(array_key_exists('storage',$fields[$field->getWidgetType()])){
				return $fields[$field->getWidgetType()]['storage'];
			}
		}
		return array('type'=>'longvarchar');
	}
}
?>