<?php
namespace Animates\Brands\Model;

use Animates\Brands\Api\Data\BrandsInterface;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Class Brands
 * @package Animates\Brands\Model
 */
class Brands extends \Magento\Framework\Model\AbstractModel implements BrandsInterface, IdentityInterface
{
    /**
     * Brands cache tag
     */
    const CACHE_TAG = 'Brands';

    /**
     * Model Class constructor
     */
    protected function _construct()
    {
        $this->_init('Animates\Brands\Model\ResourceModel\Brands');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return parent::getData(self::ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getBrandName()
    {
        return parent::getData(self::BRAND_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function getBrandImage()
    {
        return parent::getData(self::BRAND_IMAGE);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return parent::getData(self::DESCIRPTION);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaderImage()
    {
        return parent::getData(self::HEADER_IMAGE);
    }

    /**
     * {@inheritdoc}
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function getPetTypes()
    {
        return parent::getData(self::PET_TYPES);
    }

    /**
     * {@inheritdoc}
     */
    public function getBrandUrl()
    {
        return parent::getData(self::BRAND_URL);
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function setBrandName($brandName)
    {
        return $this->setData(self::BRAND_NAME, $brandName);
    }

    /**
     * {@inheritdoc}
     */
    public function setBrandImage($brandImage)
    {
        return $this->setData(self::BRAND_IMAGE, $brandImage);
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCIRPTION, $description);
    }

    /**
     * {@inheritdoc}
     */
    public function setHeaderImage($headerImage)
    {
        return $this->setData(self::HEADER_IMAGE, $headerImage);
    }

    /**
     * {@inheritdoc}
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * {@inheritdoc}
     */
    public function setPetTypes($petTypes)
    {
        return $this->setData(self::PET_TYPES, $petTypes);
    }

    /**
     * {@inheritdoc}
     */
    public function setBrandUrl($brandUrl)
    {
        return $this->setData(self::BRAND_URL, $brandUrl);
    }
}
