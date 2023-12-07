<?php

namespace FondOfImpala\Zed\ProductProductListConnector\Persistence;

use ArrayObject;

/**
 * @method \FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorPersistenceFactory getFactory()
 */
interface ProductProductListConnectorRepositoryInterface
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
