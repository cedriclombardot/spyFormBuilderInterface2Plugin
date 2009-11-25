<?php

class spyWidgetFormFieldsetEnd extends sfWidgetForm{
	protected function configure($options = array(), $attributes = array())
	  {
	  }
	  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
  	return '</fieldset>';
  }
}
?>