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

	protected function getRecommendation($product, $widget_id, $recommendationType = 'duo')
	{
		if (!Mage::helper("vventures_predictry")->getEnabled())
			return false;

		// Similar recommendation is special in case that we need to hit to Fisher API if json is not found.
		if ($recommendationType == 'similiar') {
			return $this->getSimilarRecommendation($product);
		}

		$item_id = $product->getId();
		$response = $this->retrieveDataFromS3($recommendationType, $item_id);
		if ($response !== null)
			return json_decode($response);
		else
			return false;
	}

	public function getSimilarRecommendation($product) {
		$response = $this->retrieveDataFromS3('similiar', $product->getId());
		if (substr_count($response, '<Code>AccessDenied</Code>') > 0) {
			$response = $this->retrieveDataFromFisher($product->getId(), $product->getName());

		}
		return json_decode($response);
	}

	public function retrieveDataFromS3($recommendationType, $itemId) {
		$response = null;
		try {
			$curl = new Varien_Http_Adapter_Curl();
			$baseUrl = Mage::helper("vventures_predictry")->getApiResources('s3_url');
			$tenantId = Mage::helper("vventures_predictry")->getTenantId();
			$curl->write(Zend_Http_Client::GET, "$baseUrl/data/tenants/$tenantId/recommendations/$recommendationType/$itemId.json", '1.0');
			$response = trim(strstr($curl->read(), "\r\n\r\n"));
			$curl->close();
		} catch (Exception $ex) {
			Mage::log(array('error' => $ex->getMessage(), 'code' => $ex->getCode()), null, "actions.log");
		}
		return $response;
	}

	public function retrieveDataFromFisher($itemId, $name) {
		$response = null;
		try {
			$curl = new Varien_Http_Adapter_Curl();
			$baseUrl = Mage::helper('vventures_predictry')->getApiResources('fisher_url');
			$tenantId = Mage::helper("vventures_predictry")->getTenantId();
			$searchData = ['fields'=>['name'], 'value'=>$name];
			$curl->write(Zend_Http_Client::GET, "$baseUrl/fisher/items/$tenantId/related/$itemId", '1.0', array(), json_encode($searchData));
			$response = trim(strstr($curl->read(), "\r\n\r\n"));
			$curl->close();
		} catch (Exception $ex) {
			Mage::log(array('error' => $ex->getMessage(), 'code' => $ex->getCode(), null, "actions.log"));
		}
		return $response;
	}

}