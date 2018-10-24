<?php
namespace Animates\Brands\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Brands CRUD interface.
 * @api
 */
interface BrandsRepositoryInterface
{
    /**
     * Save brands
     *
     * @param \Animates\Brands\Api\Data\BrandsInterface $brands
     * @return \Animates\Brands\Api\Data\BrandsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Animates\Brands\Api\Data\BrandsInterface $brands);

    /**
     * Retrieve brands
     *
     * @param int $brandsId
     * @return \Animates\Brands\Api\Data\BrandsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($brandsId);

    /**
     * Retrieve brands matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Animates\Brands\Api\Data\BrandsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete brands
     *
     * @param \Animates\Brands\Api\Data\BrandsInterface $brands
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Animates\Brands\Api\Data\BrandsInterface $brands);

    /**
     * Delete brands by ID.
     *
     * @param int $brandsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($brandsId);
}
