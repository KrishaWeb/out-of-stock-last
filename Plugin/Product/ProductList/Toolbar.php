<?php
/**
 * @author Rakesh Jesadiya
 * @package Rbj_OutOfStock
 */

namespace Krishaweb\OutOfStockLast\Plugin\Product\ProductList;

class Toolbar
{   
    
     protected $_scopeConfig;

    /**
     * @param \Magento\CatalogSearch\Model\ResourceModel\Fulltext\Collection $subject
     * @param bool $printQuery
     * @param bool $logQuery
     * @return array
     */
    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig) {
        $this->_scopeConfig = $scopeConfig;
    }
    public function beforeLoad(\Magento\CatalogSearch\Model\ResourceModel\Fulltext\Collection $subject, $printQuery = false, $logQuery = false)
    {

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORES;
        $OutOfStockLast = $this->_scopeConfig->getValue("outofstocklast/general/enabled", $storeScope);

        $orderBy = $subject->getSelect()->getPart(\Zend_Db_Select::ORDER);
        if($OutOfStockLast){
            $outOfStockOrderBy = array('is_salable DESC');
            $subject->getSelect()->reset(\Zend_Db_Select::ORDER);
            $subject->getSelect()->order($outOfStockOrderBy);
        }
        

        return [$printQuery, $logQuery];
    }
}