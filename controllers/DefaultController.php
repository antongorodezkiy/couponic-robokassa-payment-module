<?php
class DefaultController extends UController
{
	function actionPayout()
	{
		include_once(dirname(__FILE__).'/../components/robokassa.class.php');
	
		$config = array(
			'Username' => $this->module->param('Username'),
			'Signature1' => $this->module->param('Signature1'),
			'Signature2' => $this->module->param('Signature1'),
		);
		$config['Sandbox'] = $this->module->param('sandbox')?true:false;
		
		$robokassa = new Robokassa($config);
		
		if ( $robokassa->checkPayment($_REQUEST) )
		{
			// пополнили счет
			wm()->get('payment.order')->charge( (int)$_REQUEST['InvId'] );
			die('OK'.((int)$_REQUEST['InvId']));
		}
		else
			die('FAIL');
		
	}
	
	function actionCancel()
	{
		include_once(dirname(__FILE__).'/../components/robokassa.class.php');
	
		$config = array(
			'Username' => $this->module->param('Username'),
			'Signature1' => $this->module->param('Signature1'),
			'Signature2' => $this->module->param('Signature1'),
		);
		$config['Sandbox'] = $this->module->param('sandbox')?true:false;
		
		$robokassa = new Robokassa($config);
		
		if ( $robokassa->checkPayment($_REQUEST) )
		{
			// списали счет
			wm()->get('payment.order')->void((int)$_REQUEST['InvId']);
		}
		
		app()->request->redirect(url('/'));
		
	}
	
	
	public function actionLogout()
	{
		app()->user->logout(false);
		app()->request->redirect(url('/'));
	}
}