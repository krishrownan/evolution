<?php
/**
 * Module 		: Bulkpurchase
 * Author 		: Tychons Magento Team
 * Date 		: July 2019
 * Description 	: Bulk order functionality from product category page.
*/

namespace Bioworld\Bulkpurchase\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey;
use Magento\Checkout\Model\Cart;
use Magento\Catalog\Model\Product;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $formKey;
    protected $cart;
    protected $product;
    protected $helperData;


	public function __construct(
		Context $context,
		FormKey $formKey,
		Cart $cart,
		Product $product,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{
		$this->_pageFactory = $pageFactory;
		$this->formKey = $formKey;
	    $this->cart = $cart;
	    $this->product = $product; 

		return parent::__construct($context);
	}

	/*
	* Add Products to Cart
	*/

	public function execute()
	{

		if (!$this->getRequest()->isAjax()) {
            die('Invalid Request');
        }

		$params = $this->getRequest()->getParams();


		$product_id 	= $this->getRequest()->getParam('product');
        $cat_id 		= $this->getRequest()->getParam('cat_id');
        $qty 			= $this->getRequest()->getParam('qty');
        $product_array 	= $this->getRequest()->getParam($product_id);
        $product_child 	= $this->getRequest()->getParam('product_child');
        $moqRule     	= $this->getRequest()->getParam('moqRule');

        $qtyMin = 0;
        $qty1 = '';
		$flag1 = '';
		$flag = 0;

        foreach($product_child as $pid => $product_array)
		{
			foreach($product_array as $stock => $qty_array)
			{
				foreach($qty_array as $min_qty => $quantity)
				{
					if($quantity>0 && $quantity!='')
					{
						if($stock <= 2)
						{
							$flag = 1;
                			$qtyMin = $qtyMin + $quantity;
						}
						else {
			                $flag1 = 1;
			                $qtyMin = $qtyMin + $quantity;
			            }
					}
				}				
			}
		}


		if ($qtyMin < 3 && $flag1 == 1 && $flag == '') {
            $msgr = 'Minimum 3 quantity required.';
            $msg['resp'] = $msgr;
        } else if ($qtyMin < 3 && $flag1 == 1 && $flag == 1) {
            $msg['resp'] = 'Minimum 3 quantity required.';
        } else {


		foreach($product_child as $pid => $product_array)
		{
			foreach($product_array as $stock => $qty_array)
			{
				foreach($qty_array as $min_qty => $quantity)
				{
						if($quantity>0 && $quantity!='')
						{



							 try {

								$params = array(
						                    'form_key' => $this->formKey->getFormKey(),
						                    'product' => $pid, 
						                    'qty'   => $quantity,
						                );  

								$storeId = $this->_objectManager->get(\Magento\Store\Model\StoreManagerInterface::class)->getStore()->getId();

		                		$product = $this->_objectManager->create('Magento\Catalog\Model\Product')->setStoreId($storeId)->load($pid);

						        $this->cart->addProduct($product, $params);

						        $msg['resp'] = 'Success';

					        } catch (\Exception $e) {
					        	$msg['resp'] = $e->getMessage();
				                $this->messageManager->addException($e, __('We can\'t add this item to your shopping cart right now.'));
				                \Magento\Framework\App\ObjectManager::getInstance()->get(\Psr\Log\LoggerInterface::class)->critical($e);
				            }

					}
					
				}


			}
		}

			
			if($msg['resp']=='Success')
			{
				$this->cart->save();
				$this->cart->save()->getQuote()->collectTotals();	
			}
			
	}
				

		//return $this->_pageFactory->create();
		
		$product_poup = $msg;

        $this->getResponse()->setBody(json_encode($product_poup));
        return ;
	}

}