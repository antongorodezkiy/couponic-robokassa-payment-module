<?php
class WPaymentRobokassaCancel extends UWidgetWorklet
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
		include_once(dirname(__FILE__).'/../components/robokassa.class.php');
	
		$config = array(
			'Username' => $this->module->param('Username'),
			'Signature1' => $this->module->param('Signature1'),
			'Signature2' => $this->module->param('Signature2'),
		);
		$config['Sandbox'] = $this->module->param('sandbox')?true:false;
		
		$robokassa = new Robokassa($config);
		
		if ( $robokassa->checkPayment($_REQUEST) )
		{
			// списали счет
			wm()->get('payment.order')->void((int)$_REQUEST['InvId']);
			
			$this->render('cancel_bill');
		}
		else
			app()->request->redirect(url('/'));
	}
}
