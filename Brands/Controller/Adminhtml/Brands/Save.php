<?php
namespace Animates\Brands\Controller\Adminhtml\Brands;

use \Animates\Brands\Model\BrandsFactory;
use \Animates\Brands\Api\BrandsRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class Save
 * @package Animates\Brands\Controller\Adminhtml\Brands
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var BrandsFactory
     */
    protected $brandsFactory;

    /**
     * @var BrandsRepositoryInterface
     */
    protected $brandsRepository;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Animates\Brands\Model\ImageUploader
     */
    protected $imageUploader;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param BrandsFactory $brandsFactory
     * @param BrandsRepositoryInterface $brandsRepository
     * @param DataPersistorInterface $dataPersistor
     * @param \Animates\Brands\Model\ImageUploader $imageUploader
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        BrandsFactory $brandsFactory,
        BrandsRepositoryInterface $brandsRepository,
        DataPersistorInterface $dataPersistor,
        \Animates\Brands\Model\ImageUploader $imageUploader
    ) {
        $this->brandsRepository = $brandsRepository;
        $this->brandsFactory = $brandsFactory;
        $this->dataPersistor = $dataPersistor;
        $this->imageUploader = $imageUploader;

        parent::__construct($context);
    }

    /**
     * Filter brands data
     *
     * @param array $rawData
     * @return array
     */
    protected function _filterBrandsPostData(array $rawData)
    {
        $data = $rawData;
        if (isset($data['brand_image']) && is_array($data['brand_image'])) {
            if (!empty($data['brand_image']['delete'])) {
                $data['brand_image'] = null;
            } else {
                if (isset($data['brand_image'][0]['name']) && isset($data['brand_image'][0]['tmp_name'])) {
                    $data['brand_image'] = $data['brand_image'][0]['name'];
                } else {
                    unset($data['brand_image']);
                }
            }
        }

        if (isset($data['header_image']) && is_array($data['header_image'])) {
            if (!empty($data['header_image']['delete'])) {
                $data['header_image'] = null;
            } else {
                if (isset($data['header_image'][0]['name']) && isset($data['header_image'][0]['tmp_name'])) {
                    $data['header_image'] = $data['header_image'][0]['name'];
                } else {
                    unset($data['header_image']);
                }
            }
        }
        return $data;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if($data) {
            $id = !empty($data['brand_id']) ? $data['brand_id'] : null;
            $data = $this->imagePreprocessing($data);
            $data = $this->_filterBrandsPostData($data);

            try {
                if ($id) {
                    $model = $this->brandsRepository->getById((int)$id);
                } else {
                    unset($data['brand_id']);
                    $model = $this->brandsFactory->create();
                }

                if(isset($data['brand_image']) && ($data['brand_image'])) {
                    $this->imageUploader->moveFileFromTmp($data['brand_image']);
                }

                if(isset($data['header_image']) && ($data['header_image'])) {
                    $this->imageUploader->moveFileFromTmp($data['header_image']);
                }

                $model->setData($data);
                $this->brandsRepository->save($model);
                $this->dataPersistor->clear('brands');

                $this->messageManager->addSuccessMessage(__('You saved the brand'));
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('There was a problem saving the brand'));
            }

            $this->dataPersistor->set('brands', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Image data preprocessing
     *
     * @param array $data
     *
     * @return array
     */
    public function imagePreprocessing($data)
    {
        if (empty($data['brand_image'])) {
            unset($data['brand_image']);
            $data['brand_image']['delete'] = true;
        } else if((isset($data['brand_id'])) && (!$data['brand_id'])) {
            if (isset($data['brand_image']) && is_array($data['brand_image'])) {
                if (isset($data['brand_image'][0]['name']) && !isset($data['brand_image'][0]['tmp_name'])) {
                    $data['brand_image'] = $data['brand_image'][0]['name'];
                }
            }
        }

        if (empty($data['header_image'])) {
            unset($data['header_image']);
            $data['header_image']['delete'] = true;
        } else if((isset($data['brand_id'])) && (!$data['brand_id'])) {
            if (isset($data['header_image']) && is_array($data['header_image'])) {
                if (isset($data['header_image'][0]['name']) && !isset($data['header_image'][0]['tmp_name'])) {
                    $data['header_image'] = $data['header_image'][0]['name'];
                }
            }
        }
        return $data;
    }
}
