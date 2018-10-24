<?php
namespace Animates\Brands\Api\Data;

/**
 * Brands interface.
 * @api
 */
interface BrandsInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID                    = 'brand_id';
    const BRAND_NAME            = 'brand_name';
    const BRAND_IMAGE           = 'brand_image';
    const DESCIRPTION           = 'description';
    const HEADER_IMAGE          = 'header_image';
    const IS_ACTIVE             = 'is_active';
    const CREATED_AT            = 'created_at';
    const UPDATED_AT            = 'updated_at';
    const BRAND_VALUE           = 'brand_value';
    const PET_TYPES             = 'pet_types';
    const BRAND_URL             = 'brand_url';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get Brand Name
     *
     * @return string|null
     */
    public function getBrandName();

    /**
     * Get brand image
     *
     * @return string|null
     */
    public function getBrandImage();

    /**
     * Get brand description
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Get brand Header image
     *
     * @return string|null
     */
    public function getHeaderImage();

    /**
     * Get is active
     *
     * @return int|null
     */
    public function getIsActive();

    /**
     * Get Created time
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Get Pet Types
     *
     * @return int[]
     */
    public function getPetTypes();

    /**
     * Get brand url
     *
     * @return string|null
     */
    public function getBrandUrl();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Animates\Brands\Api\Data\BrandsInterface
     */
    public function setId($id);

    /**
     * Set brand name
     *
     * @param string $brandName
     * @return \Animates\Brands\Api\Data\BrandsInterface
     */
    public function setBrandName($brandName);

    /**
     * Set brand image
     *
     * @param string $brandImage
     * @return \Animates\Brands\Api\Data\BrandsInterface
     */
    public function setBrandImage($brandImage);

    /**
     * Set brand description
     *
     * @param string $description
     * @return \Animates\Brands\Api\Data\BrandsInterface
     */
    public function setDescription($description);

    /**
     * Set brand Header image
     *
     * @param string $headerImage
     * @return \Animates\Brands\Api\Data\BrandsInterface
     */
    public function setHeaderImage($headerImage);

    /**
     * Set is Active
     *
     * @param int $isActive
     * @return \Animates\Brands\Api\Data\BrandsInterface
     */
    public function setIsActive($isActive);

    /**
     * Set created At
     *
     * @param string $createdAt
     * @return \Animates\Brands\Api\Data\BrandsInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Set update at
     *
     * @param string $updatedAt
     * @return \Animates\Brands\Api\Data\BrandsInterface
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Set Pet Types
     *
     * @param int[] $petTypes
     * @return \Animates\Brands\Api\Data\BrandsInterface
     */
    public function setPetTypes($petTypes);

    /**
     * Set brand url
     *
     * @param string $brandUrl
     * @return \Animates\Brands\Api\Data\BrandsInterface
     */
    public function setBrandUrl($brandUrl);
}
