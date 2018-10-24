<?php
namespace Animates\Brands\Model\ResourceModel\Brands\Relation\PetTypes;

use Magento\Framework\App\ResourceConnection;
use Animates\Brands\Api\Data\BrandsInterface;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;

/**
 * Class ReadHandler
 * @package Animates\Brands\Model\ResourceModel\Brands\Relation\PetTypes
 */
class ReadHandler implements ExtensionInterface
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var MetadataPool
     */
    private $metadataPool;

    /**
     * @param MetadataPool $metadataPool
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(MetadataPool $metadataPool, ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
        $this->metadataPool = $metadataPool;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute($entity, $arguments = [])
    {
        if ($entityId = (int)$entity->getId()) {
            $connection = $this->resourceConnection->getConnectionByName(
                $this->metadataPool->getMetadata(BrandsInterface::class)->getEntityConnectionName()
            );
            $select = $connection->select()
                ->from($this->resourceConnection->getTableName('animates_brands_pettype'), 'pettype_id')
                ->where('brand_id = :id');
            $petTypes = $connection->fetchCol($select, ['id' => $entityId]);
            $entity->setPetTypes($petTypes);
        }
        return $entity;
    }
}
