<?php

namespace FondOfImpala\Zed\ProductListConnector\Business\Manager;

use FondOfImpala\Zed\ProductListConnector\Persistence\ProductListConnectorEntityManagerInterface;
use FondOfImpala\Zed\ProductListConnector\Persistence\ProductListConnectorRepositoryInterface;
use Generated\Shared\Transfer\ProductConcreteTransfer;

class ProductListManager implements ProductListManagerInterface
{
    /**
     * @var \FondOfImpala\Zed\ProductListConnector\Persistence\ProductListConnectorRepositoryInterface
     */
    protected ProductListConnectorRepositoryInterface $repository;

    /**
     * @var \FondOfImpala\Zed\ProductListConnector\Persistence\ProductListConnectorEntityManagerInterface
     */
    protected ProductListConnectorEntityManagerInterface $entityManager;

    /**
     * @param \FondOfImpala\Zed\ProductListConnector\Persistence\ProductListConnectorRepositoryInterface $repository
     * @param \FondOfImpala\Zed\ProductListConnector\Persistence\ProductListConnectorEntityManagerInterface $entityManager
     */
    public function __construct(ProductListConnectorRepositoryInterface $repository, ProductListConnectorEntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function addProductToProductLists(ProductConcreteTransfer $productConcreteTransfer): void
    {
        $this->manageProductToProductListRelations($productConcreteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function updateProductToProductLists(ProductConcreteTransfer $productConcreteTransfer): void
    {
        $this->manageProductToProductListRelations($productConcreteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    protected function manageProductToProductListRelations(ProductConcreteTransfer $productConcreteTransfer): void
    {
        $productLists = $this->entityManager->findOrCreateProductLists($productConcreteTransfer->getProductLists());
        $productListsAlreadyIn = $this->repository->findProductListsByProductRelation($productConcreteTransfer->getIdProductConcrete())->getArrayCopy();

        $createRelation = [];

        foreach ($productLists->getArrayCopy() as $productListTransfer) {
            $key = $productListTransfer->getKey();
            if (array_key_exists($key, $productListsAlreadyIn)) {
                unset($productListsAlreadyIn[$key]);
                continue;
            }
            $createRelation[$key] = $productListTransfer;
        }

        foreach ($createRelation as $productList) {
            $this->entityManager->createProductToProductListRelation($productConcreteTransfer, $productList);
        }

        foreach ($productListsAlreadyIn as $productList) {
            $this->entityManager->deleteProductToProductListRelation($productConcreteTransfer, $productList);
        }

        $productConcreteTransfer->setProductLists($productLists);
    }
}
