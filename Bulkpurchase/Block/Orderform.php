<?php
namespace Bioworld\Bulkpurchase\Block;
use Magento\Framework\View\Element\Template;

class Orderform extends \Magento\Framework\View\Element\Template
{
	protected $_registry;

    public function __construct(Template\Context $context, array $data = array(),
    							\Magento\Framework\Registry $registry
								)
    {
    	$this->_registry = $registry;
    	$category = $this->_registry->registry('current_category');//get current category

    	//echo ">>>".$category->getId();exit;

        parent::__construct($context, $data);
    }

    public function getFormAction()
    {
    	return $this->getBaseUrl().'bulkpurchase/index/index/';
    }
}
?>
