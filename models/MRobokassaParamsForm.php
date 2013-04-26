<?php
class MRobokassaParamsForm extends UFormModel
{
	public $name;
	public $sandbox;
	public $Username;
	public $Signature1;
	public $Signature2;
	
	public static function module()
	{
		return 'payment.robokassa';
	}
	
	public function rules()
	{
		return array(
			array(implode(',',array_keys(get_object_vars($this))),'safe')
		);
	}
}