<?php

/**
 * Author       : Rifki Yandhi
 * Date Created : Jul 7, 2014 1:28:04 PM
 * File         : Helper/Data.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     :
 */
class VVentures_Predictry_Helper_Data extends Mage_Core_Helper_Abstract
{
	/* start config */

	public function getEnabled()
	{
		return Mage::getStoreConfig('vventures_predictry/vventures_predictry_basic/enabled');
	}

	public function getHostname()
	{
		return Mage::getStoreConfig('vventures_predictry/vventures_predictry_basic/hostname');
	}

	public function getTenantId()
	{
		return Mage::getStoreConfig('vventures_predictry/vventures_predictry_advance/tenant_id');
	}

	public function getApiKey()
	{
		return Mage::getStoreConfig('vventures_predictry/vventures_predictry_advance/api_key');
	}

	/* end start config */

	public function getSampleSingleAction()
	{
		$action_data = array(
			'action'			 => null,
			'session_id'		 => $_COOKIE['predictry_session'],
			'action_type'		 => 'single',
			'user_id'			 => $_COOKIE['predictry_userid'],
			'item_id'			 => null,
			'description'		 => null,
			'item_properties'	 => array(),
			'action_properties'	 => array()
		);

		return $action_data;
	}

	public function getCustomerId()
	{
		$customer_id = Mage::getSingleton('customer/session')->getId();
		return $customer_id;
	}

	public function getCustomerDetail()
	{
		$customer_id = Mage::getSingleton('customer/session')->getId();
		if ($customer_id)
			return Mage::getSingleton('customer/session')->getCustomer();

		return false;
	}

	public function getApiResources($key)
	{
		$api_resources = array(
			'api_url'						 => 'http://dashboard.predictry.com/api/v1/',
			'api_action_resources'			 => 'predictry',
			'api_recommendation_resources'	 => 'recommendation',
			'api_cart_resources'			 => 'cart',
			'api_item_resources'			 => 'item',
      		'api_delete_item'         => 'http://119.81.208.244:8090/fisher/items/'
		);

		return $api_resources[$key];
	}

	function getProductFromCart($action_name)
	{
		$quote				 = Mage::getSingleton('checkout/session')->getQuote();
		$cartItems			 = $quote->getAllVisibleItems();
		$customer_id		 = Mage::getSingleton('customer/session')->getId();
		$bulk_action_data	 = array();

		$actions = array();
		foreach ($cartItems as $item)
		{
			$action_data = $this->getSampleSingleAction();
			unset($action_data['session_id']);
			unset($action_data['action_type']);
			unset($action_data['user_id']);
			unset($action_data['action']);

			$product					 = Mage::getModel('catalog/product')->load($item->getProduct()->getId());
			$action_data['item_id']		 = $product->getId();
			$action_data['description']	 = $product->getName();
			array_push($actions, $action_data);
		}

		if (count($action_data['action_properties']) <= 0)
			unset($action_data['action_properties']);

		$customer = $this->getCustomerDetail();
		if ($customer)
		{
			$action_data['user_id']							 = $customer->getId();
			$action_data['action_properties']['user_email']	 = $customer->getEmail();
		}

		$bulk_action_data['session_id']	 = $_COOKIE['predictry_session'];
		$bulk_action_data['action']		 = $action_name;
		$bulk_action_data['actions']	 = $actions;
		$bulk_action_data['action_type'] = "bulk";
		$bulk_action_data['user_id']	 = isset($customer_id) ? $customer_id : null;

		return $bulk_action_data;
	}

	function getPredictryCartSession()
	{
		return json_decode($_COOKIE['predictry']);
	}

	function getCurrencyCodeFromOrder($order)
	{
		$currencyCode	 = '';
		$currency		 = $order->getOrderCurrency(); //$order object
		if (is_object($currency))
		{
			$currencyCode = $currency->getCurrencyCode();
		}
		$currencySymbol = Mage::app()->getLocale()->currency($currencyCode)->getSymbol();
		return $currencySymbol;
	}

}

/* End of file Data.php */
/* Location: ./VVentures/Predictry/Helper/Data.php */
