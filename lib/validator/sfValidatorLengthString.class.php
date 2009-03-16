<?php

class sfValidatorLengthString extends sfValidatorString{

 protected function configure($options = array(), $messages = array())
  {
  	
    $this->addMessage('max_length', '"%value%" is too long (%max_length% characters max).');
    $this->addMessage('min_length', '"%value%" is too short (%min_length% characters min).');

    $this->addOption('max_length');
    $this->addOption('min_length');

    $this->setOption('empty_value', '');
    
    if($this->getOption('max_length'))
    	$this->setMessage('max_length',$messages['invalid']);
    else
    	$this->setMessage('min_length',$messages['invalid']);
  }
}
?>