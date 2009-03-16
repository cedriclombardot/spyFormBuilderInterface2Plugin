<?php

class sfWidgetFormEditArea extends sfWidgetFormTextarea{

 public function render($name, $value = null, $attributes = array(), $errors = array())
  {
  	$attributes['name']=$name;
  	$attributes=$this->fixFormId($attributes);
  	$js2=('editAreaLoader.init({
			id: "'.$attributes['id'].'"	// id of the textarea to transform		
			,start_highlight: true	// if start with highlight
			,allow_resize: "both"
			,allow_toggle: false
			,language: "'.sfContext::getInstance()->getUser()->getCulture().'"
			,syntax: "php"	
		});');
  	
  
  	$req=sfContext::getInstance()->getRequest();
  	$js='<script type="text/javascript" src="http://'.$req->getHost().$req->getRelativeUrlRoot().'/spyFormBuilderInterface2Plugin/js/editarea/edit_area/edit_area_full.js" ></script>';
    $js.='<script type="text/javascript" >'.$js2.'</script>';
   
    return $js.$this->renderContentTag('textarea', self::escapeOnce($value), array_merge(array('name' => $name), $attributes));
  }
}
?>