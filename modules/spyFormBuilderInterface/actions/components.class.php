<?php

class spyFormBuilderInterfaceComponents extends sfComponents {
		/*
		 * Liste des champs appartenant au formulaire en cours
		 */
		public function executeFields(){
			$c=new Criteria();
			$c->add(SpyFormBuilderFieldsPeer::FORM_ID,$this->spy_form_builder->getId());
			$c->addAscendingOrderByColumn(SpyFormBuilderFieldsPeer::RANK);
			$this->fields=SpyFormBuilderFieldsPeer::doSelect($c);
		}
		
		/*
		 * Liste des actions appartenant au formulaire en cours
		 */
		public function executeActions(){
			$c=new Criteria();
			$c->add(SpyFormBuilderActionPeer::FORM_ID,$this->spy_form_builder->getId());
			$c->addAscendingOrderByColumn(SpyFormBuilderActionPeer::RANK);
			$this->actions=SpyFormBuilderActionPeer::doSelect($c);
		}
}
?>