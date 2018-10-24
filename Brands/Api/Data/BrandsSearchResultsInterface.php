<?php
namespace Animates\Brands\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for brands search results.
 * @api
 */
interface BrandsSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get brands list.
     *
     * @return \Animates\Brands\Api\Data\BrandsInterface[]
     */
    public function getItems();

    /**
     * Set brands list.
     *
     * @param \Animates\Brands\Api\Data\BrandsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
