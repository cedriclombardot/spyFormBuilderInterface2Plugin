<?php

class spyActionStoreInPropel extends spyFormActionBase{
	
	public function configure($options){
		
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
		$table=$action->getParameter('table_name',str_replace(' ','_',$form->getName()));
		$yml[$db]=array($table=>array());
		$yml_table=&$yml[$db][$table];
		$yml_table['id']='~';
		foreach($fields as $field){
			$yml_table[$field->getName()]=self::getYmlForField($field);
		}
		
		$o='<h1>'.sfContext::getInstance()->getI18N()->__('Generate the YML').'</h1>';
		$o.='Recopiez le code ci dessous dans le schema.yml et executer propel:build-all-diff <br/>';
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