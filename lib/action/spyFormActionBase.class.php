<?php

abstract class spyFormActionBase {
	
	protected $options=array();
	
	protected $datas=array();
	
	protected $context;
	
	/** Liste des actions à vérifier avant l'exec */
	static $_checks=array();
	
	public function __construct($options, $datas, spyForm $context){
		$this->setDatas($datas);
		$this->context=$context;
		$this->setOptions($options);
		$this->configure($options);
		
	}
	
	/**
	 * Ajoute une vérification
	 * 
	 * @param string $cond PHP CODE condition
	 */
	protected static function addCheck($cond){
		spyFormActionBase::$_checks[]=$cond;
	}
	
	/**
	 * Supprimme le dernier check de la liste
	 */
	protected static function removeCheck(){
		unset(spyFormActionBase::$_checks[(sizeof(spyFormActionBase::$_checks)-1)]);
	}
	/**
	 * Verifie l'ensemble des checks et autorise ou non l'exec 
	 * 
	 * @return boolean 
	 */
	public function checkAll(){
		$t=true;
		if(sizeof(spyFormActionBase::$_checks)>0){
			foreach(spyFormActionBase::$_checks as $check){
				
				if(eval('return '.$check.' ?>')){
					$t=$t;
				}else{
					$t=false;
				}
			}
		}
		return $t;
	}
	
	/**
	 * @return spyForm
	 */
	public function getContext(){
		return $this->context;
	}
	
	/**
	 * Retourne un parametre de la requette
	 * 
	 * @param string parameter 
	 * @param mixed default Value
	 * @return mixed result of the parameter
	 */	
	public function getRequestParameter($parameter,$default=null){
		$request=sfContext::getInstance()->getRequest();
		return ($request->getParameter($parameter))?$request->getParameter($parameter):$default;
	}
	
	public function setOptions($options=array()){
		$this->options=array_merge($this->getOptions(),$options);
	}
	
	public function setOption($option,$value){
		$this->options[$option]=$value;
	}
	public function getOptions(){
		return $this->options;
	}
	
	public function getOption($opt_name, $default=null){
		if(array_key_exists($opt_name,$this->options)){
			if($this->options[$opt_name]!='')
				return $this->options[$opt_name];
		}
		return $default;
	}
	
	public function setDatas($datas=array()){
		$this->datas=array_merge($this->getDatas(),$datas);
	}
	
	public function getDatas(){
		return $this->datas;
	}
	
	public function getData($field_name, $default=null){
		if(array_key_exists($field_name,$this->datas)){
			if($this->datas[$field_name]!='')
				return $this->datas[$field_name];
		}
		return $default;
	}
	
	/** To set default Options */
	abstract public function configure($options);
	
	/** Execute the action */
	abstract public function execute();
	
	public function preExecute(){
	
	}
}
?>