<?php

/**
 * Author       : Rifki Yandhi
 * Date Created : Jul 7, 2014 1:28:04 PM
 * File         : VVentures/Predictry/Model/Observer.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     :
 */
class VVentures_Predictry_Model_Observer
{

  public function controllerActionBefore(Varien_Event_Observer $observer)
  {

    //send "action" view
    if ($observer->getEvent()->getControllerAction()->getFullActionName() === "catalog_product_view")
    {
      $product_id  = $observer->getEvent()->getControllerAction()->getRequest()->get('id');
      $product   = Mage::getModel('catalog/product')->load($product_id);
      if (!$product->getId())
        return;

      Mage::getSingleton('core/session')->setData('predictry_action_name', 'view');
      Mage::getSingleton('core/session')->setData('predictry_recent_viewed_product_id', $product_id);
    }

    //send "add_to_cart" view
    if ($observer->getEvent()->getControllerAction()->getFullActionName() === "checkout_cart_add")
    {
      Mage::log("product added to cart", null, "actions.log");
      $product = Mage::getModel('catalog/product')->load(Mage::app()->getRequest()->getParam('product', 0));
      if (!$product->getId())
        return;

      Mage::getSingleton('core/session')->setData('predictry_action_name', 'add_to_cart');
      $this->_setProductToShoppingCart($product);
    }

    //send "started_checkout" action
    if ($observer->getEvent()->getControllerAction()->getFullActionName() === "checkout_onepage_index")
    {
      Mage::log("started checkout", null, "actions.log");
      Mage::getSingleton('core/session')->setData('predictry_action_name', 'started_checkout');
    }

    //send "started_payment" action
    if ($observer->getEvent()->getControllerAction()->getFullActionName() === "checkout_onepage_savePayment")
    {
      Mage::log("started payment", null, "actions.log");
      //since the page will not refresh
      //to REST api call
      $curl    = new Varien_Http_Adapter_Curl();
      $url     = Mage::helper("vventures_predictry")->getApiResources('api_url') . Mage::helper("vventures_predictry")->getApiResources('api_action_resources');
      $tenant_id   = Mage::helper("vventures_predictry")->getTenantId();
      $api_key   = Mage::helper("vventures_predictry")->getApiKey();
      $curl->write(Zend_Http_Client::POST, $url, '1.0', array('X-Predictry-Server-Tenant-ID: ' . $tenant_id, 'X-Predictry-Server-Api-Key: ' . $api_key), http_build_query(Mage::helper("vventures_predictry")->getProductFromCart("started_payment")));
      $curl->read();

      Mage::getSingleton('core/session')->setData('predictry_action_name', 'started_payment');
    }

    //send "buy" action
    if ($observer->getEvent()->getControllerAction()->getFullActionName() === "checkout_onepage_success")
    {
      Mage::log("item bought", null, "actions.log");
      Mage::getSingleton('core/session')->setData('predictry_action_name', 'buy');
      Mage::getSingleton('core/session')->setData('predictry_recent_order_id', Mage::getSingleton('checkout/session')->getLastRealOrderId());
    }
  }

  public function _setProductToShoppingCart($product)
  {
    $categories = $product->getCategoryIds();
    Mage::getModel('core/session')
        ->setProductToShoppingCart(new Varien_Object(array(
          'id'       => $product->getId(),
          'qty'      => Mage::app()->getRequest()->getParam('qty', 1),
          'name'       => $product->getName(),
          'price'      => $product->getPrice(),
          'category_name'  => Mage::getModel('catalog/category')->load($categories[0])->getName(),
    )));
  }

  function _logAction($product, $action)
  {
    if ($action === 'add_to_cart')
      Mage::log("{$product->getName()} ({$product->getId()}) {$action}, qty : (" . Mage::app()->getRequest()->getParam('qty', 1) . "), price : ({$product->getPrice()})", null, "cart-updates.log");
    else if ($action === 'buy')
      Mage::log("{$product->getName()} ({$product->getId()}) {$action}, qty : (" . Mage::app()->getRequest()->getParam('qty', 1) . "), price : ({$product->getPrice()})", null, "actions.log");
    else
      Mage::log("{$product->getName()} ({$product->getId()}) {$action}", null, "actions.log");
  }

  //update on admin
  public function logUpdate(Varien_Event_Observer $observer)
  {
    $product = $observer->getEvent()->getProduct();
    $curl  = new Varien_Http_Adapter_Curl();
    $url   = Mage::helper("vventures_predictry")->getApiResources('api_url') . Mage::helper("vventures_predictry")->getApiResources('api_item_resources');

    $tenant_id       = Mage::helper("vventures_predictry")->getTenantId();
    $api_key       = Mage::helper("vventures_predictry")->getApiKey();
    $product_collection  = Mage::getModel('catalog/product')
        ->getCollection()
        ->addAttributeToFilter('entity_id', $product->getEntityId())
        ->addUrlRewrite();

    $product_url = ($product_collection) ? $product_collection->getFirstItem()->getProductUrl() : "";
    $categories  = $product->getCategoryIds();

    $stock_data      = $product->getData('stock_data');
    $inventory_status  = 'out_of_stock';
    if ($stock_data['manage_stock'] || $stock_data['use_config_manage_stock'])
    {
      if ($stock_data['is_in_stock'] && !isset($stock_data['qty']))
        $inventory_status  = ($stock_data['is_in_stock']) ? 'in_stock' : 'out_of_stock';
      else if ($stock_data['is_in_stock'] && isset($stock_data['qty']))
        $inventory_status  = $stock_data['qty'];
      else
        $inventory_status  = 'out_of_stock';
    }
    else
      $inventory_status = 'in_stock';

    $item_data = array(
      'item_id'    => $product->getId(),
      'description'  => $product->getName(),
      'properties'   => array(
        'item_url'     => $product_url,
        'price'      => $product->getPrice(),
        'category'     => Mage::getModel('catalog/category')->load($categories[0])->getName(),
        'inventory_qty'  => $inventory_status
      )
    );

    try {
        $image_helper = Mage::helper('catalog/image')->init($product, 'image');
        if (!is_null($image_helper)) {
            $item_data['properties']['img_url'] = (string)$image_helper->resize(265);
        }
    } catch (Exception $e) {
        // do nothing if image doesn't exist
    }

    $curl->write(Zend_Http_Client::POST, $url, '1.0', array('X-Predictry-Server-Tenant-ID: ' . $tenant_id, 'X-Predictry-Server-Api-Key: ' . $api_key), http_build_query($item_data));
    $curl->read();
  }

  // delete item
  public function deleteItem($eventObject) {
    $item_id = $eventObject->getProduct()->getId();
    $curl  = new Varien_Http_Adapter_Curl();
    $tenant_id = Mage::helper("vventures_predictry")->getTenantId();
    $url = Mage::helper("vventures_predictry")->getApiResources('api_delete_item') . $tenant_id . "/" . $item_id;

    $curl->write(Zend_Http_Client::DELETE, $url, '1.0');
    $curl->read();
  }

}

/* End of file Observer.php */
/* Location: ./VVentures/Predictry/Model/Observer.php */
