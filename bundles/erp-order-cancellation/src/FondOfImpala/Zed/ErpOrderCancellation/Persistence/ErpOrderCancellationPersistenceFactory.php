<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Persistence;

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
        return new EntityToTransferMapper();
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
}
