<?php

namespace FondOfImpala\Zed\ProductListConnector\Persistence;

use ArrayObject;

/**
 * @method \FondOfImpala\Zed\ProductListConnector\Persistence\ProductListConnectorPersistenceFactory getFactory()
 */
interface ProductListConnectorRepositoryInterface
{
    /**
     * @param int $idProductConcrete
     * @return ArrayObject<string,\Generated\Shared\Transfer\ProductListTransfer>
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function findProductListsByProductRelation(int $idProductConcrete): ArrayObject;
}
