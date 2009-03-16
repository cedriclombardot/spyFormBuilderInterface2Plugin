<?php

class spyActionStoreInPropel extends spyFormActionBase{
	
	public function configure($options){
		
		print_r($options);
	}
	
	public function execute(){
		
		
	}
	
	public static function generateYml(){
		require_once(sfContext::getInstance()->getConfigCache()->checkConfig('config/spy_form_widgets.yml'));
		$yml=array();
		$sf_request=sfContext::getInstance()->getRequest();
		$action=SpyFormBuilderActionPeer::retrieveByPK($sf_request->getParameter('id'));
		
		$form=$action->getSpyFormBuilder();
		$fields=$form->getSpyFormBuilderFieldss();
		$db=$action->getParameter('dbname','propel');
		$tb=$action->getParameter('table_name',$form->getName());
		$table=str_replace(' ','_',$tb);
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