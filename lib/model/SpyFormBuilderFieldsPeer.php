<?php

class SpyFormBuilderFieldsPeer extends BaseSpyFormBuilderFieldsPeer
{
	static public function retrieveByRank($form_id, $rank){
		$c= new Criteria();
		$c->add(self::FORM_ID,$form_id);
		$c->add(self::RANK,$rank);
		return self::doSelectOne($c);
	}
}
