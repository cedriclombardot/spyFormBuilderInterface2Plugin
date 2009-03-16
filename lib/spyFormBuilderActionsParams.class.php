<?php
/*
 * (c) Cédric Lombardot <cedric.lombardot@spyrit.net>
 * Cette classe crée un formulaire html pour afficher la liste des 
 * parametres pour le champ séléctionné
 * 
 */
class spyFormBuilderActionsParams extends spyFormBuilderParams {
	
	/*
	 * Retourne le nom du groupe de champs
	 */
	public function getGroupName(){ return 'spy_form_builder_action'; }
	
	/*
	 * Retourne le nom de la config
	 */
	public function getConfigName(){ return 'sfa_actions_post'; }

}
?>