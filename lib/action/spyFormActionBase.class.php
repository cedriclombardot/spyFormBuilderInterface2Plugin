<?php

abstract class spyFormActionBase {
	
	protected $options=array();
	
	protected $datas=array();
	
	protected $context;
	
	public function __construct($options, $datas, spyForm $context){
		$this->setDatas($datas);
		$this->context=$context;
		$this->setOptions($options);
		$this->configure($options);
		
	}
	
	/*
	 * @return spyForm
	 */
	public function getContext(){
		return $this->context;
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
	
	/* To set default Options */
	abstract public function configure($options);
	
	/* Execute the action */
	abstract public function execute();
}
?>