<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Cowell\Banner\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $table = $installer->getConnection()->newTable(
            $installer->getTable('manager_block')
        )->addColumn(
            'block_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Block ID'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Block Title'
        )->addColumn(
            'position',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Block String position'
        )->addColumn(
            'display',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '2M',
            [],
            'Block Content'
        )->addColumn(
            'category',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Block  Category Type'
        )->addColumn(
            'sort_order',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Block sort_order'
        )->addColumn(
            'creation_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'Block From'
        )->addColumn(
            'update_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
            'Block  To'
        )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Is Block Active'
        )->addIndex(
            $setup->getIdxName(
                $installer->getTable('manager_block'),
                ['title', 'position', 'display'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['title', 'position', 'display'],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->setComment(
            ' Block '
        );
        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()->newTable(
            $installer->getTable('block_customer_group')
        )->addColumn(
            'block_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'primary' => true],
            'Block ID'
        )->addColumn(
            'customer_group_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Customer Group ID'
        )->addForeignKey(
            $installer->getFkName('block_customer_group', 'block_id', 'manager_block', 'block_id'),
            'block_id',
            $installer->getTable('manager_block'),
            'block_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            ' Block Customer Table'
        );
        $installer->getConnection()->createTable($table);
        /**
         * Create table 'block_store'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('block_store')
        )->addColumn(
            'block_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'primary' => true],
            'Block ID'
        )->addColumn(
            'store_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Store ID'
        )->addForeignKey(
            $installer->getFkName('block_store', 'block_id', 'manager_block', 'block_id'),
            'block_id',
            $installer->getTable('manager_block'),
            'block_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('block_store', 'store_id', 'store', 'store_id'),
            'store_id',
            $installer->getTable('store'),
            'store_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            ' Block To Store Linkage Table'
        );
        $installer->getConnection()->createTable($table);
        /**
         * Create table 'cms_page'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('manager_banner')
        )->addColumn(
            'banner_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Banner ID'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Banner Title'
        )->addColumn(
            'image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Banner image'
        )->addColumn(
            'url',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Banner url'
        )->addColumn(
            'taget',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Banner Taget'
        )->addColumn(
            'description',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            ['nullable' => true],
            ' Meta Description'
        )->addColumn(
            'creation_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            ' Creation Time'
        )->addColumn(
            'update_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
            ' Modification Time'
        )->addColumn(
            'sort_order',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '0'],
            ' Sort Order'
        )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Is Banner Active'
        )->addIndex(
            $setup->getIdxName(
                $installer->getTable('manager_banner'),
                ['title', 'image', 'url', 'taget'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['title', 'image', 'url', 'taget'],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->setComment(
            ' banner Table'
        );
        $installer->getConnection()->createTable($table);
        $table = $installer->getConnection()->newTable(
            $installer->getTable('block_banner')
        )->addColumn(
            'block_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'primary' => true],
            'Block ID'
        )->addColumn(
            'banner_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'primary' => true],
            'Banner ID'
        )->addIndex(
            $installer->getIdxName('manager_banner', ['banner_id']),
            ['banner_id']
        )->addForeignKey(
            $installer->getFkName('manager_block', 'block_id', 'manager_block', 'block_id'),
            'block_id',
            $installer->getTable('manager_block'),
            'block_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('manager_banner', 'banner_id', 'manager_banner', 'banner_id'),
            'banner_id',
            $installer->getTable('manager_banner'),
            'banner_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            ' Block Customer Table'
        );
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}