<?php
namespace Animates\Brands\Model\ResourceModel\Brands;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'brand_id';

    /**
     * Collection Model
     */
    protected function _construct()
    {
        $this->_init('Animates\Brands\Model\Brands', 'Animates\Brands\Model\ResourceModel\Brands');
    }

    /**
     * {@inheritdoc}
     */
    protected function _afterLoad()
    {
        $brandIds = $this->getColumnValues('brand_id');
        if (count($brandIds)) {
            $connection = $this->getConnection();
            $select = $connection->select()
                ->from(['pettype_linkage_table' => $this->getTable('animates_brands_pettype')])
                ->where('pettype_linkage_table.brand_id IN (?)', $brandIds);
            /** @var \Magento\Framework\DataObject $item */
            foreach ($this as $item) {
                $petTypes = [];
                $brandId = $item->getData('brand_id');
                foreach ($connection->fetchAll($select) as $data) {
                    if ($data['brand_id'] == $brandId) {
                        $petTypes[] = $data['pettype_id'];
                    }
                }
                $item->setData('pet_types', $petTypes);
            }
        }
        return parent::_afterLoad();
    }

    /**
     * Add Pet Type filter
     *
     * @param $petTypeId
     * @return $this
     */
    public function addPetTypesFilter($petTypeId)
    {
        $select = $this->getSelect();
        $select->join(
            'animates_brands_pettype',
            'animates_brands_pettype.brand_id=main_table.brand_id',
            []
        )->where('pettype_id IN (?)', [1, $petTypeId])
        ->group('main_table.brand_id');

        return $this;
    }
}