<?php
namespace Animates\Brands\Controller\Adminhtml\Brands;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Delete
 * @package Animates\Brands\Controller\Adminhtml\Brands
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Animates\Brands\Api\BrandsRepositoryInterface
     */
    protected $brandsRepository;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Animates\Brands\Api\BrandsRepositoryInterface $brandsRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Animates\Brands\Api\BrandsRepositoryInterface $brandsRepository
    ){

        $this->brandsRepository = $brandsRepository;
        parent::__construct($context);
    }
    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $this->brandsRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('The brand has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('The brand no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/brands/edit', ['id' => $id]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('There was a problem deleting the brand'));
                return $resultRedirect->setPath('*/brands/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a brand to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
