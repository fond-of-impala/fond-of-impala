<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Persistence;

use FondOfImpala\Zed\AllowedProductQuantity\Persistence\Propel\Mapper\AllowedProductQuantityMapper;
use FondOfImpala\Zed\AllowedProductQuantity\Persistence\Propel\Mapper\AllowedProductQuantityMapperInterface;
use Orm\Zed\AllowedProductQuantity\Persistence\FoiAllowedProductQuantityQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantity\Persistence\AllowedProductQuantityEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\AllowedProductQuantity\AllowedProductQuantityConfig getConfig()
 * @method \FondOfImpala\Zed\AllowedProductQuantity\Persistence\AllowedProductQuantityRepositoryInterface getRepository()
 */
class AllowedProductQuantityPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\AllowedProductQuantity\Persistence\FoiAllowedProductQuantityQuery
     */
    public function createAllowedProductQuantityQuery(): FoiAllowedProductQuantityQuery
    {
        return FoiAllowedProductQuantityQuery::create();
    }

    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantity\Persistence\Propel\Mapper\AllowedProductQuantityMapperInterface
     */
    public function createAllowedProductQuantityMapper(): AllowedProductQuantityMapperInterface
    {
        return new AllowedProductQuantityMapper();
    }
}
