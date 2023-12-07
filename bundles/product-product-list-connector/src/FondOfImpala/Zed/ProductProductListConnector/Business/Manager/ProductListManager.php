<?php

namespace FondOfImpala\Zed\ProductProductListConnector\Business\Manager;

use FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorEntityManagerInterface;
use FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorRepositoryInterface;
use Generated\Shared\Transfer\ProductConcreteTransfer;

class ProductListManager implements ProductListManagerInterface
{
    /**
     * @var \FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorRepositoryInterface
     */
    protected ProductProductListConnectorRepositoryInterface $repository;

    /**
     * @var \FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorEntityManagerInterface
     */
    protected ProductProductListConnectorEntityManagerInterface $entityManager;

    /**
     * @param \FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorRepositoryInterface $repository
     * @param \FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorEntityManagerInterface $entityManager
     */
    public function __construct(ProductProductListConnectorRepositoryInterface $repository, ProductProductListConnectorEntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return void
     */
    public function addProductToProductLists(ProductConcreteTransfer $productConcreteTransfer): void
    {
        $this->manageProductToProductListRelations($productConcreteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return void
     */
    public function updateProductToProductLists(ProductConcreteTransfer $productConcreteTransfer): void
    {
        $this->manageProductToProductListRelations($productConcreteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return void
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
