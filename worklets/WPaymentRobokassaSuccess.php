<?php
class WPaymentRobokassaSuccess extends UWidgetWorklet
{
	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	
	public function taskConfig()
	{
		parent::taskConfig();
	}
	
	public function taskRenderOutput()
	{	
		$this->render('success_bill');
	}
}