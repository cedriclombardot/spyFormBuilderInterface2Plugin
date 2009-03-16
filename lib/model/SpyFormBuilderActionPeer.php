<?php

class SpyFormBuilderActionPeer extends BaseSpyFormBuilderActionPeer
{
	static public function retrieveByRank($form_id, $rank){
		$c= new Criteria();
		$c->add(self::FORM_ID,$form_id);
		$c->add(self::RANK,$rank);
		return self::doSelectOne($c);
	}
}
