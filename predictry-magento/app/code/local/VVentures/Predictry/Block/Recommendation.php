<?php

/**
 * Author       : Rifki Yandhi
 * Date Created : Jul 16, 2014 10:45:50 AM
 * File         : VVentures/Predictry/Block/Recommendation.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
class VVentures_Predictry_Block_Recommendation extends Mage_Catalog_Block_Product_Abstract
{

	protected function getRecommendation($product, $widget_id)
	{
		if (!Mage::helper("vventures_predictry")->getEnabled())
			return false;

		$customer_id = (Mage::getSingleton('customer/session')->getId()) ? Mage::getSingleton('customer/session')->getId() : $_COOKIE['predictry_userid'];

		$reco_data = array(
			'item_id'	 => $product->getId(),
			'user_id'	 => $customer_id,
			'widget_id'	 => $widget_id,
			'session_id' => $_COOKIE['predictry_session']
		);

		$json_response = null;
		try
		{
			$curl		 = new Varien_Http_Adapter_Curl();
			$url		 = Mage::helper("vventures_predictry")->getApiResources('api_url') . Mage::helper("vventures_predictry")->getApiResources('api_recommendation_resources');
			$tenant_id	 = Mage::helper("vventures_predictry")->getTenantId();
			$api_key	 = Mage::helper("vventures_predictry")->getApiKey();
			$curl->write(Zend_Http_Client::GET, $url . "?" . http_build_query($reco_data), '1.0', array('X-Predictry-Server-Tenant-ID: ' . $tenant_id, 'X-Predictry-Server-Api-Key: ' . $api_key));
			$response	 = $curl->read();

			$temp_response	 = explode("\n", $response);
			$json_response	 = end($temp_response);
			$curl->close();
		}
		catch (Exception $ex)
		{
			Mage::log(array('error' => $ex->getMessage(), 'code' => $ex->getCode()), null, "actions.log");
		}

		if ($json_response !== null)
			return json_decode($json_response);
		else
			return false;
	}

}

/* End of file Recommendation.php */
/* Location: ./VVentures/Predictry/Block/Recommendation.php */	