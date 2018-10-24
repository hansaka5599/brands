<?php
namespace Animates\Brands\Controller\Adminhtml\Brands;

/**
 * Class Edit
 * @package Animates\Brands\Controller\Adminhtml\Brands
 */
class Edit extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Animates\Brands\Api\BrandsRepositoryInterface
     */
    protected $brandsRepository;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Animates\Brands\Api\BrandsRepositoryInterface $brandsRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Animates\Brands\Api\BrandsRepositoryInterface $brandsRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $registry;
        $this->brandsRepository = $brandsRepository;
        parent::__construct($context);
    }

    /**
     * Initialize current Brands and set it in the registry.
     *
     * @return int
     */
    protected function _initBrands()
    {
        $brandsId = $this->getRequest()->getParam('id');
        $this->coreRegistry->register('current_brands_id', $brandsId);

        return $brandsId;
    }

    /**
     * Edit Brands
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $brandsId = $this->_initBrands();

        // 1. Initial checking
        if ($brandsId) {
            $model = $this->brandsRepository->getById($brandsId);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Brands no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        // 2. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        /**
         * Set active menu item
         */
        $resultPage->setActiveMenu('Animates_Brands::animatesbrands');

        $resultPage->addBreadcrumb(
            $brandsId ? __('Edit Brands') : __('New Brand'),
            $brandsId ? __('Edit Brands') : __('New Brand')
        );

        if ($brandsId) {
            $title =  __("Edit Brands '%1'", $model->getBrandName());
            $resultPage->getConfig()->getTitle()->prepend($title);
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('New Brand'));
        }

        return $resultPage;
    }
}
