<?php

class SpyFormBuilderValidatorsPeer extends BaseSpyFormBuilderValidatorsPeer
{
	static public function retrieveByRank($field_id, $rank){
		$c= new Criteria();
		$c->add(self::FIELD_ID,$field_id);
		$c->add(self::RANK,$rank);
		return self::doSelectOne($c);
	}
}
