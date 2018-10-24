<?php
namespace Animates\Brands\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Upgrade the Brand module DB scheme
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '2.0.2', '<')) {
            $this->createBrandsPetTypeRelationTable($setup);
        }

        if (version_compare($context->getVersion(), '2.0.3', '<')) {
            $this->addDescriptionColumnBrandsTable($setup);
        }

        if (version_compare($context->getVersion(), '2.0.4', '<')) {
            $this->addUrlColumnBrandsTable($setup);
        }
    }

    /**
     * @param $setup
     */
    public function createBrandsPetTypeRelationTable($setup)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('animates_brands_pettype'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'ID'
            )
            ->addColumn(
                'brand_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Brand ID'
            )
            ->addColumn(
                'pettype_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'PetType Id'
            )
            ->addIndex(
                $installer->getIdxName(
                    'animates_brands_pettype',
                    ['pettype_id', 'brand_id'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['pettype_id', 'brand_id'],
                ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
            )
            ->addIndex(
                $installer->getIdxName('animates_brands_pettype', ['pettype_id']),
                ['pettype_id']
            )
            ->addForeignKey(
                $installer->getFkName(
                    'animates_brands_pettype',
                    'brand_id',
                    'animates_brands',
                    'brand_id'
                ),
                'brand_id',
                $installer->getTable('animates_brands'),
                'brand_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->setComment('Animates Brands PetType Relation');

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }

    /**
     * @param $setup
     */
    public function addDescriptionColumnBrandsTable($setup)
    {
        $installer = $setup;
        $installer->startSetup();
        $installer->getConnection()->addColumn(
            $installer->getTable('animates_brands'),
            'description',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => '2M',
                'nullable' => true,
                'comment' => 'Description',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('animates_brands'),
            'header_image',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => true,
                'comment' => 'Header Image',
            ]
        );

        $setup->endSetup();
    }

    /**
     * @param $setup
     */
    public function addUrlColumnBrandsTable($setup)
    {
        $installer = $setup;
        $installer->startSetup();

        $installer->getConnection()->addColumn(
            $installer->getTable('animates_brands'),
            'brand_url',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => false,
                'comment' => 'URL',
            ]
        );

        $setup->endSetup();
    }
}
