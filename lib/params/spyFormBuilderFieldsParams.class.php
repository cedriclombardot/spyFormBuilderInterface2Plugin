<?php
/*
 * (c) Cédric Lombardot <cedric.lombardot@spyrit.net>
 * Cette classe crée un formulaire html pour afficher la liste des 
 * parametres pour le champ séléctionné
 * 
 */
class spyFormBuilderFieldsParams extends spyFormBuilderParams  {
	
	/*
	 * Retourne le nom du groupe de champs
	 */
	public function getGroupName(){ return 'spy_form_builder_fields'; }
	
	/*
	 * Retourne le nom de la config
	 */
	public function getConfigName(){ return 'sfw_widgets_fields'; }
	
}
?>