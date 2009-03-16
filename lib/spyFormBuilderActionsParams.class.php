<?php
/*
 * (c) Cédric Lombardot <cedric.lombardot@spyrit.net>
 * Cette classe crée un formulaire html pour afficher la liste des 
 * parametres pour le champ séléctionné
 * 
 */
class spyFormBuilderActionsParams {
	
	/* Le type du champ */
	var $validator_type;
	
	var $params=array();
	
	var $values=array();
	
	/* 
	 * 
	 */
	public function __construct($field_type, $values=array()){
		$this->action_type=$field_type;
		$vallidators=sfConfig::get('sfa_actions_post');
		if(!array_key_exists($this->action_type,$vallidators))
			return false;
		$this->validator=$vallidators[$this->action_type];
		
		$this->values=$values;
		
		$this->getParams();
		
	}
	
	/*
	 * Retrouve la liste des paramètres associés à un champs
	 */
	protected function getParams(){
		$this->params=$this->validator['params'];
	}
	
	/*
	 * Retourne le formulaire de paramètres qui correspond
	 */
	public function renderHtml(){
		if(sizeof($this->params)==0)
			return '';
		//print_r($this->params);
		
			
		if(array_key_exists('options',$this->params)){
			foreach($this->params['options'] as $name=>$option){
				if(isset($this->values['options'][$name])){
					$option['value']=$this->values['options'][$name];
				}
				echo '<div class="form-row">';
				echo $this->renderField($name,$option,'options');
				echo '</div>';
			}
		}
		if(array_key_exists('attributes',$this->params)){
			foreach($this->params['attributes'] as $name=>$attr){
				if(isset($this->values['attributes'][$name])){
					$attr['value']=$this->values['attributes'][$name];
				}
				echo '<div class="form-row">';
				echo $this->renderField($name,$attr,'attributes');
				echo '</div>';
			}
		}
	
	}
	
	protected function renderLabel($name,$field, $array){
		$name='spy_form_builder_action[params]['.$array.']['.$name.']';
		return '<label for="'.get_id_from_name($name).'">'.$field['name'].'</label>';
	}
	protected function renderField($name,$field, $array){
		//print_r($field);
		$label=$this->renderLabel($name,$field, $array);
		if(!is_array(@$field['option'])){
			$field['option']=array();
		}
		if(!is_array(@$field['attributes'])){
			$field['attributes']=array();
		}
		$widget=new $field['type'](@$field['option'],@$field['attributes']);
		$name='spy_form_builder_action[params]['.$array.']['.$name.']';
		return  $label.'<div class="content">'.$widget->render($name,@$field['value']).'</div>';
		
	}
}
?>