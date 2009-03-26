<?php

class spyActionStoreInPropel extends spyFormActionBase{
	
	public function configure($options){
		require_once(sfContext::getInstance()->getConfigCache()->checkConfig('config/spy_form_widgets.yml'));
		
		if($this->getOption('table_name')==''){
			$this->setOption('table_name',str_replace(' ','_',$this->getContext()->form_object->getName()));
		}
		$this->setOption('class',sfInflector::camelize($this->getOption('table_name')));
	}
	
	public function preExecute(){
		$c=$this->getOption('class');
		if($this->getContext()->isInEditMode()){
			$myObject=call_user_func_array(array($c.'Peer','retrieveByPk'),array('id'=>$this->getContext()->datas['id']));
				
			if($myObject instanceof $c){
				$fields=call_user_func_array(array($c.'Peer','getFieldNames'),array(BasePeer::TYPE_FIELDNAME));
				foreach($fields as $field){
						$datas[$field]=call_user_func_array(array($myObject,'get'.sfInflector::camelize($field)),array());

				}
				
				$this->getContext()->datas=$datas;
			}
			
			
		}
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
		$fields=sfConfig::get('sfw_widgets_fields');
		foreach($this->getDatas() as $field=>$value){
			if(method_exists($myObject,'set'.sfInflector::camelize($field))){
				$type=$this->getWidgetTypeFromFieldName($field);
				if(array_key_exists('storage',$fields[$type])){
					if(array_key_exists('formater',$fields[$type]['storage'])){
						$value=$this->format($fields[$type]['storage']['formater'],$value);
				
					}
				}
				
				
				call_user_func_array(array($myObject,'set'.sfInflector::camelize($field)),array($value));
			}else{
				throw new sfException('You have to rebuild the model the field "'.$field.'" doesn\'t exist in the table');
			}
			
		}
		$myObject->save();
		
		$this->getContext()->datas['id']=$myObject->getId();
	}
	
	protected function format($formatter,$value){
		if(is_array($value)){
			foreach($value as $k=>$v){
				
				if($v!='')
					$value['%'.$k.'%']=$v;
				unset($value[$k]);
			}
		}
		
		if(sizeof($value)==0)
			return null;
		return strtr($formatter,$value);
		
	}
	
	protected function getWidgetTypeFromFieldName($fieldname){
		return $this->getContext()->form_object->getWidgetTypeFromFieldName($fieldname);
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
				$row=$fields[$field->getWidgetType()]['storage'];
				if(array_key_exists('formater',$row))
					unset($row['formater']);
				return $row;
			}
		}
		return array('type'=>'longvarchar');
	}
}
?>