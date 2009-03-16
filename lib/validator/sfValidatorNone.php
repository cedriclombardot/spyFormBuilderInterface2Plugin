<?php

class sfValidatorNone extends sfValidatorBase {
	public function configure($options = array(), $messages = array()){
		$this->setOption('required',false);
	}
	
 	protected function doClean($value)
  	{
    $clean = $value;

    return $clean;
  }
}
?>