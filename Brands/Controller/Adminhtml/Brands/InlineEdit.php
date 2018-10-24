<?php
namespace Animates\Brands\Controller\Adminhtml\Brands;

use Magento\Backend\App\Action\Context;
use \Animates\Brands\Api\BrandsRepositoryInterface as BrandsRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Animates\Brands\Api\Data\BrandsInterface;

/**
 * Class InlineEdit
 * @package Animates\Brands\Controller\Adminhtml\Brands
 */
class InlineEdit extends \Magento\Backend\App\Action
{
    /** @var BrandsRepository  */
    protected $brandsRepository;

    /** @var JsonFactory  */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param BrandsRepository $brandsRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        BrandsRepository $brandsRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->brandsRepository = $brandsRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $brandsId) {
                    /** @var \Animates\Brands\Model\Brands $brands */
                    $brands = $this->brandsRepository->getById($brandsId);
                    try {
                        $brands->setData(array_merge($brands->getData(), $postItems[$brandsId]));
                        $this->brandsRepository->save($brands);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithBrandsId(
                            $brands,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add brands to error message
     *
     * @param BrandsInterface $brands
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithBrandsId(BrandsInterface $brands, $errorText)
    {
        return '[Brands ID: ' . $brands->getId() . '] ' . $errorText;
    }
}
