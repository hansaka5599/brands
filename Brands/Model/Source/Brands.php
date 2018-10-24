<?php
namespace Animates\Brands\Model\Source;

use Animates\Brands\Model\ResourceModel\Brands\CollectionFactory;

class Brands extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * Brand collection factory
     *
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Construct
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options[] = ['value' => '', 'label' => __('Please select a brand.')];
            $collection  = $this->collectionFactory->create()->addFieldToFilter('is_active', 1);
            foreach ($collection as $brand) {
                $this->_options[] = [
                    'value' => $brand['brand_id'],
                    'label' => $brand['brand_name']
                ];
            }
        }
        return $this->_options;
    }

    /**
     * @param int|string $value
     * @return bool
     */
    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }

    /**
     * @return array
     */
    public function getFlatColumns()
    {
        $attributeCode = $this->getAttribute()->getAttributeCode();
        return [
            $attributeCode => [
                'unsigned' => false,
                'default' => null,
                'extra' => null,
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'Animates Brand Options  ' . $attributeCode . ' column',
            ],
        ];
    }
}