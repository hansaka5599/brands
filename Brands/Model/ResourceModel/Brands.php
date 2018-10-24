<?php
namespace Animates\Brands\Model\ResourceModel;

/**
 * Class Brands
 * @package Animates\Brands\Model\ResourceModel
 */
class Brands extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Resource Model
     */
    protected function _construct()
    {
        $this->_init('animates_brands', 'brand_id');
    }
}
