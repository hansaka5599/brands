<?php
namespace Animates\Brands\Block\Adminhtml\Brands\Edit;

use Magento\Backend\Block\Widget\Context;
use Animates\Brands\Api\BrandsRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var BrandsRepositoryInterface
     */
    protected $brandsRepository;

    /**
     * @param Context $context
     * @param BrandsRepositoryInterface $brandsRepository
     */
    public function __construct(
        Context $context,
        BrandsRepositoryInterface $brandsRepository
    ) {
        $this->context = $context;
        $this->brandsRepository = $brandsRepository;
    }

    /**
     * Return ID
     *
     * @return int|null
     */
    public function getId()
    {
        try {
            return $this->brandsRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
