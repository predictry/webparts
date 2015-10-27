<?php

/**
 * Author       : Rifki Yandhi
 * Date Created : Jul 16, 2014 10:45:50 AM
 * File         : VVentures/Predictry/Block/Widget/Recommendation.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
class VVentures_Predictry_Block_Widget_Recommendation extends VVentures_Predictry_Block_Recommendation implements Mage_Widget_Block_Interface
{

	protected $_mapRenderer			 = 'msrp_noform';
	protected $_columnCount			 = 4;
	protected $_items;
	protected $_itemCollection;
	protected $_itemLimits			 = array();
	protected $_widget_instance_id	 = null;

	protected function _prepareData()
	{
		$current_product = $this->getProduct();
		$recomm_response = $this->getRecommendation($current_product, $this->getData('predictry_widget_id'));
		$recomm			 = null;
		if ($recomm_response && is_array($recomm_response->recomm))
		{
			$recomm						 = $recomm_response->recomm;
			$this->_widget_instance_id	 = $recomm_response->widget_instance_id;
		}

		$recomm_product_ids = array();
		foreach ($recomm as $obj)
			array_push($recomm_product_ids, $obj->id);

		/*
		 * JUST SAMPLE DATA
		 */
		$this->_widget_instance_id	 = 5;
		$recomm_product_ids			 = array(395, 419, 399, 437);

		if (count($recomm_product_ids) > 0)
		{
			$this->_itemCollection = Mage::getModel('catalog/product')->getCollection()->addIdFilter($recomm_product_ids);

			$this->_itemCollection = $this->_itemCollection
					->addMinimalPrice()
					->addFinalPrice()
					->addTaxPercents()
					->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
					->addUrlRewrite();

			if (Mage::helper('catalog')->isModuleEnabled('Mage_Checkout'))
			{
				Mage::getResourceSingleton('checkout/cart')->addExcludeProductFilter($this->_itemCollection, Mage::getSingleton('checkout/session')->getQuoteId());
				$this->_addProductAttributesAndPrices($this->_itemCollection);
			}

			$this->_itemCollection->load();

			foreach ($this->_itemCollection as $product)
			{
				$product->setDoNotUseCategoryId(true);
			}
		}

		return $this;
	}

	public function getWidgetTitle()
	{
		return $this->getData('predictry_widget_title');
	}

	public function getItemCollection()
	{
		return $this->_itemCollection;
	}

	public function getColumnCount()
	{
		return $this->_columnCount;
	}

	public function resetItemsIterator()
	{
		$this->getItems();
		reset($this->_items);
	}

	public function getIterableItem()
	{
		$item = current($this->_items);
		next($this->_items);
		return $item;
	}

	public function getItems()
	{
		if (is_null($this->_items) && $this->getItemCollection())
		{
			$this->_items = $this->getItemCollection()->getItems();
		}
		return $this->_items;
	}

	public function getRowCount()
	{
		return ceil(count($this->getItemCollection()->getItems()) / $this->getColumnCount());
	}

	public function setColumnCount($columns)
	{
		if (intval($columns) > 0)
		{
			$this->_columnCount = intval($columns);
		}
		return $this;
	}

	public function getWidgetInstanceId()
	{
		return $this->_widget_instance_id;
	}

	public function getItemLimit()
	{
		return $this->getData('recommended_products_per_page');
	}

	public function getThumbnailSize()
	{
		return $this->getData('predictry_thumbnail_size');
	}

	public function getStyleAppearance()
	{
		return $this->getData('predictry_style_appearance');
	}

}

/* End of file Recommendation.php */
/* Location: ./VVentures/Predictry/Block/Widget/Recommendation.php */	