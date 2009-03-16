<?php

/*
 * Cette class génère une class sfForm
 */
class spyForm {
	
	
	public function __construct($form_id){
		
		require_once(sfContext::getInstance()->getConfigCache()->checkConfig('config/spy_form_widgets.yml'));
		
		require_once(sfContext::getInstance()->getConfigCache()->checkConfig('config/spy_form_validators.yml'));
		
		require_once(sfContext::getInstance()->getConfigCache()->checkConfig('config/spy_form_actions.yml'));
		
		$this->all_fields=sfConfig::get('sfw_widgets_fields');
		$this->all_validators=sfConfig::get('sfv_validators_rules');
		$this->all_actions=sfConfig::get('sfa_actions_post');
		
		//recupere le form
		$this->retrieveForm($form_id);
		
		//Construit la class basé sur le sfForm
		$this->formulaire=new spyFormBuilderForm();
		
		//Liste des champs
		$c=new Criteria();
		$c->addAscendingOrderByColumn(SpyFormBuilderFieldsPeer::RANK);
		$this->fields=$this->form_object->getSpyFormBuilderFieldss($c);

		
		$widgets=array();
		$labels=array();
		$helps=array();
		$valids=array();
		
		$app=sfContext::getInstance()->getConfiguration()->getApplication();
		foreach($this->fields as $field){
			if((!$field->getOnlyFor())||(in_array($app,$field->getOnlyFor()))){
				
			
			$wclass=$this->all_fields[$field->getWidgetType()]['type'];
			$params=$field->getWidgetParams();
			$options=(array_key_exists('options',$params))?$params['options']:array();
			$attributes=(array_key_exists('attributes',$params))?$params['attributes']:array();
			
			$widgets[$field->getName()]= new $wclass($options,$attributes);
			
			$labels[$field->getName()]=$field->getLabel();
			
			if($field->getHelp()!=''){
				$helps[$field->getName()]=$field->getHelp();
			}
			
			//Liste des validations pour ce champ
			$validators=$field->getSpyFormBuilderValidatorss();
			if(sizeof($validators)>1){
				$valid=array();
				foreach($validators as $validator){
					$validator_class=$this->all_validators[$validator->getValidatorType()]['type'];
					$params=$validator->getValidatorParams();
					
					$options=(array_key_exists('options',$params))?$params['options']:array();
					$options['trim']=(array_key_exists('trim',$options))?$options['trim']:true;
					$options['required']=(array_key_exists('required',$options))?$options['required']:false;
					$valid[]=new $validator_class($options,array('invalid'=>$validator->getInvalidMsg()));
				}
				$valids[$field->getName()]=new sfValidatorAnd($valid);
			}elseif(sizeof($validators)==1){
				$validator_class=$this->all_validators[$validators[0]->getValidatorType()]['type'];
				$params=$validators[0]->getValidatorParams();
				if(!is_array($params))
					$params=array();
				$options=(array_key_exists('options',$params))?$params['options']:array();
				$options['trim']=(array_key_exists('trim',$options))?$options['trim']:true;
				$options['required']=(array_key_exists('required',$options))?$options['required']:false;
				$attributes=(array_key_exists('attributes',$params))?$params['attributes']:array();
				
				$valids[$field->getName()]=new $validator_class($options,array('invalid'=>$validators[0]->getInvalidMsg()));
			}else{
				$valids[$field->getName()]=new sfValidatorNone();
			}
			
			}//end only_for
		}
		
		//Insert les champs
		$this->formulaire->setWidgets($widgets);
		
		//Insert les labels
		$this->formulaire->getWidgetSchema()->setLabels($labels);
		
		//Messages d'aide
		if(sizeof($helps)>0)
			$this->formulaire->getWidgetSchema()->setHelps($helps);
		
		//Validators
		$this->formulaire->setValidators($valids);
			
		$this->formulaire->getWidgetSchema()->setNameFormat('spy_form_builder[%s]');
		
		/*
		 * Bind
		 */
		if(sfContext::getInstance()->getRequest()->isMethod('post')){
			$this->formulaire->bind(sfContext::getInstance()->getRequest()->getParameter('spy_form_builder'));
			
			if ($this->formulaire->isValid())
			{
				$this->doPostActions();	
			}
		}
	}
	
	protected function doPostActions(){
		$this->actions=$this->form_object->getSpyFormBuilderActions();
		foreach($this->actions as $action){
			//Construit l'action
			$action_class=$this->all_actions[$action->getActionType()]['type'];
			$params=$action->getActionParams();
			$options=(array_key_exists('options',$params))?$params['options']:array();
			
			
			$myAction=new $action_class($options, $this->formulaire->getValues());
			$myAction->execute();
		}
	}
	public function render(){
		$form=$this->formulaire;
		$form_submit_url=sfContext::getInstance()->getModuleName().'/'.sfContext::getInstance()->getActionName();
		//SI le module contient le parametre id
		if(sfContext::getInstance()->getRequest()->getParameter('id')){
			$form_submit_url.='?id='.sfContext::getInstance()->getRequest()->getParameter('id');
		}elseif(sfContext::getInstance()->getRequest()->getParameter('form_name')){
			$form_submit_url.='?form_name='.sfContext::getInstance()->getRequest()->getParameter('form_name');
		}
		eval('?>'.$this->form_object->getTemplate());
	}
	protected function retrieveForm($form_id){
		if(is_numeric($form_id)){
			try{
				$this->form_object=SpyFormBuilderPeer::retrieveByPK($form_id);
				if(!$this->form_object instanceof SpyFormBuilder){
					throw new Exception('Impossible to find Form number '.$form_id);
				}
			}catch(Exception $e){
				throw  $e;
			}
		}else{
			try{
				$this->form_object=SpyFormBuilderPeer::retrieveByName($form_id);
				if(!$this->form_object instanceof SpyFormBuilder){
					throw new Exception('Impossible to find Form by name '.$form_id);
				}
			}catch(Exception $e){
				throw  $e;
			}
		}
	}

}

class spyFormBuilderForm extends sfForm{
	
}
?>