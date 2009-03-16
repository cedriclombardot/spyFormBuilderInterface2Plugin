<?php
/*
 * (c) Cédric Lombardot <cedric.lombardot@spyrit.net>
 * Cette classe crée un formulaire html pour afficher la liste des 
 * parametres pour le champ de parametre séléctionné
 * 
 */
abstract class spyFormBuilderParams{
	
	var $params=array();
	
	var $values=array();
	
	public function __construct($field_type, $values=array()){
		$this->field_type=$field_type;
		$fields=sfConfig::get($this->getConfigName());
		if(!array_key_exists($this->field_type,$fields))
			return false;
		$this->field=$fields[$this->field_type];
		
		$this->values=$values;
		
		$this->getParams();
		
	}
	
	/*
	 * Retourne le nom du groupe de champs
	 * 
	 * @return string
	 */
	abstract public function getGroupName();
	
	/*
	 * Retourne le nom de la config
	 * 
	 * @return string
	 */
	abstract public function getConfigName();
	
	/*
	 * Retrouve la liste des paramètres associés à un champs
	 * 
	 * @return array
	 */
	protected function getParams(){
		$this->params=$this->field['params'];
	}
	
	/*
	 * Crée un label HTML
	 * @param string name Nom du champ
	 * @param array fields Le champ
	 * @param string array Soit options ou attributes
	 * 
	 * @return string Code de la balise <label> 
	 */
	protected function renderLabel($name,$field, $array){
		$name=$this->getGroupName().'[params]['.$array.']['.$name.']';
		return '<label for="'.get_id_from_name($name).'">'.$field['name'].'</label>';
	}
	
	/*
	 * Créé un champ d'option
	 * @param string name Nom du champ
	 * @param array fields Le champ
	 * @param string array Soit options ou attributes 
	 * 
	 * @return string champ html
	 */
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
		$name=$this->getGroupName().'[params]['.$array.']['.$name.']';
		return  $label.'<div class="content">'.$widget->render($name,@$field['value']).'</div>';
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
				}else{
					if(array_key_exists('default',$option['options'])){
							$option['value']=$option['options']['default'];
					}
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
				}else{
					if(array_key_exists('default',$attr['options'])){
							$option['value']=$$attr['options']['default'];
					}
				}
				echo '<div class="form-row">';
				echo $this->renderField($name,$attr,'attributes');
				echo '</div>';
			}
		}
	}
}
?>