<?php
namespace Animates\Brands\Model\ResourceModel\Brands\Relation\PetTypes;

use Magento\Framework\App\ResourceConnection;
use Animates\Brands\Api\Data\BrandsInterface;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;

/**
 * Class SaveHandler
 * @package Animates\Brands\Model\ResourceModel\Brands\Relation\PetTypes
 */
class SaveHandler implements ExtensionInterface
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
        $entityId = (int)$entity->getId();

        $petTypes = $entity->getPetTypes() ? : [];
        $petTypesOrig = $this->getPetTypes($entityId);
        $toInsert = array_diff($petTypes, $petTypesOrig);
        $toDelete = array_diff($petTypesOrig, $petTypes);

        $connection = $this->getConnection();
        $tableName = $this->resourceConnection->getTableName('animates_brands_pettype');

        if ($toInsert) {
            $data = [];
            foreach ($toInsert as $petType) {
                $data[] = [
                    'brand_id' => (int)$entityId,
                    'pettype_id' => (int)$petType,
                ];
            }
            $connection->insertMultiple($tableName, $data);
        }
        if (count($toDelete)) {
            $connection->delete(
                $tableName,
                ['brand_id = ?' => $entityId, 'pettype_id IN (?)' => $toDelete]
            );
        }
        return $entity;
    }

    /**
     * Get petypes to which entity is assigned
     *
     * @param int $entityId
     * @return array
     */
    private function getPetTypes($entityId)
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->resourceConnection->getTableName('animates_brands_pettype'), 'pettype_id')
            ->where('brand_id = :id');
        return $connection->fetchCol($select, ['id' => $entityId]);
    }

    /**
     * Get connection
     *
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     * @throws \Exception
     */
    private function getConnection()
    {
        return $this->resourceConnection->getConnectionByName(
            $this->metadataPool->getMetadata(BrandsInterface::class)->getEntityConnectionName()
        );
    }
}
