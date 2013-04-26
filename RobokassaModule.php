<?php
class RobokassaModule extends UWebModule
{	
	public function getTitle()
	{
		return 'Robokassa';
	}
	
	public function getRequirements()
	{
		return array('payment' => self::getVersion());
	}
}
