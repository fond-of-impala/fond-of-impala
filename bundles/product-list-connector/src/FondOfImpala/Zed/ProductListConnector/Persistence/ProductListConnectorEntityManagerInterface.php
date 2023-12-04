<?php

namespace FondOfImpala\Zed\ProductListConnector\Persistence;

use ArrayObject;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductListTransfer;

interface ProductListConnectorEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductListTransfer $productListTransfer
     * @return \Generated\Shared\Transfer\ProductListTransfer
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function findOrCreateProductList(ProductListTransfer $productListTransfer): ProductListTransfer;

    /**
     * @param ArrayObject<\Generated\Shared\Transfer\ProductListTransfer> $productListTransferCollection
     * @return ArrayObject<string, \Generated\Shared\Transfer\ProductListTransfer>
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function findOrCreateProductLists(ArrayObject $productListTransferCollection): ArrayObject;

    /**
     * @param array $keys
     * @return array<string, ProductListTransfer>
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function findProductListByKeys(array $keys): array;

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param \Generated\Shared\Transfer\ProductListTransfer $productListTransfer
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException
     */
    public function createProductToProductListRelation(ProductConcreteTransfer $productConcreteTransfer, ProductListTransfer $productListTransfer): void;

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param \Generated\Shared\Transfer\ProductListTransfer $productListTransfer
     * @return void
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function deleteProductToProductListRelation(ProductConcreteTransfer $productConcreteTransfer, ProductListTransfer $productListTransfer): void;
}
