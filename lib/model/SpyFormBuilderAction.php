<?php

class SpyFormBuilderAction extends BaseSpyFormBuilderAction
{
	public function getActions(){
		return '';
	}
	public function getActionParams(){
		return unserialize(parent::getActionParams());
	}
	public function save(PropelPDO $con=null){
		if(!$this->getRank()){
			$this->insertAtLastPos();
		}
		parent::save($con);
	}
	
	public function insertAtLastPos(){
		$this->setRank($this->getMaxRank()+1);
	}
	
	public function moveUp(){
		if($this->getRank()==1)
			return false;
		$prec=SpyFormBuilderActionPeer::retrieveByRank($this->getFormId(),($this->getRank()-1));
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
		$next=SpyFormBuilderActionPeer::retrieveByRank($this->getFormId(),($this->getRank()+1));
		if($next instanceof self){
			$next->setRank($this->getRank());
			$next->save();
			$this->setRank(($this->getRank()+1));
			$this->save();
		}
	}
	public function getMaxRank(){
		$c=new Criteria();
		$c->add(SpyFormBuilderActionPeer::FORM_ID,$this->getFormId());
		$c->addDescendingOrderByColumn(SpyFormBuilderActionPeer::RANK);
		$last=SpyFormBuilderActionPeer::doSelectOne($c);
		if($last instanceof self){
			return $last->getRank();
		}else{
			return 0;
		}
	}
}
