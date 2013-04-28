<?php
class WPaymentRobokassaAuthorize extends USystemWorklet
{

	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	

	
	public function run($items,$orderId=null,$options=array())
	{
	
		include_once(dirname(__FILE__).'/../components/robokassa.class.php');
		
		$config = array(
			'Username' => $this->param('Username'),
			'Signature1' => $this->param('Signature1'),
			'Signature2' => $this->param('Signature2'),
			'encoding' => $this->param('encoding'),
		);
		$config['Sandbox'] = $this->param('sandbox')?true:false;
		
		$robokassa = new Robokassa($config);
		
		$orderItems = array();
		$amount = 0;
		foreach($items as $key=>$val)
		{
			if(is_array($val))
			{
				$names[] = $val['name'];
				//$ids[] = $val['id'];
				
				$item = array(
					'l_name' => urlencode($val['name']),
					'l_amt' => $val['price'],
					'l_qty' => $val['quantity'],
				);
				$orderItems[] = $item;
				$amount+= $val['price']*$val['quantity'];
			}
		}

		
		$result = $robokassa->doPay(array(
			'email' => app()->user->getName(),
			'sum' => $amount,
			'inv_id' => $orderId,
			'ids' => 0,//$ids,
			'description' => implode(', ',$names),
		));
		
		
		
		if (app()->request->isAjaxRequest)
		{
			// авторизация заказа, заказ
			wm()->get('payment.order')->authorize($orderId,'');
			
			// редирект
			wm()->get('base.init')->addToJson(array(
				'redirect' => $result['REDIRECTURL'],
			));
		}
		else
			app()->request->redirect($result['REDIRECTURL']);

	}
	
}
