<?php

class SpyFormBuilderValidators extends BaseSpyFormBuilderValidators
{
	public function __toString(){
		return $this->getValidatorType();
	}
	
	
	public function save(PropelPDO $con=null){
		if(!$this->getRank()){
			$this->insertAtLastPos();
		}
		parent::save($con);
	}
	public function getValidatorParams(){
		if(!is_null(parent::getValidatorParams()))
			return unserialize(parent::getValidatorParams());
		return array();
	}
	public function getParameter($name,$default=null){
		$params=$this->getValidatorParams();
		if(array_key_exists($name,$params))
			return $params[$name];
		return $default;
	}
	public function insertAtLastPos(){
		$this->setRank($this->getMaxRank()+1);
	}
	
	public function moveUp(){
		if($this->getRank()==1)
			return false;
		$prec=SpyFormBuilderValidatorsPeer::retrieveByRank($this->getFormId(),($this->getRank()-1));
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
		$next=SpyFormBuilderValidatorsPeer::retrieveByRank($this->getFieldId(),($this->getRank()+1));
		if($next instanceof self){
			$next->setRank($this->getRank());
			$next->save();
			$this->setRank(($this->getRank()+1));
			$this->save();
		}
	}
	public function getMaxRank(){
		$c=new Criteria();
		$c->add(SpyFormBuilderValidatorsPeer::FIELD_ID,$this->getFieldId());
		$c->addDescendingOrderByColumn(SpyFormBuilderValidatorsPeer::RANK);
		$last=SpyFormBuilderValidatorsPeer::doSelectOne($c);
		if($last instanceof self){
			return $last->getRank();
		}else{
			return 0;
		}
	}
}
