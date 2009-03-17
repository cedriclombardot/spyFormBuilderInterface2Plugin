<?php

class spyWidgetFormSelectRadio extends sfWidgetFormSelectRadio{
	public function __construct($options = array(), $attributes = array()){
		 $options['choices']=explode('
',$options['choices']);
		 $ch=array();
		 foreach($options['choices']  as $choix){
		 	$ch[$choix]=$choix;
		 }
		 $options['choices']=$ch;
		
		 parent::__construct($options, $attributes);
	}
}
?>