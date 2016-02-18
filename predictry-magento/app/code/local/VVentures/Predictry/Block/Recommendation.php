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

		$item_id = $product->getId();

		$json_response = null;
		try
		{
			$curl		 = new Varien_Http_Adapter_Curl();
			$baseUrl		 = Mage::helper("vventures_predictry")->getApiResources('s3_url');
			$tenant_id	 = Mage::helper("vventures_predictry")->getTenantId();
			$curl->write(Zend_Http_Client::GET, "$baseUrl/data/tenants/$tenant_id/recommendations/duo/$item_id.json", '1.0');
			$response	 = $curl->read();
			$json_response = trim(strstr($response, "\r\n\r\n"));
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