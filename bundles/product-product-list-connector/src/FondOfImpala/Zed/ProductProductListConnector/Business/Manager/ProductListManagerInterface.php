<?php

namespace FondOfImpala\Zed\ProductProductListConnector\Business\Manager;

use Generated\Shared\Transfer\ProductConcreteTransfer;

interface ProductListManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return void
     */
    public function addProductToProductLists(ProductConcreteTransfer $productConcreteTransfer): void;

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return void
     */
    public function updateProductToProductLists(ProductConcreteTransfer $productConcreteTransfer): void;
}
