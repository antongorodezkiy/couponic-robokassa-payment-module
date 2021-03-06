<?php
class DefaultController extends UController
{
	function actionPayout()
	{
		include_once(dirname(__FILE__).'/../components/robokassa.class.php');
	
		$config = array(
			'Username' => $this->module->param('Username'),
			'Signature1' => $this->module->param('Signature1'),
			'Signature2' => $this->module->param('Signature2'),
			'encoding' => $this->module->param('encoding'),
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
	
	
	public function actionLogout()
	{
		app()->user->logout(false);
		app()->request->redirect(url('/'));
	}
}
