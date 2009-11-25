<?php

class spyWidgetFormFieldsetStart extends sfWidgetForm{
	protected function configure($options = array(), $attributes = array())
	  {
	  	$this->addRequiredOption('legend');
	  }
	  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
  	return '<fieldset name="'.$name.'" id="'.$name.'">'.$this->renderContentTag('legend', $this->getOption('legend'));
  }
}
?>