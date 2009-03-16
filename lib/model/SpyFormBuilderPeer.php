<?php

class SpyFormBuilderPeer extends BaseSpyFormBuilderPeer
{
	static public function retrieveByName($name,  PropelPDO $con = null){
		$c=new Criteria(self::DATABASE_NAME);
		$c->add(self::NAME,$name,Criteria::LIKE);
		return self::doSelectOne($c);
	}
}
