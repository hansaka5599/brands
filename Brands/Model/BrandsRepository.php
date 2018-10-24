<?php
namespace Animates\Brands\Model;

use Animates\Brands\Api\Data;
use Animates\Brands\Api\BrandsRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Animates\Brands\Model\ResourceModel\Brands as ResourceBrands;
use Magento\Framework\EntityManager\EntityManager;
use Animates\Brands\Model\ResourceModel\Brands\CollectionFactory as BrandsCollectionFactory;

/**
 * Class BrandsRepository
 * @package Animates\Brands\Model
 */
class BrandsRepository implements BrandsRepositoryInterface
{
    /**
     * @var ResourceBrands
     */
    protected $resource;

    /**
     * @var BrandsFactory
     */
    protected $brandsFactory;

    /**
     * @var BrandsCollectionFactory
     */
    protected $brandsCollectionFactory;

    /**
     * @var Data\BrandsSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Animates\Brands\Api\Data\BrandsInterfaceFactory
     */
    protected $dataBrandsFactory;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * BrandsRepository constructor.
     *
     * @param ResourceBrands $resource
     * @param BrandsFactory $brandsFactory
     * @param Data\BrandsInterfaceFactory $dataBrandsFactory
     * @param BrandsCollectionFactory $brandsCollectionFactory
     * @param Data\BrandsSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param EntityManager $entityManager
     */
    public function __construct(
        ResourceBrands $resource,
        BrandsFactory $brandsFactory,
        Data\BrandsInterfaceFactory $dataBrandsFactory,
        BrandsCollectionFactory $brandsCollectionFactory,
        Data\BrandsSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        EntityManager $entityManager
    ) {
        $this->resource = $resource;
        $this->brandsFactory = $brandsFactory;
        $this->brandsCollectionFactory = $brandsCollectionFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataBrandsFactory = $dataBrandsFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * Save brands
     *
     * @param \Animates\Brands\Api\Data\BrandsInterface $brands
     * @return \Animates\Brands\Api\Data\BrandsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Animates\Brands\Api\Data\BrandsInterface $brands)
    {
        /** @var \Animates\Brands\Model\Brands $brandsModel */
        $brandsModel = $this->brandsFactory->create();
        if ($brandsId = $brands->getId()) {
            $this->entityManager->load($brandsModel, $brandsId);
        }
        $brandsModel->addData(
            $this->dataObjectProcessor->buildOutputDataArray($brands, Data\BrandsInterface::class)
        );

        $this->entityManager->save($brandsModel);
        return $brandsModel;
    }

    /**
     * Retrieve brands
     *
     * @param int $brandsId
     * @return \Animates\Brands\Api\Data\BrandsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($brandsId)
    {
        /** @var \Animates\Brands\Model\Brands $brandsModel */
        $brandsModel = $this->brandsFactory->create();
        $this->entityManager->load($brandsModel, $brandsId);
        if (!$brandsModel->getId()) {
            throw NoSuchEntityException::singleField('brandsId', $brandsId);
        }
        return $brandsModel;
    }

    /**
     * Load brand data collection by given search criteria
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Animates\Brands\Api\Data\BrandsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->brandsCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $values = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $conditionType = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = [$filter->getField()];
                $values[] = [ $conditionType => $filter->getValue()];
            }

            if ($fields) {
                $collection->addFieldToFilter($fields, $values);
            }
        }

        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }

        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * Delete brands
     *
     * @param \Animates\Brands\Api\Data\BrandsInterface $brands
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Animates\Brands\Api\Data\BrandsInterface $brands)
    {
        return $this->deleteById($brands->getId());
    }

    /**
     * Delete brand by ID.
     *
     * @param int $brandsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($brandsId)
    {
        /** @var \Animates\Brands\Model\Brands $brandsModel */
        $brandsModel = $this->brandsFactory->create();
        $this->entityManager->load($brandsModel, $brandsId);
        if (!$brandsModel->getId()) {
            throw NoSuchEntityException::singleField('brandsId', $brandsId);
        }
        $this->entityManager->delete($brandsModel);
        return true;
    }
}