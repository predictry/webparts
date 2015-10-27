<?php

/**
 * Author       : Rifki Yandhi
 * Date Created : Jul 7, 2014 1:28:04 PM
 * File         : VVentures/Predictry/Block/Action.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
class VVentures_Predictry_Block_Action extends Mage_Core_Block_Template
{

	protected $action_data		 = null;
	protected $bulk_action_data	 = null;
	protected $is_single		 = true;
	protected $order_id			 = null;
	protected $order			 = null;

	public function __construct()
	{
		parent::__construct();

		if (Mage::helper("vventures_predictry")->getEnabled() === true)
			$this->setTemplate('vventures_predictry/action.phtml');

		$this->action_data		 = Mage::helper('vventures_predictry')->getSampleSingleAction();
		$this->bulk_action_data	 = array(
			'action'	 => null,
			'user_id'	 => null,
			'actions'	 => array()
		);
	}

	public function getActionData()
	{
		$action_name = Mage::getSingleton('core/session')->getData('predictry_action_name', true);
		$product	 = $customer	 = null;

		switch ($action_name)
		{
      case "view":
				$product_id	 = Mage::getSingleton("core/session")->getData('predictry_recent_viewed_product_id', true);
				$product	 = ($product_id > 0) ? Mage::getModel('catalog/product')->load($product_id) : null;
				break;

			case "add_to_cart":
				$product_cart									 = Mage::getModel('core/session')->getProductToShoppingCart();
				$product										 = ($product_cart) ? Mage::getModel('catalog/product')->load($product_cart->getId()) : null;
        $this->action_data['action_properties']['qty']	 = $product_cart->getQty();
        break;

			case "buy":
				$this->is_single = false;
				$this->order_id	 = Mage::getSingleton("core/session")->getData('predictry_recent_order_id', true);
				$this->order	 = Mage::getModel('sales/order')->loadByIncrementId($this->order_id);
				$orderItems		 = $this->order->getAllItems();
				$this->getBulkActionData($action_name, $orderItems);
	
			case "product_update":
				break;

			default:
				return "";
		}

		if ($action_name === "view" || $action_name === "add_to_cart")
		{
			$this->action_data['action'] = $action_name;

			if ($product)
			{
				$product_collection = Mage::getModel('catalog/product')
						->getCollection()
						->addAttributeToFilter('entity_id', $product->getEntityId())
						->addUrlRewrite();

				$product_url = ($product_collection) ? $product_collection->getFirstItem()->getProductUrl() : "";

				$this->action_data['item_id']		 = $product->getId();
				$this->action_data['description']	 = $product->getName();
        
        $output .= 'var view_data = {';
        $output .= 'action: { name: "'. $action_name .'"},';
				//CUSTOMER DATA 
				$customer_id = Mage::getSingleton('customer/session')->getId();
				if ($customer_id)
				{
					$customer												 = Mage::getSingleton('customer/session')->getCustomer();
					$this->action_data['user_id']							 = $customer_id;
          $this->action_data['action_properties']['user_email']	 = $customer->getEmail();
          $output .= 'user: {';
          $output .= 'user_id: "'. $customer_id .'",';
          $output .= 'email: "' . $customer->getEmail() . '"';
          $output .= '},';
        }

        // global items parent 
        $output .= 'items: [ {';
      
        // only if the action is add_to_cart
        if ($action_name === "add_to_cart") 
        {
          $output .= 'item_id: "'. $product->getId() .'",';    
          $output .= 'qty:'. $product_cart->getQty() ;
        }

        // when the user buy generate this more
        if ($action_name === "buy") 
        {
          $products = $this->order->getAllItems();
          $output .= $products;
        }

				//ONLY VIEW ACTION SEND THE REST OF ITEM PROPERTIES
				if ($action_name === "view")
				{
					$categories = $product->getCategoryIds();
					$this->action_data['item_properties']['categories']	 = Mage::getModel('catalog/category')->load($categories[0])->getName();

          // js to generate
          $output .= 'item_id: "'. $product->getId() .'",'; 
          $output .= 'name: "'. $product->getName() .'",';
          $output .= 'price: "'. $product->getPrice() .'",';
          $output .= 'img_url: "'. $product->getImageUrl() . '",';
          $output .= 'item_url: "'. $product_url . '",';
          $output .= 'description: "'. $product->getDescription() .'",';
          $output .= 'categories: "'. Mage::getModel('catalog/category')->load($categories[0])->getName() .'"';
        }


			}

			if (count($this->action_data['action_properties']) <= 0)
				unset($this->action_data['action_properties']);
    
      
      $output .= "} ]";
      $output .= "};";
      $output .= "_predictry.push(['track', view_data]);";
      echo $output;
		}
	}

	public function getBulkActionData($action_name, $items)
	{

    $output .= 'var view_data = {';
    $output .= 'action: { name: "'. $action_name .'"},';
  
    //CUSTOMER DATA 
    $customer_id = Mage::getSingleton('customer/session')->getId();
    if ($customer_id)
    {
      // check if user is signed in ?
      $customer												 = Mage::getSingleton('customer/session')->getCustomer();
      $output .= 'user: {';
      $output .= 'user_id: "'. $customer_id .'",';
      $output .= 'email: "' . $customer->getEmail() . '"';
      $output .= '},';
    }

    // global items parent 
    $output .= 'items: [';

    // loop dependency
    $count = count($items);
    $i = 0;
		foreach ($items as $item)
    {
      // find that product with that id
      $product	 = Mage::getModel('catalog/product')->load($item->getProduct()->getId());

      $output .= '{';
      $output .= 'item_id: "'. $product->getId() . '",';
      $output .= 'qty: '. $item->getQtyOrdered() .',';
      $output .= 'sub_total:'. ($item->getQtyOrdered() * $product->getPrice()) ;  

      if ($count > 1) {
        if(++$i === $count) {
          $output .= '}';
        } else {
          $output .= '},';
        }
      } else {
        $output .= '}';
      } 
    }
    $output .= ']';
    $output .= "};";

    // global push service
    $output .= "_predictry.push(['track', view_data]);";

    // print out the final script
    echo $output;
	}

	public function isSingle()
	{
		return $this->is_single;
	}

	public function isModuleEnabled()
	{
		return Mage::helper("vventures_predictry")->getEnabled();
	}

	public function isRecoItem($action_name)
	{
		if ($action_name === 'view')
		{
			$getPredictrSrc = Mage::app()->getRequest()->getParam('predictry_src');
			if (isset($getPredictrSrc))
				return true;
		}
		else if ($action_name === 'add_to_cart')
		{
			$output			 = array();
			$http_referer	 = $this->getRequest()->getServer('HTTP_REFERER');
			$urls			 = explode("?", $http_referer);
			parse_str($urls[1], $output);

			if (array_key_exists('predictry_src', $output))
				return true;
		}

		return false;
	}

}

/* End of file Action.php */
/* Location: ./VVentures/Predictry/Block/Action.php */	