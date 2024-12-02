<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Persistence;

use ArrayObject;
use FondOfImpala\Zed\ErpOrderCancellation\ErpOrderCancellationDependencyProvider;
use FondOfImpala\Zed\ErpOrderCancellation\Persistence\Propel\Expander\EntityToTransferExpander;
use FondOfImpala\Zed\ErpOrderCancellation\Persistence\Propel\Expander\EntityToTransferExpanderInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Persistence\Propel\Mapper\EntityToTransferMapper;
use FondOfImpala\Zed\ErpOrderCancellation\Persistence\Propel\Mapper\EntityToTransferMapperInterface;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationItemQuery;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationRepositoryInterface getRepository()
 */
class ErpOrderCancellationPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellation\Persistence\Propel\Mapper\EntityToTransferMapperInterface
     */
    public function createEntityToTransferMapper(): EntityToTransferMapperInterface
    {
        return new EntityToTransferMapper($this->createEntityToTransferExpander());
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellation\Persistence\Propel\Expander\EntityToTransferExpanderInterface
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function createEntityToTransferExpander(): EntityToTransferExpanderInterface
    {
        return new EntityToTransferExpander($this->getErpOrderCancellationEntityToTransferExpanderPlugin());
    }

    /**
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery
     */
    public function createErpOrderCancellationQuery(): FoiErpOrderCancellationQuery
    {
        return FoiErpOrderCancellationQuery::create()->clear();
    }

    /**
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationItemQuery
     */
    public function createErpOrderCancellationItemQuery(): FoiErpOrderCancellationItemQuery
    {
        return FoiErpOrderCancellationItemQuery::create()->clear();
    }

    /**
     * @return \ArrayObject<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\Persistence\ErpOrderCancellationTransferExpanderPluginInterface>
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getErpOrderCancellationEntityToTransferExpanderPlugin(): ArrayObject
    {
        return $this->getProvidedDependency(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_ENTITY_TO_TRANSFER_EXPANDER);
    }
}
