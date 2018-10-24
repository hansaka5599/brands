<?php
namespace Animates\Brands\Controller\Adminhtml\Brands;

/**
 * Class Index
 * @package Animates\Brands\Controller\Adminhtml\Brands
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        /**
         * Set active menu item
         */
        $resultPage->setActiveMenu('Animates_Brands::animatesbrands');
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Brands'));

        /**
         * Add breadcrumb item
         */
        $resultPage->addBreadcrumb(__('Manage Brands'), __('Manage Brands'));

        return $resultPage;
    }
}
