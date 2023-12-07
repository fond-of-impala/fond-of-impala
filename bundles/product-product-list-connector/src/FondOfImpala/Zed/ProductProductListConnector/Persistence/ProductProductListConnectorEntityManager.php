<?php

namespace FondOfImpala\Zed\ProductProductListConnector\Persistence;

use ArrayObject;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductListTransfer;
use Orm\Zed\ProductList\Persistence\SpyProductListProductConcrete;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorPersistenceFactory getFactory()
 */
class ProductProductListConnectorEntityManager extends AbstractEntityManager implements ProductProductListConnectorEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductListTransfer $productListTransfer
     *
     * @return \Generated\Shared\Transfer\ProductListTransfer
     */
    public function findOrCreateProductList(ProductListTransfer $productListTransfer): ProductListTransfer
    {
        $productListTransfer->requireKey()->requireTitle();

        $query = $this->getFactory()->getSpyProductListQuery();
        $result = $query->filterByKey($productListTransfer->getKey())->findOneOrCreate();

        if ($result->isNew()) {
            $result->setTitle($productListTransfer->getTitle())->setType('whitelist')->save();
        }

        return (new ProductListTransfer())->fromArray($result->toArray(), true);
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\ProductListTransfer> $productListTransferCollection
     *
     * @return \ArrayObject<string, \Generated\Shared\Transfer\ProductListTransfer>
     */
    public function findOrCreateProductLists(ArrayObject $productListTransferCollection): ArrayObject
    {
        $availableProductLists = $this->findProductListByKeys($this->resolveKeysFromProductListCollection($productListTransferCollection));

        foreach ($productListTransferCollection as $productListTransfer) {
            if (!array_key_exists($productListTransfer->getKey(), $availableProductLists)) {
                $productList = $this->findOrCreateProductList($productListTransfer);
                $availableProductLists[$productList->getKey()] = $productList;
            }
        }

        return new ArrayObject($availableProductLists);
    }

    /**
     * @param array $keys
     *
     * @return array<string, \Generated\Shared\Transfer\ProductListTransfer>
     */
    public function findProductListByKeys(array $keys): array
    {
        $productLists = [];
        $query = $this->getFactory()->getSpyProductListQuery();
        $result = $query->filterByKey_In($keys)->find();

        foreach ($result->getData() as $resultData) {
            $productList = (new ProductListTransfer())->fromArray($resultData->toArray(), true);
            $productLists[$productList->getKey()] = $productList;
        }

        return $productLists;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param \Generated\Shared\Transfer\ProductListTransfer $productListTransfer
     *
     * @return void
     */
    public function createProductToProductListRelation(ProductConcreteTransfer $productConcreteTransfer, ProductListTransfer $productListTransfer): void
    {
        $productListTransfer->requireIdProductList();
        $productConcreteTransfer->requireIdProductConcrete();

        (new SpyProductListProductConcrete())
            ->setFkProductList($productListTransfer->getIdProductList())
            ->setFkProduct($productConcreteTransfer->getIdProductConcrete())
            ->save();
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param \Generated\Shared\Transfer\ProductListTransfer $productListTransfer
     *
     * @return void
     */
    public function deleteProductToProductListRelation(ProductConcreteTransfer $productConcreteTransfer, ProductListTransfer $productListTransfer): void
    {
        $query = $this->getFactory()->getSpyProductListProductConcreteQuery();
        $query->filterByFkProduct($productConcreteTransfer->getIdProductConcrete())->filterByFkProductList($productListTransfer->getIdProductList())->delete();
    }

    /**
     * @param \ArrayObject $productListTransferCollection
     *
     * @return array
     */
    protected function resolveKeysFromProductListCollection(ArrayObject $productListTransferCollection): array
    {
        $keys = [];
        foreach ($productListTransferCollection as $productListTransfer) {
            $keys[] = $productListTransfer->getKey();
        }

        return $keys;
    }
}
