<?php
namespace Animates\Brands\Model\Brands;

use Animates\Brands\Model\ResourceModel\Brands\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var CollectionFactory
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Animates\Brands\Helper\Data
     */
    protected $helperData;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param \Animates\Brands\Helper\Data $helperData
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        \Animates\Brands\Helper\Data $helperData,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->helperData = $helperData;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var $brand \Animates\Brands\Model\Brands */
        foreach ($items as $brand) {
            $brandsData = $brand->getData();
            if (isset($brandsData['brand_image'])) {
                unset($brandsData['brand_image']);
                $brandsData['brand_image'][0]['name'] = $brand->getData('brand_image');
                $brandsData['brand_image'][0]['url'] = $this->helperData->getImageUrl($brand->getData('brand_image'));
            }

            if (isset($brandsData['header_image'])) {
                unset($brandsData['header_image']);
                $brandsData['header_image'][0]['name'] = $brand->getData('header_image');
                $brandsData['header_image'][0]['url'] = $this->helperData->getImageUrl($brand->getData('header_image'));
            }

            $this->loadedData[$brand->getId()] = $brandsData;
        }

        $data = $this->dataPersistor->get('brands');

        if (!empty($data)) {
            $brand = $this->collection->getNewEmptyItem();
            $brand->setData($data);
            $brandsData = $brand->getData();
            if (isset($brandsData['brand_image'])) {
                unset($brandsData['brand_image']);
                $brandsData['brand_image'][0]['name'] = $brand->getData('brand_image');
                $brandsData['brand_image'][0]['url'] = $this->helperData->getImageUrl($brand->getData('brand_image'));
            }

            if (isset($brandsData['header_image'])) {
                unset($brandsData['header_image']);
                $brandsData['header_image'][0]['name'] = $brand->getData('header_image');
                $brandsData['header_image'][0]['url'] = $this->helperData->getImageUrl($brand->getData('header_image'));
            }

            $this->loadedData[$brand->getId()] = $brandsData;
            $this->dataPersistor->clear('brands');
        }

        return $this->loadedData;
    }
}