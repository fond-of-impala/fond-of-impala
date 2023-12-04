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
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     *
     * @return \ArrayObject<string,\Generated\Shared\Transfer\ProductListTransfer>
     */
    public function findProductListsByProductRelation(int $idProductConcrete): ArrayObject;
}
