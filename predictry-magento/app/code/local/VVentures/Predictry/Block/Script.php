<?php

/**
 * Author       : Rifki Yandhi
 * Date Created : Jul 7, 2014 1:28:04 PM
 * File         : VVentures/Predictry/Block/Script.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
class VVentures_Predictry_Block_Script extends Mage_Core_Block_Template
{

	public function __construct()
	{
		parent::__construct();
		if (Mage::helper("vventures_predictry")->getEnabled() === true)
			$this->setTemplate('vventures_predictry/script.phtml');
	}

	public function getConfig($key = null)
	{
		static $data = null;

		if ($key === null)
			return;

		$data = array(
			'enabled'			 => Mage::helper("vventures_predictry")->getEnabled(), //get from config
			'tenant_id'			 => Mage::helper("vventures_predictry")->getTenantId(), //get from config
			'api_key'			 => Mage::helper("vventures_predictry")->getApiKey(), //get from config
			'site_title'		 => 'Site Title',
			'site_description'	 => 'Site Description',
			'url'				 => $_SERVER['HTTP_HOST']
		);


		$customer_data	 = null;
		$customer		 = Mage::getSingleton('customer/session')->getCustomer();

		if (!empty($customer))
		{
			if ($customer->getId() != '')
				$customer_data['user_id'] = $customer->getId();
		}

		return $data[$key];
	}

}

/* End of file Script.php */
/* Location: ./VVentures/Predictry/Block/Script.php */	