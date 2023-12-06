<?php

namespace FondOfImpala\Zed\ProductProductListConnector\Persistence;

use ArrayObject;
use Generated\Shared\Transfer\ProductListTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorPersistenceFactory getFactory()
 */
class ProductProductListConnectorRepository extends AbstractRepository implements ProductProductListConnectorRepositoryInterface
{
    /**
     * @param int $idProductConcrete
     *
     * @return \ArrayObject<string,\Generated\Shared\Transfer\ProductListTransfer>
     */
    public function findProductListsByProductRelation(int $idProductConcrete): ArrayObject
    {
        $productLists = [];
        $query = $this->getFactory()->getSpyProductListQuery();

        $query
            ->useSpyProductListProductConcreteQuery()
                ->filterByFkProduct($idProductConcrete)
            ->endUse();
        $result = $query->find();

        /** @var \Orm\Zed\ProductList\Persistence\SpyProductListProductConcrete $spyProductList */
        foreach ($result->getData() as $spyProductList) {
            $productList = (new ProductListTransfer())->fromArray($spyProductList->toArray(), true);
            $productLists[$productList->getKey()] = $productList;
        }

        return new ArrayObject($productLists);
    }
}
