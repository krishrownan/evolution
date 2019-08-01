<?php
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

	public function execute()
	{
		$params = $this->getRequest()->getParams();

		$product_id 	= $this->getRequest()->getParam('product');
        $cat_id 		= $this->getRequest()->getParam('cat_id');
        $qty 			= $this->getRequest()->getParam('qty');
        $product_array 	= $this->getRequest()->getParam($product_id);


  //       echo "PID:".$product_id;
  //       echo "PID:".$product_id;
  //       echo "CID:".$cat_id;

		echo '<pre>';
		print_r($params);
		echo '</pre>';
		// exit;

		foreach($product_array as $key => $p)
        {
        	$qty = $p['qty'];

        	$productId =$product_i;d
	        $params = array(
	                    'form_key' => $this->formKey->getFormKey(),
	                    'product' => $productId, 
	                    'qty'   => $qty
	                );   
	        //print_r($params);           
	        $product = $this->product->load($productId);       
	        $this->cart->addProduct($product, $params);
	        $this->cart->save();
        }
        echo "Success";
exit;

		

		return $this->_pageFactory->create();
	}
}