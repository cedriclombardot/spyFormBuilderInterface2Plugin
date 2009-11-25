<?php

/*
 * Cette class génère une class sfForm
 */
class spyForm {
	
	/** Liste of widgets class **/
	protected   $widgets=array();
	
	/** Liste of labels **/
	protected 	$labels=array();
	
	/** Liste of helps **/
	protected 	$helps=array();
	
	/** Liste of validators **/
	protected 	$valids=array();
	
	/**
	 * Constructeur
	 * 
	 * @param integer $form_id Number of the form to retrieve fields ...
	 * @param array $datas Array of datas for propel store $datas['id']=ID of the data
	 */
	public function __construct($form_id,$datas=array()){
		$this->datas=$datas;
		$this->form_id=$form_id;
		$this->getConfig();
		$this->form_object=$this->retrieveForm();
		$this->init();
	}
	
	/**
	 * getConfig()
	 * Include the config files for fields validators and actions
	 */
	protected function getConfig(){
		require_once(sfContext::getInstance()->getConfigCache()->checkConfig('config/spy_form_widgets.yml'));
		require_once(sfContext::getInstance()->getConfigCache()->checkConfig('config/spy_form_validators.yml'));
		require_once(sfContext::getInstance()->getConfigCache()->checkConfig('config/spy_form_actions.yml'));
		
		$this->all_fields=sfConfig::get('sfw_widgets_fields');
		$this->all_validators=sfConfig::get('sfv_validators_rules');
		$this->all_actions=sfConfig::get('sfa_actions_post');
	}	

	/**
	 * Retrive the form Object from propel database
	 * 
	 * @param integer|string The id or the name of the form
	 * 
	 * @return SpyFormBuilder Object for form
	 */
	protected function retrieveForm($form_id=null){
		if(is_null($form_id))
			$form_id=$this->form_id;
		if(is_numeric($form_id)){
			try{
				$form_object=SpyFormBuilderPeer::retrieveByPK($form_id);
				if(!$form_object instanceof SpyFormBuilder){
					throw new Exception('Impossible to find Form number '.$form_id);
				}
			}catch(Exception $e){
				throw  $e;
			}
		}else{
			try{
				$form_object=SpyFormBuilderPeer::retrieveByName($form_id);
				if(!$form_object instanceof SpyFormBuilder){
					throw new Exception('Impossible to find Form by name '.$form_id);
				}
			}catch(Exception $e){
				throw  $e;
			}
		}
		return $form_object;
	}
		
	/**
	 * Builde the form
	 */
	protected function init(){
		//Construit la class basé sur le sfForm
		$this->formulaire=new spyFormBuilderForm();
		
		//Liste des champs
		$c=new Criteria();
		$c->addAscendingOrderByColumn(SpyFormBuilderFieldsPeer::RANK);
		
		//TO retrieve Datas
		$this->doPreActions();
		
		$this->fields=$this->form_object->getSpyFormBuilderFieldss($c);
		
		foreach($this->fields as $field){
			if($this->haveToShowField($field)){
				$this->prepareField($field);
			}
		}
		//Insert les champs
		$this->formulaire->setWidgets($this->widgets);
		
		//Insert les labels
		$this->formulaire->getWidgetSchema()->setLabels($this->labels);
		//Messages d'aide
		if(sizeof($this->helps)>0)
			$this->formulaire->getWidgetSchema()->setHelps($this->helps);
			
			

		//Validators
		$this->formulaire->setValidators($this->valids);
		
		//Edit Mode
		//print_r($this->datas);
		if($this->isInEditMode())
			$this->formulaire->setDefaults($this->datas);
			
		$this->formulaire->getWidgetSchema()->setNameFormat($this->form_object->getName().'[%s]');
		
		/**
		 * Bind
		 */
		if(sfContext::getInstance()->getRequest()->isMethod('post')){
			$this->formulaire->bind(sfContext::getInstance()->getRequest()->getParameter($this->form_object->getName()));
			if ($this->formulaire->isValid())
			{
				$this->doPostActions();	
			}
		}
	}
		
	
	/**
	 * Check the only for Criteria
	 * @param SpyFormBuilderFields the field object
	 * 
	 * @return boolean is the field allowed in this context
	 */
	protected function checkOnlyFor(SpyFormBuilderFields $field){
		return ((!$field->getOnlyFor())||(in_array($this->getCurrentApp(),$field->getOnlyFor())));
	}
	
	/**
	 * Check the hide on Edit Criteria
	 * @param SpyFormBuilderFields the field object
	 * 
	 * @return boolean is the field allowed in this context
	 */
	protected function checkHideOnEdit(SpyFormBuilderFields $field){
		return ((!$field->getHideOnEdit())||(!$this->isInEditMode())||(!in_array($this->getCurrentApp(),$field->getHideOnEdit())));
	}
	
	/**
	 * Check if we are in an editing mode
	 *  
	 * @return boolean sizeof($this->datas)>0
	 */
	public function isInEditMode(){
		return (sizeof($this->datas)>0);
	}
	
	/**
	 *  Check if we need to render the field in this context
	 *  @param SpyFormBuilderFields the field object
	 *
	 *  @return boolean is the field allowed in this context
	 */
	protected function haveToShowField(SpyFormBuilderFields $field){
		return ($this->checkOnlyFor($field) && $this->checkHideOnEdit($field));
	}
	/**
	 * Return the name of the current sf application
	 * 
	 * @return string name of the app
	 */
	public function getCurrentApp(){
		return sfContext::getInstance()->getConfiguration()->getApplication();
	}	
	
	/**
	 * Prepare to render the field
	 * 
	 * @param SpyFormBuilderFields the field object
	 */
	protected function prepareField(SpyFormBuilderFields $field){
		$wclass=$this->all_fields[$field->getWidgetType()]['type'];
		
		$params=$field->getWidgetParams();
		if(is_array($params)){
			$options=(array_key_exists('options',$params))?$params['options']:array();
			$attributes=(array_key_exists('attributes',$params))?$params['attributes']:array();
		}else{
			$options=$attributes=array();
		}
		$this->setWidget($field->getName(),new $wclass($options,$attributes));
		if(!in_array($wclass,array('spyWidgetFormFieldsetStart','spyWidgetFormFieldsetEnd')))
			$this->setLabel($field->getName(),$field->getLabel());
		else
			$this->setLabel($field->getName()," ");
		if($field->getHelp()!='')
			$this->setHelp($field->getName(),$field->getHelp());

		//Liste des validations pour ce champ
		$validators=$field->getSpyFormBuilderValidatorss();
		
		$this->prepareValidators($field,$validators);
		
		
		
	}

	/**
	 * Prepare to render the validator field
	 * 
	 * @param SpyFormBuilderFields the field object
	 * @param Array of SpyFormBuilderValidators the validators Objects
	 */
	protected function prepareValidators(SpyFormBuilderFields $field, $validators=array()){
		if(sizeof($validators)>1){
			$valid=array();
			foreach($validators as $validator){
				$valid[]=$this->prepareValidator($validator);
			}
			$this->valids[$field->getName()]=new sfValidatorAnd($valid);
		}elseif(sizeof($validators)==1){
			$this->valids[$field->getName()]=$this->prepareValidator($validators[0]);
		}else{
			$this->valids[$field->getName()]=new sfValidatorNone();
		}
	}
	
	/**
	 * Prepare one validator class
	 * 
	 * @param SpyFormBuilderValidators the validator Object
	 * 
	 * @return sfValidatorBase
	 */
	protected function prepareValidator($validator){
		$validator_class=$this->all_validators[$validator->getValidatorType()]['type'];
		$params=$validator->getValidatorParams();
		
		if(is_array($params))
			$options=(array_key_exists('options',$params))?$params['options']:array();
		else
			$options=array();
			
		$options['trim']=(array_key_exists('trim',$options))?$options['trim']:true;
		$options['required']=(array_key_exists('required',$options))?$options['required']:false;
		
		return new $validator_class($options,array('invalid'=>$validator->getInvalidMsg()));
	}
	
	/**
	 * Set A widget
	 * 
	 * @param string name of field
	 * @param sfWidgetForm A widget form element
	 */
	protected function setWidget($name, sfWidgetForm $widget){
		$this->widgets[$name]=$widget;
	}
		
	/**
	 * Set A Label
	 * 
	 * @param string name of field
	 * @param string the label
	 */
	protected function setLabel($name, $label){
		$this->labels[$name]=$label;
	}
	
	/**
	 * Set Help message for field
	 * 
	 * @param string name of field
	 * @param string the help message
	 */
	protected function setHelp($name, $help){
		$this->helps[$name]=$help;
	}	

	/**
	 * Some of post Actions have one pré action like storeInPropel to retireve the datas
	 */
	protected function doPreActions(){
		$this->actions=$this->form_object->getSpyFormBuilderActions();
		foreach($this->actions as $action){
			//Construit l'action
			$action_class=$this->all_actions[$action->getActionType()]['type'];
			$params=$action->getActionParams();
			if(is_array($params))
			$options=(array_key_exists('options',$params))?$params['options']:array();
			
			
			$myAction=new $action_class($options, $this->formulaire->getValues(),$this);
			if($myAction->checkAll())
				$myAction->preExecute();
		}
	}
			
	/*
	 * Liste of action do an eecution after the validation of the form
	 */
	protected function doPostActions(){
		$this->actions=$this->form_object->getSpyFormBuilderActions();
		foreach($this->actions as $action){
			//Construit l'action
			$action_class=$this->all_actions[$action->getActionType()]['type'];
			$params=$action->getActionParams();
			if(is_array($params))
				$options=(array_key_exists('options',$params))?$params['options']:array();
			
			
			$myAction=new $action_class($options, $this->formulaire->getValues(),$this);
			if($myAction->checkAll())
				$myAction->execute();
		}
	}
			
	/**
	 * Get the url to render the form
	 * 
	 * @return string of the url to post
	 */
	protected function getUrlForForm(){
		//Module part
		$form_submit_url=sfContext::getInstance()->getModuleName().'/'.sfContext::getInstance()->getActionName();
		
		//Id of form part
		//SI le module contient le parametre id
		if(sfContext::getInstance()->getRequest()->getParameter('id')){
			$form_submit_url.='?id='.sfContext::getInstance()->getRequest()->getParameter('id');
		}elseif(sfContext::getInstance()->getRequest()->getParameter('form_name')){
			$form_submit_url.='?form_name='.sfContext::getInstance()->getRequest()->getParameter('form_name');
		}
		
		//Edit
		if(sfContext::getInstance()->getRequest()->getParameter('edit')){
			$form_submit_url.='&edit='.sfContext::getInstance()->getRequest()->getParameter('edit');
		}
		
		return $form_submit_url;
	}
	
	/**
	 * Render the form calcultae the URL to render and execute the template
	 */
	public function render(){
		$form=$this->formulaire;
		$form_submit_url=$this->getUrlForForm();
		eval('?>'.$this->form_object->getTemplate());
	}
	

}

class spyFormBuilderForm extends sfForm{
	
}
?>