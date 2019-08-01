<?php
namespace Bioworld\Bulkpurchase\Plugin;

class ProductList
{   
    protected $layout;

    public function __construct(
        \Magento\Framework\View\LayoutInterface $layout
    ) {
        $this->layout = $layout;
    }

    public function aroundGetProductDetailsHtml(
        \Magento\Catalog\Block\Product\ListProduct $subject,
        \Closure $proceed,
        \Magento\Catalog\Model\Product $product
    ) {
        $html = $this->layout
			        ->createBlock('Bioworld\Bulkpurchase\Block\Orderform')
			        ->setProduct($product)
			        ->setTemplate('Bioworld_Bulkpurchase::product/list.phtml')
			        ->toHtml();
        return $html;
    }                  
}
