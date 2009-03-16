<?php

class sfValidatorRequired extends sfValidatorBase {
	public function configure($options = array(), $messages = array()){
		$this->setOption('required',true);
		$this->setMessages(array('required'=>$messages['invalid'],'invalid'=>''));
	}
	
 	protected function doClean($value)
  	{
    $clean = $value;

    return $clean;
  }
}
?>