<?php

namespace FondOfImpala\Zed\ProductProductListConnector\Persistence;

use ArrayObject;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductListTransfer;

interface ProductProductListConnectorEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductListTransfer $productListTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     *
     * @return \Generated\Shared\Transfer\ProductListTransfer
     */
    public function findOrCreateProductList(ProductListTransfer $productListTransfer): ProductListTransfer;

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\ProductListTransfer> $productListTransferCollection
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     *
     * @return \ArrayObject<string, \Generated\Shared\Transfer\ProductListTransfer>
     */
    public function findOrCreateProductLists(ArrayObject $productListTransferCollection): ArrayObject;

    /**
     * @param array $keys
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     *
     * @return array<string, \Generated\Shared\Transfer\ProductListTransfer>
     */
    public function findProductListByKeys(array $keys): array;

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param \Generated\Shared\Transfer\ProductListTransfer $productListTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException
     *
     * @return void
     */
    public function createProductToProductListRelation(ProductConcreteTransfer $productConcreteTransfer, ProductListTransfer $productListTransfer): void;

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param \Generated\Shared\Transfer\ProductListTransfer $productListTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return void
     */
    public function deleteProductToProductListRelation(ProductConcreteTransfer $productConcreteTransfer, ProductListTransfer $productListTransfer): void;
}
