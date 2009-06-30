<?php

#require_once(sfContext::getInstance()->getConfigCache()->checkConfig('config/spy_form_actions.yml'));

class SpyFormBuilderAction extends BaseSpyFormBuilderAction
{
	public function getActions(){
		
		$request = sfContext::getInstance()->getRequest();
  		$root = $request->getRelativeUrlRoot();

		$all_actions=sfConfig::get('sfa_actions_actions',array());
		if(!array_key_exists($this->getActionType(),$all_actions))
			return '';
		foreach($all_actions[$this->getActionType()] as $aname=>$action){
			if(!array_key_exists('img',$action))
				$action['img']='/sf/sf_admin/images/default_icon.png';
				$controller=sfContext::getInstance()->getController();
			echo '<a href="'.$controller->genUrl('spyFormBuilderInterfaceActions/action',false).'/do/'.$aname.'/id/'.$this->getId().'" title="'.$action['title'].'">
			<img src="'.$root.'/'.$action['img'].'" alt="'.$action['title'].'" /></a>';
		}
	}
	public function getActionParams(){
		return unserialize(parent::getActionParams());
	}
	
	public function getParameter($name,$default=null,$group='options'){
		$params=$this->getActionParams();
	
		if(array_key_exists($name,$params[$group])){
			if($params[$group][$name]!='')
				return $params[$group][$name];
		}
		return $default;
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
