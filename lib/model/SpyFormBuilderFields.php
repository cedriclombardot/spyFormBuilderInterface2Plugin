<?php
require_once(sfContext::getInstance()->getConfigCache()->checkConfig('config/spy_form_widgets.yml'));


class SpyFormBuilderFields extends BaseSpyFormBuilderFields
{
	
	public function save(PropelPDO $con=null){
		if(!$this->getRank()){
			$this->insertAtLastPos();
		}
		parent::save($con);
	}
	public function getWidgetParams(){
		return unserialize(parent::getWidgetParams());
	}
	public function getParameter($name,$default=null){
		$params=$this->getWidgetParams();
		if(array_key_exists($name,$params))
			return $params[$name];
		return $default;
	}
	public function insertAtLastPos(){
		$this->setRank($this->getMaxRank()+1);
	}
	
	/**
	 * @return boolean true if the field could have validators false for
	 * example for sumbit
	 */
	public function isValidable(){
		$all_validable=sfConfig::get('sfw_widgets_validable',array());
	
		if(!array_key_exists($this->getWidgetType(),$all_validable))
			return true;
			
		return $all_validable[$this->getWidgetType()];
		
	}
	
	public function getActions(){
		
		$request = sfContext::getInstance()->getRequest();
  		$root = $request->getRelativeUrlRoot();

		$all_actions=sfConfig::get('sfw_widgets_actions',array());
		if(!array_key_exists($this->getWidgetType(),$all_actions))
			return '';
		foreach($all_actions[$this->getWidgetType()] as $aname=>$action){
			if(!array_key_exists('img',$action))
				$action['img']='/sf/sf_admin/images/default_icon.png';
				
			echo '<a href="'.sfContext::getInstance()->getController()->genUrl('spyFormBuilderInterfaceFields/action',false).'/do/'.$aname.'/id/'.$this->getId().'" title="'.$action['title'].'">
			<img src="'.$root.'/'.$action['img'].'" alt="'.$action['title'].'" /></a>';
		}
	}
	
	public function moveUp(){
		if($this->getRank()==1)
			return false;
		$prec=SpyFormBuilderFieldsPeer::retrieveByRank($this->getFormId(),($this->getRank()-1));
		if($prec instanceof self){
			$prec->setRank($this->getRank());
			$prec->save();
			$this->setRank(($this->getRank()-1));
			$this->save();
		}
	}
	
	public function moveDown(){
		if($this->getRank()==$this->getMaxRank())
			return false;
		$next=SpyFormBuilderFieldsPeer::retrieveByRank($this->getFormId(),($this->getRank()+1));
		if($next instanceof self){
			$next->setRank($this->getRank());
			$next->save();
			$this->setRank(($this->getRank()+1));
			$this->save();
		}
	}
	public function getMaxRank(){
		$c=new Criteria();
		$c->add(SpyFormBuilderFieldsPeer::FORM_ID,$this->getFormId());
		$c->addDescendingOrderByColumn(SpyFormBuilderFieldsPeer::RANK);
		$last=SpyFormBuilderFieldsPeer::doSelectOne($c);
		if($last instanceof self){
			return $last->getRank();
		}else{
			return 0;
		}
	}
	
	public function setOnlyFor($array){
		return parent::setOnlyFor(serialize($array));
	}
	
	public function getOnlyFor(){
		return unserialize(parent::getOnlyFor());
	}
	
	public function setHideOnEdit($array){
		return parent::setHideOnEdit(serialize($array));
	}
	
	public function getHideOnEdit(){
		return @unserialize(parent::getHideOnEdit());
	}
}
