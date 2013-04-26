<?php
class WPaymentRobokassaAdminParams extends UParamsWorklet
{
	public function accessRules()
	{
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users'=>array('*'))
		);
	}
	
	public function title()
	{
		return;
	}
	
	public function properties()
	{
		return array(
			'elements' => array(
				'name' => array('type' => 'text', 'label' => $this->t('Name')),
				'sandbox' => array('type' => 'radiolist', 'label' => $this->t('Sandbox'),
					'items' => array(
						0 => $this->t('Disable'),
						1 => $this->t('Enable')
					), 'layout' => "{label}\n<fieldset>{input}\n{hint}</fieldset>"
				),
				'<h4>'.$this->t('Robokassa account info').'</h4>',
				$this->render('apiInfo',null,true),
				'Username' => array('type' => 'text', 'label' => $this->t('Username')),
				'Signature1' => array('type' => 'text', 'label' => $this->t('Signature#1')),
				'Signature2' => array('type' => 'text', 'label' => $this->t('Signature#2')),
			),
			'buttons' => array(
				'submit' => array('type' => 'submit', 'label' => $this->t('Save'))
			),
			'model' => $this->model
		);
	}
}