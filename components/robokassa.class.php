<?php
/*
	**************************************************
	antongorodezkiy@gmail.com © 2011
	Version 1.0
	**************************************************
*/


class Robokassa
{

	var $Username = '';
	var $Signature1 = '';
	var $Signature2 = '';
	var $Sandbox = '';
	
	function __construct($config)
	{
		if(isset($config['Sandbox']))
			$this->Sandbox = $config['Sandbox'];
		else
			$this->Sandbox = true;
			
		$this->Username = isset($config['Username']) && $config['Username'] != '' ? $config['Username'] : '';
		$this->Signature1 = isset($config['Signature1']) && $config['Signature1'] != ''  ? $config['Signature1'] : '';
		$this->Signature2 = isset($config['Signature2']) && $config['Signature2'] != ''  ? $config['Signature2'] : '';
			
		if($this->Sandbox)
		{
			#Sandbox
			$this -> EndPointURL = 'http://test.robokassa.ru/Index.aspx';	
		}
		else
		{
			$this -> EndPointURL = 'https://merchant.roboxchange.com/Index.aspx';
		}
		

	
	}  // End function __construct()
	
	
	function doPay($order)
	{
		// email
			$email = $order['email'];
	
		// номер заказа
			$inv_id = $order['inv_id'];
		
		// описание заказа
			$inv_desc = $order['description'];
		
		// сумма заказа
			$out_summ = $order['sum'];
		
		// тип товара
			$shp_item = $order['ids'];
		
		// предлагаемая валюта платежа
			$in_curr = "PCR";
		
		// язык
			$culture = "ru";
		
		// кодировка
			$encoding = "windows-1251";
		
		// формирование подписи, порядок важен
			$crc_fields['Логин'] = $this->Username;
			$crc_fields['Сумма заказа'] = $out_summ;
			$crc_fields['Индивидуальный номер заказа'] = $inv_id;
			$crc_fields['Платежный пароль №1'] = $this -> Signature1;
			$crc_fields['Строка дополнительных параметров'] = "Shp_item=".$shp_item;
			$crc  = md5( implode(':',$crc_fields) );
		
		$params = array();
		$params['Culture'] = $culture;
		$params['Desc'] = $inv_desc;
		$params['EMail'] = $email;
		$params['Encoding'] = $encoding;
		$params['IncCurrLabel'] = $in_curr;
		$params['InvId'] = $inv_id;
		$params['MrchLogin'] = $this->Username;
		$params['OutSum'] = $out_summ;
		$params['Shp_item'] = $shp_item;
		$params['SignatureValue'] = $crc;
		$params['in'] = $out_summ;
		
		$params_str = array();
		foreach($params as $name => $value)
		{
			$params_str[] = $name.'='.$value;
		}
		
		$redirectUrl = $this->EndPointURL.'?'.implode('&',$params_str);
		
		return array( 'REDIRECTURL' => $redirectUrl);
	}
	
	
	function checkPayment($request)
	{
		if (!isset($request['OutSum']) or !isset($request['InvId']) or !isset($request['SignatureValue']) or !isset($request['Shp_item']))
			return false;
		
		$out_summ = (string)$request['OutSum'];
		$inv_id = (int)$request['InvId'];
		$SignatureValue = $request['SignatureValue'];
		$shp_item = $request['Shp_item'];
		
		// формирование подписи, порядок важен
			$crc_fields['Сумма заказа'] = $out_summ;
			$crc_fields['Индивидуальный номер заказа'] = $inv_id;
			$crc_fields['Платежный пароль №2'] = $this -> Signature2;
			$crc_fields['Строка дополнительных параметров'] = "Shp_item=".$shp_item;
			$crc  = strtoupper(md5( implode(':',$crc_fields) ));
		
		// все путем, продолжаем
		if ($SignatureValue == $crc)
			return true;
		else
			return false;
	}
	
	
}  // End class Robokassa
?>