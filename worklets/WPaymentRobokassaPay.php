<?php
Yii::import('application.modules.payment.modules.robokassa.worklets.WPaymentRobokassaAuthorize',true);
class WPaymentRobokassaPay extends WPaymentRobokassaAuthorize
{
	public $paymentAction = 'sale';
}