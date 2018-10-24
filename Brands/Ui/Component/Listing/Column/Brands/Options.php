<?php
namespace Animates\Brands\Ui\Component\Listing\Column\Brands;

use Magento\Framework\Data\OptionSourceInterface;
class Options implements OptionSourceInterface
{

    /**
     * @var array
     */
    protected $options;

    /**
     * Options constructor.
     */
    public function __construct()
    {

    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [];
    }
}