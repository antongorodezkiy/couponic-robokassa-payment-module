<?php
class WPaymentRobokassaInstallInstall extends UInstallWorklet
{
	public function taskModuleParams()
	{
		return CMap::mergeArray(parent::taskModuleParams(),array(
			'name' => 'Robokassa',
            'sandbox' => '1',
            'Username' => '',
            'Signature1' => '',
            'Signature2' => '',
		));
	}
}